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

mix.js('resources/js/app.js', 'public/js');
mix.sass('resources/sass/app.scss', 'public/css');


mix.styles([
    'public/shopassets/vendor/bootstrap/css/bootstrap.min.css',
    'public/shopassets/rateyo/jquery.rateyo.min.css',
    'public/shopassets/vendor/owl-carousel/assets/owl.carousel.min.css',
    'public/shopassets/vendor/photoswipe/photoswipe.css',
    'public/shopassets/vendor/photoswipe/default-skin/default-skin.css',
    'public/shopassets/css/style.css',
], 'public/css/shop.css');

mix.js([
	'resources/js/shop.js',
	'public/shopassets/vendor/owl-carousel/owl.carousel.min.js',
	'public/shopassets/vendor/photoswipe/photoswipe.min.js',
	'public/shopassets/vendor/photoswipe/photoswipe-ui-default.min.js',
	'public/shopassets/rateyo/jquery.rateyo.min.js',
	'public/shopassets/js/main.js',
], 'public/js/shop.js')