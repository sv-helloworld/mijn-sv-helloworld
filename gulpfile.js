var gulp = require('gulp'),
    autoprefixer = require('gulp-autoprefixer'),
    clean = require('gulp-clean'),
    concat = require('gulp-concat'),
    gutil = require('gulp-util'),
    livereload = require('gulp-livereload'),
    sass = require('gulp-sass'),
    uglify = require('gulp-uglify');

var stylesheets = {
    app: [
        'resources/assets/sass/style.scss',
    ],
    vendor: [
        'resources/assets/sass/vendor.scss',
    ],
};

var scripts = {
    app: [
        'resources/assets/js/**/*.js',
    ],
    vendor: [
        'node_modules/jquery/dist/jquery.slim.min.js',
    ],
};

var fonts = [
    'node_modules/font-awesome/fonts/*',
];

gulp.task('blade', function() {
    return gulp.src('resources/views/**/*.blade.php')
        .pipe(livereload())
    ;
});

gulp.task('stylesheets_vendor', function() {
    return gulp.src(stylesheets.vendor)
        .pipe(sass({outputStyle: 'compressed'}).on('error', function(error) {
            gutil.log(gutil.colors.red(error.formatted));
            this.emit('end');
        }))
        .pipe(autoprefixer())
        .pipe(concat('vendor.min.css'))
        .pipe(gulp.dest('public/css'))
    ;
});

gulp.task('stylesheets_app', function() {
    return gulp.src(stylesheets.app)
        .pipe(sass({outputStyle: 'compressed'}).on('error', function(error) {
            gutil.log(gutil.colors.red(error.formatted));
            this.emit('end');
        }))
        .pipe(autoprefixer())
        .pipe(concat('app.min.css'))
        .pipe(gulp.dest('public/css'))
        .pipe(livereload())
    ;
});

gulp.task('scripts_vendor', function() {
    return gulp.src(scripts.vendor)
        .pipe(uglify().on('error', function(error) {
            gutil.log(error);
            this.emit('end');
        }))
        .pipe(concat('vendor.min.js'))
        .pipe(gulp.dest('public/js'))
    ;
});

gulp.task('scripts_app', function() {
    return gulp.src(scripts.app)
        .pipe(uglify().on('error', function(error) {
            gutil.log(error);
            this.emit('end');
        }))
        .pipe(concat('app.min.js'))
        .pipe(gulp.dest('public/js'))
        .pipe(livereload())
    ;
});

gulp.task('clean_fonts', function() {
    return gulp.src('./public/fonts', { read: false })
        .pipe(clean({ force: true }))
    ;
});

gulp.task('copy_fonts', ['clean_fonts'], function() {
    return gulp.src(fonts)
        .pipe(gulp.dest('./public/fonts'))
    ;
});

gulp.task('watch', function() {
    livereload.listen({
        host: 'localhost'
    });

    // Watch Blade files
    gulp.watch('resources/views/**/*.blade.php', ['blade']);

    // Watch SASS and SCSS files
    gulp.watch('resources/assets/sass/**/*.{sass,scss}', ['stylesheets_app']);

    // Watch JS files
    gulp.watch(scripts.app, ['scripts_app']);
});

gulp.task('vendor', ['scripts_vendor', 'stylesheets_vendor', 'copy_fonts']);

gulp.task('build', ['scripts_vendor', 'scripts_app', 'stylesheets_app', 'stylesheets_vendor', 'copy_fonts']);

gulp.task('default', ['build']);
