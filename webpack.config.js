var Encore = require('@symfony/webpack-encore');
var CopyWebpackPlugin = require('copy-webpack-plugin');
const path = require('path');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')
    .addPlugin(new CopyWebpackPlugin([{
        from: './assets/img',
        to: 'img'
    }]))
    .addPlugin(new CopyWebpackPlugin([{
        from: './assets/fontawesome',
        to: 'fontawesome'
    }]))

    .copyFiles([{
            from: './node_modules/ckeditor/',
            to: 'ckeditor/[path][name].[ext]',
            pattern: /\.(js|css)$/,
            includeSubdirectories: false
        },
        {
            from: './node_modules/ckeditor/adapters',
            to: 'ckeditor/adapters/[path][name].[ext]'
        },
        {
            from: './node_modules/ckeditor/lang',
            to: 'ckeditor/lang/[path][name].[ext]'
        },
        {
            from: './node_modules/ckeditor/plugins',
            to: 'ckeditor/plugins/[path][name].[ext]'
        },
        {
            from: './node_modules/ckeditor/skins',
            to: 'ckeditor/skins/[path][name].[ext]'
        }
    ])

    /*
     * ENTRY CONFIG
     *
     * Add 1 entry for each "page" of your app
     * (including one that's included on every page - e.g. "app")
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
     */
    .addEntry('app', './assets/js/app.js')
    .addEntry('admin', './assets/js/admin.js')
    .addEntry('option', './assets/js/optionBijou.js')
    .addEntry('address', './assets/js/address.js')
    .addEntry('optSelect', './assets/js/optSelect.js')
    .addEntry('seance', './assets/js/seanceOption.js')
    .addEntry('select','./assets/js/select.js')
    .addEntry('promo','./assets/js/promo.js') 
    .addStyleEntry('css/font', './assets/css/font.css')
    .addStyleEntry('user', './assets/css/user.css')
    //.addEntry('page1', './assets/js/page1.js')
    //.addEntry('page2', './assets/js/page2.js')

    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // enables @babel/preset-env polyfills
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })



    // enables Sass/SCSS support
    .enableSassLoader()

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()

    // uncomment to get integrity="..." attributes on your script & link tags
    // requires WebpackEncoreBundle 1.4 or higher
    //.enableIntegrityHashes(Encore.isProduction())
    .addAliases({
        image: path.resolve(__dirname, 'public/bundles/image_bundle')
    })
    .addAliases({
        puglins: path.resolve(__dirname, 'public/build/plugins')
    })
    .autoProvideVariables({
        $: 'jquery',
        moment: 'moment'
    })
    // uncomment if you're having problems with a jQuery plugin
    .autoProvidejQuery()

  .addAliases( {
    // Force all modules to use the same jquery version.
    'jquery': path.join(__dirname, 'node_modules/jquery/src/jquery')
})
// uncomment if you use API Platform Admin (composer req api-admin)
//.enableReactPreset()
//.addEntry('admin', './assets/js/admin.js')
;

module.exports = Encore.getWebpackConfig();
