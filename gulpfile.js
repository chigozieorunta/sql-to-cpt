const gulp = require('gulp');
const sass = require('sass');

gulp.task('watch', async () => {
	gulp.src('./assets/src/**/*.scss')
		.pipe(sass()).
		.pipe(gulp.dest('./assets/dist'));
})