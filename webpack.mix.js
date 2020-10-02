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
    .js('resources/js/student/exam/script.js', 'public/js/student/exam/script.js')
    .js('resources/js/student/games/script.js', 'public/js/student/games/script.js')
    .js('resources/js/student/exam/menulis-efektif.js', 'public/js/student/exam/menulis-efektif.js')
    .js('resources/js/student/result/script.js', 'public/js/student/result/script.js')
    .js('resources/js/admin/stage/script.js', 'public/js/admin/stage/script.js')
    .js('resources/js/admin/round/script.js', 'public/js/admin/round/script.js')
    .js('resources/js/admin/question/script.js', 'public/js/admin/question/script.js')
    .js('resources/js/admin/question/soal-cerita.js', 'public/js/admin/question/soal-cerita.js')
    .js('resources/js/check-for-tex.js', 'public/js/check-for-tex.js')
    .sass('resources/sass/app.scss', 'public/css');

if (mix.inProduction()) {
    mix.version();
}
