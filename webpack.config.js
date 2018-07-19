let Encore = require('@symfony/webpack-encore');

Encore
// the project directory where all compiled assets will be stored
    .setOutputPath('web/build/')

    // the public path used by the web server to access the previous directory
    .setPublicPath('/web')

    // will create web/build/app.js and web/build/app.css
    .addEntry('app', './assets/js/app.js')
    .addEntry('calendar', './assets/js/calendar.js')
    .addEntry('tri', './assets/js/tri.js')
    .addEntry('partagejs', './assets/js/partagejs.js')
    .addEntry('email', './assets/scss/email.scss')
    .addEntry('style', './assets/scss/style.scss')
    .addEntry('homepage', './assets/scss/homepage.scss')
    .addEntry('profil', './assets/scss/profil.scss')
    .addEntry('partage', './assets/scss/partage.scss')
    .addEntry('recherche', './assets/scss/recherche.scss')
    .addEntry('velo', './assets/scss/velo.scss')
    .addEntry('form', './assets/scss/form.scss')
    .addEntry('enregistrement', './assets/scss/enregistrement.scss')
    .addEntry('annonce', './assets/scss/annonce.scss')
    .addEntry('calendrier', './assets/scss/calendrier.scss')
    .addEntry('cartePaiement', './assets/scss/cartePaiement.scss')
    .addEntry('virement', './assets/scss/virement.scss')
    .addEntry('cgu', './assets/scss/cgu.scss')


    // allow legacy applications to use $/jQuery as a global variable
    .autoProvidejQuery()

    // enable source maps during development
    .enableSourceMaps(!Encore.isProduction())

    // empty the outputPath dir before each build
    .cleanupOutputBeforeBuild()

    // show OS notifications when builds finish/fail
    .enableBuildNotifications()

// allow sass/scss files to be processed
    .enableSassLoader();

// export the final configuration
module.exports = Encore.getWebpackConfig();