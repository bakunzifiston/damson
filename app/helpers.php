<?php

if (! function_exists('damson_asset')) {
    /**
     * Public static assets (images, build files). On some cPanel setups use DAMSON_ASSET_PREFIX=public.
     */
    function damson_asset(string $path): string
    {
        $path = ltrim($path, '/');
        $prefix = trim((string) config('damson.asset_prefix', ''), '/');

        if ($prefix !== '') {
            return '/'.$prefix.'/'.$path;
        }

        return asset($path);
    }
}

if (! function_exists('damson_storage_url')) {
    /**
     * Uploaded files in storage/app/public (product images, etc.).
     */
    function damson_storage_url(?string $path): ?string
    {
        if ($path === null || $path === '') {
            return null;
        }

        $path = ltrim($path, '/');
        $prefix = trim((string) config('damson.asset_prefix', ''), '/');

        if ($prefix !== '') {
            return '/'.$prefix.'/storage/'.$path;
        }

        return '/storage/'.$path;
    }
}
