const config = require('flarum-webpack-config');

module.exports = {
  ...config(),
  output: {
    ...config().output,
    library: ['flarum', 'extensions', 'uoi-cas-sso'],
    libraryTarget: 'assign',
  },
};
