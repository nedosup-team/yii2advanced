var gulp = require('gulp'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify'),
    jshint = require('gulp-jshint'),
    plumber = require('gulp-plumber'),
    compass = require('gulp-compass'),
    sourcemaps = require('gulp-sourcemaps'),
    webserver = require('gulp-webserver'),
    paths = {
        javascripts: [
            'javascripts/helpers/*.js'
        ],
        images: 'images/*.{png,jpg,gif}',
        sass: 'sass/**/*.{sass,scss}'
    };

gulp.task('minify', function () {
    gulp.src(paths.javascripts)
        .pipe(plumber())
        .pipe(sourcemaps.init())
        .pipe(concat('scripts.min.js'))
        .pipe(uglify())
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('javascripts'));
});


gulp.task('compass', function () {
    gulp.src(paths.sass)
        .pipe(plumber())
        .pipe(compass({
            config_file: 'config.rb',
            css: 'stylesheets'
        }))
        .pipe(gulp.dest('stylesheets'));
});

gulp.task('webserver', function() {
  gulp.src('./')
    .pipe(plumber())
    .pipe(webserver({
        livereload: true,
        directoryListing: true,
        open: true
    }));
});

gulp.task('watch', function() {
    gulp.watch(paths.javascripts, ['minify']);
    gulp.watch(paths.sass, ['compass']);
});

gulp.task('default', ['minify', 'compass', 'webserver', 'watch']);