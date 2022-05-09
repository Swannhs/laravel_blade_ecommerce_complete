const mix = require('laravel-mix');

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
mix.js([
    'resources/js/app.js',
    'public/backend/js/loadah.min.js',
    'public/frontend/default/js/jquery.simpleLoadMore.js',
    'public/backend/vendors/select2/js/select2.min.js',
    'public/backend/vendors/js/nice-select.min.js',
    'public/frontend/default/vendors/owl_carousel/js/owl.carousel.min.js',
    'public/frontend/default/js/jquery.nicescroll.min.js',
    'public/frontend/default/js/rangeslider.js',
    'public/frontend/default/js/jquery.scrollbar.min.js',
    'public/frontend/default/vendors/gijgo/gijgo.min.js',
    'public/frontend/default/vendors/responsive_table/js/tablesaw.stackonly.js',
    'public/frontend/default/js/custom.js',
    'public/frontend/default/js/highlight.js'
], 'public/frontend/default/compile_js/app.js')

.sass('resources/sass/frontend/default/app.scss', 'public/frontend/default/compile_css/app.css').options({
    processCssUrls: false
})
.sass('resources/sass/frontend/default/rtl_app.scss', 'public/frontend/default/compile_css/rtl_app.css').options({
    processCssUrls: false
});
