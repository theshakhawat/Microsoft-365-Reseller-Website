<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'group',
    ];

    /**
     * Cache key for all settings
     */
    const CACHE_KEY = 'app_site_settings_all';

    /**
     * Get a setting by key with optional fallback.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $all = static::getAllSettings();

        if (array_key_exists($key, $all) && $all[$key] !== null && $all[$key] !== '') {
            return $all[$key];
        }

        return $default;
    }

    /**
     * Check if a setting is enabled (1, '1', true, 'true', 'on', 'yes')
     */
    public static function isEnabled(string $key, bool $default = true): bool
    {
        $val = static::get($key, $default ? '1' : '0');
        return in_array($val, [1, '1', true, 'true', 'on', 'yes'], true);
    }

    /**
     * Set a setting value by key.
     */
    public static function set(string $key, mixed $value, string $group = 'general'): self
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group' => $group]
        );

        static::clearCache();

        return $setting;
    }

    /**
     * Retrieve all settings as key => value array from cache.
     */
    public static function getAllSettings(): array
    {
        return Cache::rememberForever(static::CACHE_KEY, function () {
            try {
                return static::pluck('value', 'key')->toArray();
            } catch (\Throwable $e) {
                return [];
            }
        });
    }

    /**
     * Get URL for file-based setting (Logo, Favicon, OG Image).
     */
    public static function fileUrl(string $key, ?string $fallback = null): ?string
    {
        $val = static::get($key, $fallback);

        if (empty($val)) {
            return $fallback ? asset($fallback) : null;
        }

        if (str_starts_with($val, 'http://') || str_starts_with($val, 'https://')) {
            return $val;
        }

        if (str_starts_with($val, 'storage/') || str_starts_with($val, 'assets/')) {
            return asset($val);
        }

        return asset('storage/' . ltrim($val, '/'));
    }

    /**
     * Clear settings cache.
     */
    public static function clearCache(): void
    {
        Cache::forget(static::CACHE_KEY);
    }

    /**
     * Model booted event
     */
    protected static function booted()
    {
        static::saved(function () {
            static::clearCache();
        });

        static::deleted(function () {
            static::clearCache();
        });
    }
}
