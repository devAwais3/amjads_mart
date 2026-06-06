<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class App extends BaseConfig
{
    public string $baseURL = 'http://localhost/amjads_mart/public/';
    public array $allowedHostnames = [];
    public string $indexPage = '';
    public string $uriProtocol = 'REQUEST_URI';
    public array $proxyIPs = [];
    // REQUIRED (THIS WAS MISSING IN YOUR FILE)
    public string $permittedURIChars = 'a-z 0-9~%.:_\-';
    public string $defaultLocale = 'en';
    public bool $negotiateLocale = false;
    public array $supportedLocales = ['en'];
    public string $appTimezone = 'Asia/Karachi';
    public string $charset = 'UTF-8';
    public bool $forceGlobalSecureRequests = false;

    // Sessions
    public string $sessionDriver            = 'CodeIgniter\Session\Handlers\FileHandler';
    public string $sessionCookieName        = 'amjads_session';
    public int $sessionExpiration           = 7200;
    public string $sessionSavePath          = WRITEPATH . 'session';
    public bool $sessionMatchIP             = false;
    public bool $sessionTimeToUpdate        = true;
    public bool $sessionRegenerateDestroy   = false;

    // Cookies
    public string $cookiePrefix   = '';
    public string $cookieDomain   = '';
    public string $cookiePath     = '/';
    public bool $cookieSecure     = false;
    public bool $cookieHTTPOnly   = false;
    public string $cookieSameSite = 'Lax';
    //public string $encryptionKey = 'AmjadsMart2024SecureKey32Chars!!';
    public bool $CSPEnabled = false;
}