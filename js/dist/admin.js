(function () {
  'use strict';

  flarum.core.compat.app.initializers.add('uoi/flarum-cas-sso', function () {
    flarum.core.compat.app.extensionData
      .for('uoi-flarum-cas-sso')
      .registerSetting({
        setting: 'uoi-cas-sso.cas_host',
        label: flarum.core.compat.app.translator.trans('uoi-cas-sso.admin.settings.cas_host_label'),
        help: flarum.core.compat.app.translator.trans('uoi-cas-sso.admin.settings.cas_host_help'),
        type: 'text',
        placeholder: 'sso.uoi.gr',
      })
      .registerSetting({
        setting: 'uoi-cas-sso.cas_port',
        label: flarum.core.compat.app.translator.trans('uoi-cas-sso.admin.settings.cas_port_label'),
        help: flarum.core.compat.app.translator.trans('uoi-cas-sso.admin.settings.cas_port_help'),
        type: 'number',
        placeholder: '443',
      })
      .registerSetting({
        setting: 'uoi-cas-sso.cas_context',
        label: flarum.core.compat.app.translator.trans('uoi-cas-sso.admin.settings.cas_context_label'),
        help: flarum.core.compat.app.translator.trans('uoi-cas-sso.admin.settings.cas_context_help'),
        type: 'text',
        placeholder: '/cas',
      })
      .registerSetting({
        setting: 'uoi-cas-sso.cas_version',
        label: flarum.core.compat.app.translator.trans('uoi-cas-sso.admin.settings.cas_version_label'),
        help: flarum.core.compat.app.translator.trans('uoi-cas-sso.admin.settings.cas_version_help'),
        type: 'text',
        placeholder: '2.0',
      })
      .registerSetting({
        setting: 'uoi-cas-sso.email_domain',
        label: flarum.core.compat.app.translator.trans('uoi-cas-sso.admin.settings.email_domain_label'),
        help: flarum.core.compat.app.translator.trans('uoi-cas-sso.admin.settings.email_domain_help'),
        type: 'text',
        placeholder: 'uoi.gr',
      })
      .registerSetting({
        setting: 'uoi-cas-sso.cas_ca_cert',
        label: flarum.core.compat.app.translator.trans('uoi-cas-sso.admin.settings.cas_ca_cert_label'),
        help: flarum.core.compat.app.translator.trans('uoi-cas-sso.admin.settings.cas_ca_cert_help'),
        type: 'text',
        placeholder: '/etc/ssl/certs/cas-ca.pem',
      })
      .registerSetting({
        setting: 'uoi-cas-sso.disable_server_validation',
        label: flarum.core.compat.app.translator.trans('uoi-cas-sso.admin.settings.disable_server_validation_label'),
        help: flarum.core.compat.app.translator.trans('uoi-cas-sso.admin.settings.disable_server_validation_help'),
        type: 'boolean',
      });
  });
})();
