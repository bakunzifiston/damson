<?php

namespace App\Support;

class DamsonAssets
{
    public static function publicPrefix(): string
    {
        $prefix = config('damson.public_prefix');

        if ($prefix !== null && $prefix !== '') {
            return trim((string) $prefix, '/');
        }

        $host = parse_url((string) config('app.url'), PHP_URL_HOST);

        if ($host && ! in_array($host, ['localhost', '127.0.0.1', '[::1]'], true)) {
            return 'public';
        }

        return '';
    }

    public static function image(string $path): string
    {
        $path = ltrim($path, '/');
        $prefix = self::publicPrefix();

        if ($prefix !== '') {
            return '/'.$prefix.'/'.$path;
        }

        return asset($path);
    }

    public static function storage(string $path): string
    {
        $path = ltrim($path, '/');
        $prefix = self::publicPrefix();

        if ($prefix !== '') {
            return '/'.$prefix.'/storage/'.$path;
        }

        return '/storage/'.$path;
    }
}
