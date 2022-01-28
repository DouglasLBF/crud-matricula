const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
.sass('resources/views/scss/style.scss','public/site/style.scss')
.scripts('node_modules/jquery/dist/jquery.min.js','public/site/jquery.js')
.scripts('node_modules/bootstrap/dist/js/bootstrap.bundle.min.js','public/site/bootstrap.js')
.scripts('node_modules/datatables.net/js/jquery.dataTables.min.js','public/site/dataTables.js')
.scripts('node_modules/datatables.net-bs5/js/dataTables.bootstrap5.min.js','public/site/dataTables-bs5.js');
