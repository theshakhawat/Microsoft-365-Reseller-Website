<?php

use App\Models\SiteSetting;

if (!function_exists('site_setting')) {
    /**
     * Get site setting by key.
     */
    function site_setting(string $key, mixed $default = null): mixed
    {
        try {
            return SiteSetting::get($key, $default);
        } catch (\Throwable $e) {
            return $default;
        }
    }
}

if (!function_exists('site_file_url')) {
    /**
     * Get URL for file-based site setting.
     */
    function site_file_url(string $key, ?string $fallback = null): ?string
    {
        try {
            return SiteSetting::fileUrl($key, $fallback);
        } catch (\Throwable $e) {
            return $fallback ? asset($fallback) : null;
        }
    }
}

if (!function_exists('site_is_enabled')) {
    /**
     * Check if site boolean setting is enabled.
     */
    function site_is_enabled(string $key, bool $default = true): bool
    {
        try {
            return SiteSetting::isEnabled($key, $default);
        } catch (\Throwable $e) {
            return $default;
        }
    }
}
