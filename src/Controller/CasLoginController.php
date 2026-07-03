<?php

namespace Uoi\FlarumCasSso\Controller;

use Flarum\Foundation\Config;
use Flarum\Http\SessionAccessToken;
use Flarum\Http\SessionAuthenticator;
use Flarum\Settings\SettingsRepositoryInterface;
use Flarum\User\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Uoi\FlarumCasSso\Cas\CasClientFactory;
use phpCAS;

class CasLoginController implements RequestHandlerInterface
{
    public function __construct(
        private CasClientFactory $cas,
        private Config $config,
        private SessionAuthenticator $authenticator,
        private SettingsRepositoryInterface $settings
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->cas->boot();

        phpCAS::forceAuthentication();

        $attributes = phpCAS::getAttributes();
        $casId = (string) phpCAS::getUser();
        $email = $this->email($casId, $attributes);
        $username = $this->username($casId);

        $user = User::where('email', $email)->first();

        if (! $user) {
            $user = User::register($username, $email, Str::random(48));
            $user->activate();
            $user->save();
        }

        $token = SessionAccessToken::generate($user->id);
        $this->authenticator->logIn($request->getAttribute('session'), $token);

        return new RedirectResponse($this->redirectUrl($request));
    }

    private function redirectUrl(ServerRequestInterface $request): string
    {
        $query = $request->getQueryParams();
        $return = Arr::get($query, 'return');

        if (is_string($return) && Str::startsWith($return, $this->config->url())) {
            return $return;
        }

        return $this->config->url();
    }

    private function email(string $casId, array $attributes): string
    {
        $email = $this->attribute($attributes, ['mail', 'email', 'emailAddress']);

        if ($email) {
            return $email;
        }

        $domain = $this->settings->get('uoi-cas-sso.email_domain', 'uoi.gr');

        return $casId.'@'.$domain;
    }

    private function username(string $casId): string
    {
        $base = Str::of($casId)->lower()->replaceMatches('/[^a-z0-9_-]/', '_')->trim('_')->limit(25, '')->toString();
        $base = $base ?: 'uoi_user';
        $username = $base;
        $counter = 1;

        while (User::where('username', $username)->exists()) {
            $suffix = '_'.$counter++;
            $username = Str::limit($base, 30 - strlen($suffix), '').$suffix;
        }

        return $username;
    }

    private function attribute(array $attributes, array $names): ?string
    {
        foreach ($names as $name) {
            $value = Arr::get($attributes, $name);

            if (is_array($value)) {
                $value = reset($value);
            }

            if (is_string($value) && trim($value) !== '') {
                return trim($value);
            }
        }

        return null;
    }
}
