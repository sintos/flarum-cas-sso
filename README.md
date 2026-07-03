# Flarum CAS SSO

Flarum extension for CAS authentication against the University SSO service.

## Installation

Install it in the Flarum root with a local path repository:

```bash
composer config repositories.uoi-cas-sso path /path/to/this/extension
composer require uoi/flarum-cas-sso:@dev
php flarum cache:clear
```

Enable the extension from the Flarum admin panel.

## Settings

The extension defaults to:

- CAS host: `sso.uoi.gr`
- CAS port: `443`
- CAS context: `/cas`
- fallback email domain: `uoi.gr`
- CAS CA certificate: empty

You can override them with Flarum settings:

```sql
INSERT INTO settings (`key`, `value`) VALUES
('uoi-cas-sso.cas_host', 'sso.uoi.gr'),
('uoi-cas-sso.cas_port', '443'),
('uoi-cas-sso.cas_context', '/cas'),
('uoi-cas-sso.cas_ca_cert', '/absolute/path/to/cas-ca.pem'),
('uoi-cas-sso.email_domain', 'uoi.gr')
ON DUPLICATE KEY UPDATE `value` = VALUES(`value`);
```

If your real CAS host is `sso.ui.gr`, set `uoi-cas-sso.cas_host` to that value.

For production, set `uoi-cas-sso.cas_ca_cert` to the CA certificate used to validate the CAS server. If it is left empty, the extension disables CAS server certificate validation for compatibility.

## Routes

- `/auth/cas` starts CAS login and creates or logs in the matching Flarum user.
- `/auth/cas/logout` clears the Flarum session and redirects to CAS logout.
