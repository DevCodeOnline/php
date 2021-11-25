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

mix.styles([
    'resources/assets/admin/plugins/fontawesome-free/css/all.min.css',
    'resources/assets/admin/plugins/select2/css/select2.min.css',
    'resources/assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css',
    'resources/assets/admin/css/adminlte.min.css',
], 'public/assets/admin/css/admin.css');

mix.scripts([
    'resources/assets/admin/plugins/jquery/jquery.min.js',
    'resources/assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js',
    'resources/assets/admin/plugins/select2/js/select2.full.min.js',
    'resources/assets/admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js',
    'resources/assets/admin/js/adminlte.min.js',
    'resources/assets/admin/js/demo.js',
], 'public/assets/admin/js/admin.js');

mix.copyDirectory( 'resources/assets/admin/img', 'public/assets/admin/img');
mix.copyDirectory( 'resources/assets/admin/plugins/fontawesome-free/webfonts', 'public/assets/admin/webfonts');
mix.copy('resources/assets/admin/css/adminlte.min.css.map', 'public/assets/admin/css/adminlte.min.css.map');
mix.copy('resources/assets/admin/js/adminlte.min.js.map', 'public/assets/admin/js/adminlte.min.js.map');
mix.copy('resources/assets/admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js.map', 'public/assets/admin/js/bs-custom-file-input.min.js.map');

mix.styles([
    'resources/assets/front/css/slick-theme-min.css',
    'resources/assets/front/css/slick-min.css',
    'resources/assets/front/css/nice-select.css',
    'resources/assets/front/css/style.css',
], 'public/assets/front/css/style.css');

mix.scripts([
    'resources/assets/front/js/jquery.min.js',
    'resources/assets/front/js/slick-min.js',
    'resources/assets/front/js/jquery.timepicker.min.js',
    'resources/assets/front/js/jquery.nice-select.min.js',
    'resources/assets/front/js/jquery.zoom.min.js',
    'resources/assets/front/js/main.js',
], 'public/assets/front/js/scripts.js');

mix.copyDirectory( 'resources/assets/front/img', 'public/assets/front/img');
mix.copy('resources/assets/front/css/style.css.map', 'public/assets/front/css/style.css.map');
mix.copy('resources/assets/front/css/bootstrap-grid.min.css.map', 'public/assets/front/css/bootstrap-grid.min.css.map');

