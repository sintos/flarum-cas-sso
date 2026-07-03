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

        phpCAS::client(CAS_VERSION_2_0, $host, $port, $context, true);

        $caCert = $this->settings->get('uoi-cas-sso.cas_ca_cert');

        if ($caCert) {
            phpCAS::setCasServerCACert($caCert);
        } else {
            phpCAS::setNoCasServerValidation();
        }
    }
}
