<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Filters extends BaseConfig
{
    public array $aliases = [
        'csrf' => \CodeIgniter\Filters\CSRF::class,
        'toolbar' => \CodeIgniter\Filters\DebugToolbar::class,
        'honeypot' => \CodeIgniter\Filters\Honeypot::class,
        'auth' => \App\Filters\AuthFilter::class,
        'adminAuth' => \App\Filters\AdminAuthFilter::class,
    ];

    public array $globals = [
        'before' => [],
        'after' => [],
    ];

    public array $methods = [
        'post' => [], // CSRF not applied globally - added per-form only
    ];

    //public array $methods = [];
    public array $filters = [];
}