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

if (!function_exists('site_custom_css')) {
    /**
     * Get rendered custom CSS for <head>.
     */
    function site_custom_css(): string
    {
        try {
            $css = site_setting('custom_css', '');
            if (empty($css)) {
                return '';
            }
            $trimmed = trim($css);
            if (str_starts_with($trimmed, '<style') || str_contains($trimmed, '</style>')) {
                return $trimmed . "\n";
            }
            return "<style id=\"site-custom-css\">\n" . $trimmed . "\n</style>\n";
        } catch (\Throwable $e) {
            return '';
        }
    }
}

if (!function_exists('site_custom_head_scripts')) {
    /**
     * Get rendered custom head scripts and JS.
     */
    function site_custom_head_scripts(): string
    {
        try {
            $scripts = site_setting('custom_head_scripts', '');
            if (empty($scripts)) {
                return '';
            }
            $trimmed = trim($scripts);
            // Fix any common typos like </scritp> or <scritp>
            $fixed = preg_replace('/<\/\s*scritp\s*>/i', '</script>', $trimmed);
            $fixed = preg_replace('/<\s*scritp\s*>/i', '<script>', $fixed);

            if (str_starts_with($fixed, '<') || str_contains($fixed, '</') || str_starts_with($fixed, '<!--')) {
                return $fixed . "\n";
            }
            return "<script id=\"site-custom-head-js\">\n" . $fixed . "\n</script>\n";
        } catch (\Throwable $e) {
            return '';
        }
    }
}

if (!function_exists('site_custom_footer_scripts')) {
    /**
     * Get rendered custom footer scripts and JS.
     */
    function site_custom_footer_scripts(): string
    {
        try {
            $output = '';

            // Custom JS if set
            $customJs = site_setting('custom_js', '');
            if (!empty($customJs)) {
                $trimmedJs = trim($customJs);
                $fixedJs = preg_replace('/<\/\s*scritp\s*>/i', '</script>', $trimmedJs);
                $fixedJs = preg_replace('/<\s*scritp\s*>/i', '<script>', $fixedJs);

                if (str_starts_with($fixedJs, '<') || str_contains($fixedJs, '</') || str_starts_with($fixedJs, '<!--')) {
                    $output .= $fixedJs . "\n";
                } else {
                    $output .= "<script id=\"site-custom-footer-js\">\n" . $fixedJs . "\n</script>\n";
                }
            }

            // Custom Footer Scripts
            $scripts = site_setting('custom_footer_scripts', '');
            if (!empty($scripts)) {
                $trimmed = trim($scripts);
                $fixed = preg_replace('/<\/\s*scritp\s*>/i', '</script>', $trimmed);
                $fixed = preg_replace('/<\s*scritp\s*>/i', '<script>', $fixed);

                if (str_starts_with($fixed, '<') || str_contains($fixed, '</') || str_starts_with($fixed, '<!--')) {
                    $output .= $fixed . "\n";
                } else {
                    $output .= "<script id=\"site-custom-footer-scripts\">\n" . $fixed . "\n</script>\n";
                }
            }

            return $output;
        } catch (\Throwable $e) {
            return '';
        }
    }
}

