const mix = require('laravel-mix');
const webpack = require('webpack');

mix.js('src/app.js', 'assets')
	.sass('src/app.scss', 'assets')
	.sass('src/select2.scss', 'assets')
	.setPublicPath('public');

mix.autoload({
	jquery: ['$', 'window.jQuery', 'jQuery'],
	bootstrap: ['$', 'window.bootstrap', 'bootstrap'],
	moment: ['$', 'window.moment', 'moment'],
	'@popperjs/core': ['$', 'window.Popper', 'Popper'],
	DataTable: ['$', 'window.DataTable', 'DataTable'],
	select2: ['$', 'window.select2', 'select2'],
});

mix.browserSync('http://127.0.0.1:8080');

if (mix.inProduction()) {
	mix.version();
}
