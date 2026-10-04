<?php

use App\Models\SiteSetting;

if (!function_exists('site_setting')) {
    /**
     * Get site setting by key.
     */
    function site_setting(string $key, mixed $default = null): mixed
    {
        return SiteSetting::get($key, $default);
    }
}

if (!function_exists('site_file_url')) {
    /**
     * Get URL for file-based site setting.
     */
    function site_file_url(string $key, ?string $fallback = null): ?string
    {
        return SiteSetting::fileUrl($key, $fallback);
    }
}

if (!function_exists('site_is_enabled')) {
    /**
     * Check if site boolean setting is enabled.
     */
    function site_is_enabled(string $key, bool $default = true): bool
    {
        return SiteSetting::isEnabled($key, $default);
    }
}
