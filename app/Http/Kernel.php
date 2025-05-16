<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    // …

    protected $routeMiddleware = [
        // …
        'basic.admin'  => \App\Http\Middleware\BasicAdmin::class,
    ];
}
