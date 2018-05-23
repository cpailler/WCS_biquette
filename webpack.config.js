let Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('web/build/')
    .setPublicPath('/web')
    .autoProvidejQuery()
    .addEntry('app', './assets/js/app.js')
    .addEntry('style', './assets/scss/style.scss')
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSassLoader(function(sassOptions) {}, {resolveUrlLoader: false })
;

module.exports = Encore.getWebpackConfig();