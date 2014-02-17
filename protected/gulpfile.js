var gulp = require('gulp');
var gutil = require('gulp-util');
var coffee = require('gulp-coffee');

gulp.task('coffee', function() {
  gulp.src(['../coffee/*.coffee', '../coffee/**/*.coffee'])
    .pipe(coffee({bare: true}).on('error', gutil.log))
    .pipe(gulp.dest('../js'))
});

gulp.task('default', function(){
  // place code for your default task here
    gulp.run('coffee');
    gulp.watch(['../coffee/*.coffee', '../coffee/**/*.coffee'], function() {
      gulp.run('coffee');
    });
});
