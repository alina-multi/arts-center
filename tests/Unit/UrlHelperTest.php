<?php
use \App\Helpers\UrlHelper;
it('localePath', function () {
    expect(UrlHelper::localePath('/me/'))->toEqual('http://localhost:8000/me');
    \Illuminate\Support\Facades\App::setLocale('uk');
    expect(UrlHelper::localePath('/me/'))->toEqual('http://localhost:8000/uk/me');
});
