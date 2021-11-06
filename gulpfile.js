const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));

gulp.task('watch', async () => {
	gulp.watch('./assets/src/css/**/*.scss', ['sass']);
})

gulp.task('sass', async () => {
	return gulp.src('./assets/src/css/**/*.scss')
		.pipe(sass())
		.pipe(gulp.dest('./assets/dist/css'));
})