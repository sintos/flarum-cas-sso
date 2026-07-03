import app from 'flarum/forum/app';
import LogInButtons from 'flarum/forum/components/LogInButtons';
import Button from 'flarum/common/components/Button';
import { extend } from 'flarum/common/extend';

app.initializers.add('uoi/flarum-cas-sso', () => {
  extend(LogInButtons.prototype, 'items', function (items) {
    items.add(
      'uoi-cas',
      Button.component(
        {
          className: 'Button LogInButton LogInButton--uoi-cas',
          icon: 'fas fa-university',
          onclick: () => {
            const returnUrl = encodeURIComponent(window.location.href);
            window.location.href = `${app.forum.attribute('baseUrl')}/auth/cas?return=${returnUrl}`;
          },
        },
        app.translator.trans('uoi-cas-sso.forum.log_in.with_cas_button')
      )
    );
  });
});
