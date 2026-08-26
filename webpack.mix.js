const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

//SUPPLIER
mix.js("resources/js/supplier/app.js", "public/js/supplier/app.js")
    .vue()
    .sourceMaps();

//WEBSITE
mix.js("resources/js/website/app.js", "public/js/website/ssx-vendors.js")
    .vue()
    .sass(
        "resources/sass/website/app.scss",
        "public/css/website/ssx-vendors.css"
    )
    .options({
        processCssUrls: false,
    })
    .copyDirectory(
        "node_modules/@fortawesome/fontawesome-free/webfonts",
        "public/css/webfonts"
    )
    .copyDirectory("resources/css/website/fonts", "public/css/fonts")
    .postCss("resources/css/website/ssx.css", "public/css/website/ssx.css")
    .postCss(
        "resources/css/website/custom.css",
        "public/css/website/ssx-custom.css"
    )
    .js("resources/js/website/ssx.js", "public/js/website")
    .js("resources/js/website/home.js", "public/js/website")
    .js("resources/js/website/events.js", "public/js/website")
    .sourceMaps();

//ADMIN
mix.js("resources/js/admin/app.js", "public/js/admin/ssx-vendors.js")
    .vue()
    .sass("resources/sass/admin/style.scss", "public/css/admin/ssx.css")
    .options({
        processCssUrls: false,
    })
    .sass(
        "resources/sass/admin/vue-good-table/style.scss",
        "public/css/admin/good-table.css"
    )
    .copyDirectory(
        [
            "resources/sass/admin/icons/themify-icons/fonts",
            "resources/sass/admin/icons/material-design-iconic-font/fonts",
            "resources/sass/admin/icons/themify-icons/fonts",
        ],
        "public/css/fonts"
    )
    .copy(
        [
            "resources/js/admin/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js",
            "resources/js/admin/sparkline/sparkline.js",
            "resources/js/admin/waves.js",
            "resources/js/admin/sidebarmenu.js",
            "resources/js/admin/custom.min.js",
        ],
        "public/js/admin"
    )
    .sourceMaps();

if (mix.inProduction()) {
    mix.version();
}
