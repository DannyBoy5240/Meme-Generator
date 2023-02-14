
var gulp = require('gulp');
var sass = require('gulp-sass');


 gulp.task('sass', function() {
   return gulp.src('./sass/**/*.scss')    
     .pipe(sass( { errLogToConsole: true }))
     .pipe(gulp.dest('.'));
 });
 gulp.task('watch', function() {
   gulp.watch('./sass/**/*.scss', ['sass']);
 });

gulp.task('default', ['watch', 'sass']);
