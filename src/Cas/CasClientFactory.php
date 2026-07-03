<?php

namespace Uoi\FlarumCasSso\Cas;

use Flarum\Settings\SettingsRepositoryInterface;
use phpCAS;

class CasClientFactory
{
    public function __construct(private SettingsRepositoryInterface $settings)
    {
    }

    public function boot(): void
    {
        if (phpCAS::isInitialized()) {
            return;
        }

        $host = $this->settings->get('uoi-cas-sso.cas_host', 'sso.uoi.gr');
        $port = (int) $this->settings->get('uoi-cas-sso.cas_port', 443);
        $context = $this->settings->get('uoi-cas-sso.cas_context', '/cas');
        $version = $this->casVersion($this->settings->get('uoi-cas-sso.cas_version', '2.0'));

        phpCAS::client($version, $host, $port, $context, true);

        $caCert = $this->settings->get('uoi-cas-sso.cas_ca_cert');
        $disableValidation = (bool) $this->settings->get('uoi-cas-sso.disable_server_validation', true);

        if ($caCert) {
            phpCAS::setCasServerCACert($caCert);
        } elseif ($disableValidation) {
            phpCAS::setNoCasServerValidation();
        }
    }

    private function casVersion(?string $version): string
    {
        return match ($version) {
            '1.0' => CAS_VERSION_1_0,
            '3.0' => CAS_VERSION_3_0,
            default => CAS_VERSION_2_0,
        };
    }
}
