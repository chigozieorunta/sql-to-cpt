const { src, dest, watch } = require('gulp');

const sass = require('gulp-sass')(require('sass'));
const minify = require('gulp-clean-css');
const autoprefixer = require('gulp-autoprefixer');
const browserSync = require('browser-sync').create();

const babel = require('gulp-babel');
const uglify = require('gulp-uglify');
const concat = require('gulp-concat');
const merge = require('merge-stream');

const compile = () => {
	return src('./assets/src/css/**/*.scss')
		.pipe(sass())
		.pipe(autoprefixer())
		.pipe(minify())
		.pipe(dest('./assets/dist/css'))
		.pipe(browserSync.stream());
}

const scripts = () => {
	let core = src('./assets/src/js/**/*.js')
		.pipe(babel())
		.pipe(uglify())
		.pipe(concat('core.js'))
		.pipe(dest('./assets/dist/js'));

	let jQuery = src(['node_modules/jquery/dist/jquery.min.js'])
		.pipe(concat('jquery.js'))
		.pipe(dest('./assets/dist/js'));

	return merge(core, jQuery);
}

const observe = () => {
	browserSync.init({
		server: {
			baseDir: './'
		}
	})
	watch('./assets/src/css/**/*.scss', compile);
	watch('./assets/src/js/**/*.js', scripts);
	watch('./**/*.html').on('change', browserSync.reload);
}

exports.sass = compile;
exports.scripts = scripts;
exports.watch = observe;
