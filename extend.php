<?php

use Flarum\Extend;
use Uoi\FlarumCasSso\Controller\CasLoginController;
use Uoi\FlarumCasSso\Controller\CasLogoutController;

return [
    (new Extend\Routes('forum'))
        ->get('/auth/cas', 'uoi.cas.login', CasLoginController::class)
        ->get('/auth/cas/logout', 'uoi.cas.logout', CasLogoutController::class),

    new Extend\Locales(__DIR__.'/locale'),
];
