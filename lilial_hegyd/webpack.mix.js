let {mix} = require('laravel-mix');

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

// mix.js('resources/assets/js/app.js', 'public/js')
//    .sass('resources/assets/sass/app.scss', 'public/css');


mix.less('resources/assets/less/app.less', 'public/app/css');

mix.copy('resources/assets/front/fonts', 'public/front/fonts');
mix.copy('resources/assets/front/images', 'public/front/images', false);
mix.copy('resources/assets/front/uploads', 'public/front/uploads', false);
mix.copy('resources/assets/front/js', 'public/front/js', false);

mix.sass('resources/assets/front/scss/style.scss', 'public/front/css/style.css');
//mix.copy('resources/assets/front/css/style.css', 'public/front/css/style.css');

mix.copy('resources/assets/app/vendor/bower', 'public/app/vendor/bower', false);

