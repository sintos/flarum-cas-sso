<?php

namespace Uoi\FlarumCasSso\Controller;

use Flarum\Foundation\Config;
use Flarum\Http\Rememberer;
use Flarum\Settings\SettingsRepositoryInterface;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CasLogoutController implements RequestHandlerInterface
{
    public function __construct(
        private Config $config,
        private Rememberer $rememberer,
        private SettingsRepositoryInterface $settings
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $session = $request->getAttribute('session');

        if ($session) {
            $session->invalidate();
        }

        return $this->rememberer->forget(new RedirectResponse($this->casLogoutUrl()));
    }

    private function casLogoutUrl(): string
    {
        $host = $this->settings->get('uoi-cas-sso.cas_host', 'sso.uoi.gr');
        $port = (int) $this->settings->get('uoi-cas-sso.cas_port', 443);
        $context = rtrim($this->settings->get('uoi-cas-sso.cas_context', '/cas'), '/');
        $portSegment = $port === 443 ? '' : ':'.$port;

        return 'https://'.$host.$portSegment.$context.'/logout?service='.rawurlencode($this->config->url());
    }
}
