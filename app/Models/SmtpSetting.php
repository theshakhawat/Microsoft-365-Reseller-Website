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
     * Get or initialize default SMTP settings
     */
    public static function getSettings(): self
    {
        $setting = self::first();

        if (!$setting) {
            $setting = self::create([
                'mail_mailer'       => env('MAIL_MAILER', 'smtp'),
                'mail_host'         => env('MAIL_HOST', 'smtp.gmail.com'),
                'mail_port'         => (int) env('MAIL_PORT', 587),
                'mail_username'     => env('MAIL_USERNAME', ''),
                'mail_password'     => env('MAIL_PASSWORD', ''),
                'mail_encryption'   => env('MAIL_ENCRYPTION', env('MAIL_SCHEME', 'tls')),
                'mail_from_address' => env('MAIL_FROM_ADDRESS', 'support@microsoftoffice.club'),
                'mail_from_name'    => env('MAIL_FROM_NAME', config('app.name', 'Microsoft Office Club')),
                'is_active'         => true,
            ]);
        }

        return $setting;
    }

    /**
     * Apply database mail configuration dynamically to Laravel config
     */
    public static function applyConfig(): void
    {
        try {
            if (!Schema::hasTable('smtp_settings')) {
                return;
            }

            $setting = self::where('is_active', true)->first();

            if ($setting) {
                $driver = $setting->mail_mailer ?: 'smtp';
                Config::set('mail.default', $driver);

                if ($driver === 'smtp') {
                    $rawEnc = strtolower(trim((string) ($setting->mail_encryption ?? '')));
                    $scheme = null;
                    $encryption = null;

                    if (in_array($rawEnc, ['ssl', 'smtps']) || (int) $setting->mail_port === 465) {
                        $scheme = 'smtps';
                        $encryption = 'ssl';
                    } elseif (in_array($rawEnc, ['tls', 'starttls']) || (int) $setting->mail_port === 587) {
                        $scheme = null; // STARTTLS over standard smtp transport
                        $encryption = 'tls';
                    }

                    Config::set('mail.mailers.smtp.transport', 'smtp');
                    Config::set('mail.mailers.smtp.host', $setting->mail_host ?: '127.0.0.1');
                    Config::set('mail.mailers.smtp.port', (int) ($setting->mail_port ?: 587));
                    Config::set('mail.mailers.smtp.username', $setting->mail_username ?: null);
                    Config::set('mail.mailers.smtp.password', $setting->mail_password ?: null);
                    Config::set('mail.mailers.smtp.encryption', $encryption);
                    Config::set('mail.mailers.smtp.scheme', $scheme);
                }

                if (!empty($setting->mail_from_address)) {
                    Config::set('mail.from.address', $setting->mail_from_address);
                }
                if (!empty($setting->mail_from_name)) {
                    Config::set('mail.from.name', $setting->mail_from_name);
                }

                // Purge resolved mailer instance so fresh config is used
                try {
                    Mail::purge($driver);
                    Mail::purge('smtp');
                } catch (\Throwable $e) {
                    // Ignore if mailer hasn't been instantiated yet
                }
            }
        } catch (\Throwable $e) {
            // Failsafe during setup or migrations
        }
    }
}

