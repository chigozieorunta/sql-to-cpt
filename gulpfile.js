const {src, dest, watch} = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const minifyCSS = require('gulp-clean-css');
const browserSync = require('browser-sync').create();
const autoprefixer = require('gulp-autoprefixer');

const compileCSS = () => {
	return src('./assets/src/css/**/*.scss')
		.pipe(sass())
		.pipe(autoprefixer())
		.pipe(minifyCSS())
		.pipe(dest('./assets/dist/css'))
		.pipe(browserSync.stream());
}

const watchCSS = () => {
	browserSync.init({
		server: {
			baseDir: './'
		}
	})
	watch('./assets/src/css/**/*.scss', compileCSS);
	watch('./**/*.html').on('change', browserSync.reload);
}

exports.sass = compileCSS;
exports.watch = watchCSS;