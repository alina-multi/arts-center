<?php

namespace App\Helpers;

use Illuminate\Support\Facades\App;
use function PHPUnit\Framework\stringEndsWith;

class UrlHelper
{
    static function localePath($path)
    {
        $locale = App::getLocale();
        return rtrim(
            config('app.frontend_url') .
            ($locale === 'en' ? '' : "/$locale") .
            $path,
            '/');
    }
}