const {src, dest, watch} = require('gulp');
const sass = require('gulp-sass')(require('sass'));

const compileCSS = () => {
	return src('./assets/src/css/**/*.scss')
		.pipe(sass())
		.pipe(dest('./assets/dist/css'));
}

const watchCSS = () => {
	watch('./assets/src/css/**/*.scss', sass);
}

exports.sass = compileCSS;
exports.watch = watchCSS;