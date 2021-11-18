const { src, dest, watch } = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const minify = require('gulp-clean-css');
const browserSync = require('browser-sync').create();
const autoprefixer = require('gulp-autoprefixer');

const compile = () => {
	return src('./assets/src/css/**/*.scss')
		.pipe(sass())
		.pipe(autoprefixer())
		.pipe(minify())
		.pipe(dest('./assets/dist/css'))
		.pipe(browserSync.stream());
}

const observe = () => {
	browserSync.init({
		server: {
			baseDir: './'
		}
	})
	watch('./assets/src/css/**/*.scss', compile);
	watch('./**/*.html').on('change', browserSync.reload);
}

exports.sass = compile;
exports.watch = observe;
