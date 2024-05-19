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

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
        require('autoprefixer'),
    ])
.styles([
'public/css/app.css',
'public/css/mybudget_setbudget.css',
'public/css/mybudget_transactions_MOBILE.css',
'public/css/mybudget_transactions.css',
'public/css/mybudget_viewhistory_tooltips_for_menu.css',
'public/css/mybudget_viewhistory.css',
'public/css/myjournal_home.css',
'public/css/mylifeline_comparison.css',
'public/css/mylifeline_home.css',
'public/css/mylifeline_itemhistory.css',
'public/css/mylifeline_report.css',
'public/css/mylifeline_section.css',
'public/css/mylifeline_source.css'
]);

// mix.js('resources/js/app.js', 'public/js')
// .sass('resources/sass/app.scss', 'public/css')
// .styles([
// 'public/css/app.css',
// 'public/css/mybudget_setbudget.css',
// 'public/css/mybudget_transactions_MOBILE.css',
// 'public/css/mybudget_transactions.css',
// 'public/css/mybudget_viewhistory_tooltips_for_menu.css',
// 'public/css/mybudget_viewhistory.css',
// 'public/css/myjournal_home.css',
// 'public/css/mylifeline_comparison.css',
// 'public/css/mylifeline_home.css',
// 'public/css/mylifeline_itemhistory.css',
// 'public/css/mylifeline_report.css',
// 'public/css/mylifeline_section.css',
// 'public/css/mylifeline_source.css'
// ])
// ;

mix.autoload({
jquery: ['$', 'window.jQuery', 'jQuery']
});

mix.extract(['jquery', 'bootstrap']);

if (mix.inProduction()) {
    mix.version();
}
