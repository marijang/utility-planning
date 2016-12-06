var elixir = require('laravel-elixir');
var gulp = require('gulp');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass('app.scss');
    mix 
    	.copy('bower_components/semantic/dist/semantic.js', 'public/js/semantic.js')
    	.copy('bower_components/semantic/dist/semantic.css', 'public/css/semantic.css')
    	.sass([
           'app.scss',
     	    ], 
     	    'public/assets/css'
     	 )
    	.version([
        	'public/css/app.css',
        	'public/js/semantic.js',
        	'public/css/semantic.css',
     	])
});

gulp.task('fonts', function() {
 gulp.src(['bower_components/semantic/dist/themes/default/assets/fonts/**/*'])
     .pipe(gulp.dest('public/css/themes/default/assets/fonts'));

 gulp.src(['bower_components/fontawesome/fonts/**/*'])
     .pipe(gulp.dest('public/css/fonts'));
});