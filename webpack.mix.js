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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');

/**
 * Menambahkan file map untuk min.css dan min.js.
 * Untuk keperluan browser style debug
 */
let productionSourceMaps = false;
mix.sourceMaps(productionSourceMaps, 'source-map');

/**
 * Untuk melakukan Browser Sync
 * Agar tampilan web bisa dilihat melalui Smartphone melalui ip address computer port 3000
 */
// mix.browserSync(process.env.APP_URL);
