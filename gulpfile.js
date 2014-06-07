'use strict';

var gulp = require('gulp'),
    sass = require('gulp-ruby-sass'),
        uglify = require('gulp-uglify'), 
    livereload = require('gulp-livereload'),
    csso = require('gulp-csso'),
    cleanhtml = require("gulp-cleanhtml");

gulp.task('default', function () {
    gulp.start('build');
});

gulp.task('php', function () {
    gulp.src(['app/*.php'])
        .pipe(gulp.dest('dist'));
});


gulp.task('scripts', function () {
    return gulp.src(['app/js/*.js'])
        .pipe(uglify())
        .pipe(gulp.dest('dist/js'));
});

gulp.task('styles', function () {
    gulp.src(['app/sass/**/*.scss'])
        .pipe(sass({
            style: 'expanded'
        }))
        .pipe(gulp.dest('app/css'));

    gulp.src(['app/img/**/*.*'])
        .pipe(gulp.dest('dist/img'));

    gulp.src('app/css/**/*.css')
        // .pipe(gulp.dest('dist/css'))
        .pipe(csso())
        .pipe(gulp.dest('dist/css/min'));
});

gulp.task('pages', function () {
    return gulp.src('app/*.html')
        .pipe(cleanhtml())
        .pipe(gulp.dest('dist'));
});

gulp.task('build', ['scripts', 'styles', 'pages', 'php']);

gulp.task('server', function () {
    var connect = require('connect'),
        server = connect();
    server.use(connect.static('dist')).listen(process.env.PORT || 9122);
    require('opn')('http://localhost:' + (process.env.PORT || 9122));
});

gulp.task('watch', ['server'], function () {
    gulp.start('build');

    gulp.watch('app/sass/**/*.scss', ['styles']);
     gulp.watch('app/js/**/*.js', ['scripts']);
    gulp.watch('app/*.html', ['pages']);

    var server = livereload();
    gulp.watch('dist/**').on('change', function (file) {
        server.changed(file.path);
    });
});