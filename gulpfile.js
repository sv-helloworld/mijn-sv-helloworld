var gulp = require('gulp'),
    gutil = require('gulp-util'),
    sass = require('gulp-sass'),
    autoprefixer = require('gulp-autoprefixer'),
    livereload = require('gulp-livereload'),
    uglify = require('gulp-uglify'),
    concat = require('gulp-concat'),
    concatCss = require('gulp-concat-css'),
    cssnano = require('gulp-cssnano');

var stylesheets = [
    'resources/assets/css/**/*.css'
];

var scripts = {
    app: [
        'resources/assets/js/**/*.js',
    ],
    vendor: [
        'public/bower_components/jquery/dist/jquery.min.js',
    ],
};

gulp.task('blade', function() {
    return gulp.src('resources/views/**/*.blade.php')
        .pipe(livereload());
});

gulp.task('sass', function() {
    return gulp.src('resources/assets/sass/**/*.{sass,scss}')
        .pipe(sass({outputStyle: 'compressed'}).on('error', function(error) {
            gutil.log(error);
            this.emit('end');
        }))
        .pipe(autoprefixer())
        .pipe(gulp.dest('resources/assets/css'))
        .pipe(livereload());
});

gulp.task('css', ['sass'], function() {
    return gulp.src(stylesheets)
        .pipe(concatCss('app.min.css'))
        .pipe(gulp.dest('public/css'));
});

gulp.task('minify_css', ['sass'], function() {
    return gulp.src(stylesheets)
        .pipe(concatCss('app.min.css'))
        .pipe(cssnano())
        .pipe(gulp.dest('.'))
        .pipe(livereload());
});

gulp.task('scripts_app', function() {
    return gulp.src(scripts.app)
        .pipe(uglify().on('error', function(error) {
            gutil.log(error);
            this.emit('end');
        }))
        .pipe(concat('app.min.js'))
        .pipe(gulp.dest('public/js'))
        .pipe(livereload());
});

gulp.task('scripts_vendor', function() {
    return gulp.src(scripts.vendor)
        .pipe(uglify().on('error', function(error) {
            gutil.log(error);
            this.emit('end');
        }))
        .pipe(concat('vendor.min.js'))
        .pipe(gulp.dest('public/js'))
        .pipe(livereload());
});

gulp.task('watch', function() {
    livereload.listen({
        host: 'localhost'
    });

    // Watch Blade files
    gulp.watch('resources/views/**/*.blade.php', ['blade']);

    // Watch SASS and SCSS files
    gulp.watch('resources/assets/sass/**/*.{sass,scss}', ['css']);

    // Watch JS files
    gulp.watch('resources/assets/js/*.js', ['scripts_app']);
});

gulp.task('vendor', ['scripts_vendor']);

gulp.task('default', ['watch']);
