var Encore = require('@symfony/webpack-encore');

Encore
    // the project directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    // uncomment to create hashed filenames (e.g. app.abc123.css)
    // .enableVersioning(Encore.isProduction())

    // uncomment to define the assets of the project
    .addEntry('js/app', './assets/js/app.js')
    .addStyleEntry('css/app', './assets/css/app.scss')
    .addStyleEntry('css/admin', './assets/css/_admin.scss')


    // uncomment if you use Sass/SCSS files
    .enableSassLoader(function(sassOptions) {}, {
        resolveUrlLoader: false
    })
    // Activate postcssloader
    .enablePostCssLoader()

    // uncomment for legacy applications that require $/jQuery as a global variable
    .autoProvidejQuery()
    .autoProvideVariables({
        "window.jQuery": "jquery",
        "window.Bloodhound": require.resolve('bloodhound-js'),
        "jQuery.tagsinput": "bootstrap-tagsinput"
    })
    .configureBabel(function(babelConfig) {
        // add additional presets
        babelConfig.presets.push('es2017')
    })
;


module.exports = Encore.getWebpackConfig();
