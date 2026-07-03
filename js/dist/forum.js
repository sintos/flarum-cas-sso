(function () {
  'use strict';

  flarum.core.compat.extend.extend(flarum.core.compat['components/LogInButtons'].prototype, 'items', function (items) {
    items.add(
      'uoi-cas',
      flarum.core.compat['components/Button'].component(
        {
          className: 'Button LogInButton LogInButton--uoi-cas',
          icon: 'fas fa-university',
          onclick: function () {
            var returnUrl = encodeURIComponent(window.location.href);
            window.location.href = flarum.core.compat.app.forum.attribute('baseUrl') + '/auth/cas?return=' + returnUrl;
          },
        },
        flarum.core.compat.app.translator.trans('uoi-cas-sso.forum.log_in.with_cas_button')
      )
    );
  });
})();
