<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;

class SmtpSetting extends Model
{
    protected $fillable = [
        'mail_mailer',
        'mail_host',
        'mail_port',
        'mail_username',
        'mail_password',
        'mail_encryption',
        'mail_from_address',
        'mail_from_name',
        'is_active',
    ];

    protected $casts = [
        'mail_port' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Get or initialize default SMTP settings strictly from database
     */
    public static function getSettings(): self
    {
        $setting = self::first();

        if (!$setting) {
            $setting = self::create([
                'mail_mailer'       => 'smtp',
                'mail_host'         => 'mail.microsoftoffice.club',
                'mail_port'         => 465,
                'mail_username'     => 'support@microsoftoffice.club',
                'mail_password'     => 'P4Tifv05Ib3N2apf',
                'mail_encryption'   => 'ssl',
                'mail_from_address' => 'support@microsoftoffice.club',
                'mail_from_name'    => 'Microsoft Office Club',
                'is_active'         => true,
            ]);
        }

        return $setting;
    }

    /**
     * Apply database mail configuration dynamically to Laravel config
     * Overrides all .env configuration with values from database table.
     */
    public static function applyConfig(): void
    {
        try {
            if (!Schema::hasTable('smtp_settings')) {
                return;
            }

            $setting = self::getSettings();

            if ($setting) {
                $driver = strtolower(trim((string) ($setting->mail_mailer ?: 'smtp')));
                Config::set('mail.default', $driver);

                if ($driver === 'smtp') {
                    $rawEnc = strtolower(trim((string) ($setting->mail_encryption ?? '')));
                    $port = (int) ($setting->mail_port ?: 465);

                    // Determine Scheme & Encryption
                    $scheme = 'smtp';
                    $encryption = null;

                    if ($rawEnc === 'ssl' || $rawEnc === 'smtps' || $port === 465) {
                        $scheme = 'smtps';
                        $encryption = 'ssl';
                    } elseif ($rawEnc === 'tls' || $rawEnc === 'starttls' || $port === 587) {
                        $scheme = 'smtp';
                        $encryption = 'tls';
                    }

                    $smtpConfig = [
                        'transport'    => 'smtp',
                        'scheme'       => $scheme,
                        'host'         => trim((string) $setting->mail_host),
                        'port'         => $port,
                        'username'     => trim((string) $setting->mail_username),
                        'password'     => (string) $setting->mail_password,
                        'encryption'   => $encryption,
                        'timeout'      => 30,
                        'local_domain' => parse_url((string) config('app.url', 'http://localhost'), PHP_URL_HOST) ?: 'localhost',
                    ];

                    Config::set('mail.mailers.smtp', $smtpConfig);
                }

                if (!empty($setting->mail_from_address)) {
                    Config::set('mail.from.address', trim($setting->mail_from_address));
                }
                if (!empty($setting->mail_from_name)) {
                    Config::set('mail.from.name', trim($setting->mail_from_name));
                }

                // Force purge mailer cache so fresh database credentials take effect immediately
                try {
                    Mail::purge($driver);
                    Mail::purge('smtp');
                    Mail::purge();
                } catch (\Throwable $e) {
                    // Ignore if mailer hasn't been instantiated yet
                }
            }
        } catch (\Throwable $e) {
            // Failsafe during setup or migrations
        }
    }
}
