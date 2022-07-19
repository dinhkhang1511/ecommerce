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

//css bundle
mix.styles(
    [
        "public/css/bootstrap.css",
        "public/css/nice-select.css",
        "public/css/owl.carousel.min.css",
        "public/css/slicknav.min.css",
        "public/css/frontend.css",
        "public/css/custom.css",
        "public/css/responsive.css"
    ],
    "public/bundle/frontend/app.css"
);

//js bundle
mix.scripts(
    [
        "public/js/jquery-3.3.1.min.js",
        "public/js/bootstrap.js",
        "public/js/fontawesome.js",
        "public/js/jquery.nice-select.min.js",
        "public/js/jquery.nicescroll.min.js",
        "public/js/jquery.slicknav.js",
        "public/js/mixitup.min.js",
        "public/js/owl.carousel.min.js",
        "public/js/use_owlcarousel.js",
        "public/js/custom.js",
        "public/js/shop_filter.js",
        "public/js/main.js"
    ],
    "public/bundle/frontend/app.js"
);
