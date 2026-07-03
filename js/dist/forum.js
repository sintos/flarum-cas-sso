(function () {
  'use strict';

  var extend = flarum.core.compat['common/extend'].extend;
  var Button = flarum.core.compat['common/components/Button'];
  var LogInButtons = flarum.core.compat['forum/components/LogInButtons'];

  var extension = {
    extend: function (app) {
      extend(LogInButtons.prototype, 'items', function (items) {
        items.add(
          'uoi-cas',
          Button.component(
            {
              className: 'Button LogInButton LogInButton--uoi-cas',
              icon: 'fas fa-university',
              onclick: function () {
                var returnUrl = encodeURIComponent(window.location.href);
                window.location.href = app.forum.attribute('baseUrl') + '/auth/cas?return=' + returnUrl;
              },
            },
            app.translator.trans('uoi-cas-sso.forum.log_in.with_cas_button')
          )
        );
      });
    },
  };

  flarum.extensions['uoi-cas-sso'] = extension;
  flarum.extensions['uoi-flarum-cas-sso'] = extension;
})();
