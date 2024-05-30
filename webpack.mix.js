const mix = require('laravel-mix');
const webpack = require('webpack');

mix.js('src/app.js', 'assets')
	.sass('src/app.scss', 'assets')
	.setPublicPath('public');

mix.autoload({
	jquery: ['$', 'window.jQuery', 'jQuery'],
	'popper.js/dist/umd/popper.js': ['Popper'],
	bootstrap: ['bootstrap'],
	moment: ['moment'],
	'datatables.net-bs5': ['DataTable'],
	select2: ['select2'],
});

if (mix.inProduction()) {
	mix.version();
}
