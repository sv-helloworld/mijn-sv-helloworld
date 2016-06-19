"use strict";

var gulp = require('gulp'),
        gutil = require('gulp-util'),
        sass = require('gulp-sass'),
        autoprefixer = require('gulp-autoprefixer'),
        livereload = require('gulp-livereload'),
        uglify = require('gulp-uglify'),
        rename = require('gulp-rename');

gulp.task('blade', function() {
    return gulp.src('./resources/views/**/*.blade.php')
        .pipe(livereload());
});

gulp.task('sass', function() {
    return gulp.src('./resources/assets/sass/**/*.{sass,scss}')
        .pipe(sass({outputStyle: 'compressed'}).on('error', function(error) {
            gutil.log(error);
            this.emit('end');
        }))
        .pipe(autoprefixer())
        .pipe(gulp.dest('./public/css'))
        .pipe(livereload());
});

gulp.task('compress', function() {
    return gulp.src('./resources/assets/js/*.js')
        .pipe(uglify().on('error', function(error) {
            gutil.log(error);
            this.emit('end');
        }))
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(gulp.dest('./public/js'))
        .pipe(livereload());
});

gulp.task('watch', function () {
    livereload.listen({
        host: 'localhost'
    });

    // Watch Blade files
    gulp.watch('./resources/views/**/*.blade.php', ['blade']);

    // Watch SASS and SCSS files
    gulp.watch('./resources/assets/sass/**/*.{sass,scss}', ['sass']);

    // Watch JS files
    gulp.watch('./resources/assets/js/*.js', ['compress']);
});

gulp.task('default', ['watch']);
