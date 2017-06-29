/*
 * GULP CONFIG
 *
 * Desciption:  Clean gulpfile for web development workflow with browsersync, compiling/optimization of sass, javascript and images from assets to dist
 * Usage:       gulp (to run the whole process), gulp watch (to watch for changes and compile if anything was modified)
 *
 * Author:      Flurin Dürst (https://flurinduerst.ch)
 *
 * Version:     1.3.1
 *
*/


/* SETTINGS
/===================================================== */
var browsersync_proxy = "wpseed.dev";


/* DEPENDENCIES
/===================================================== */
// general
var gulp = require('gulp');
var browserSync = require('browser-sync').create();
var concat = require('gulp-concat');
var rename = require("gulp-rename");
// css
var sass = require('gulp-sass');
var cleanCSS = require('gulp-clean-css');
var autoprefixer = require('gulp-autoprefixer');
// js
var uglify = require('gulp-uglify');
// images
var imagemin = require('gulp-imagemin');
// error handling with notify & plumber
var notify = require("gulp-notify");
var plumber = require('gulp-plumber');
// watch
var watch = require('gulp-watch');
// delete
// var del = require('del');
//
var bower = require('gulp-bower');

var config = {
   sassPath: './assets/styles',
  bowerDir: './bower_components' 
};

/* TASKS
/===================================================== */
var path = require('path');

gulp.task('bower', function() { 
    return bower()
         .pipe(gulp.dest(config.bowerDir)) 
});

gulp.task('icons', function() { 
    return gulp.src(config.bowerDir + '/fontawesome/fonts/**.*') 
        .pipe(gulp.dest('./dist/fonts')); 
});

/* images
/-------------------------*/
gulp.task('images', function() {
   gulp.src('assets/images/*.{png,jpg,gif}')
   .pipe(imagemin())
   .pipe(gulp.dest('dist/images/'));
});

/* CSS
/------------------------*/
// from:    assets/styles/main.css
// actions: compile, minify, prefix, rename
// to:      dist/style.min.css
gulp.task('css', function() {
  gulp.src('assets/styles/main.scss')
  .pipe(plumber({errorHandler: notify.onError("<%= error.message %>")}))
  .pipe(sass({ style: 'expanded', loadPath: [
    config.bowerDir + '/bootstrap-sass/assets/stylesheets',
     config.bowerDir + '/fontawesome/scss',
    path.join( __dirname , 'assets/styles') ]
  }))
  .pipe(autoprefixer('last 2 version', { cascade: false }))
  .pipe(cleanCSS())
  .pipe(rename('dist/style.min.css'))
  .pipe(gulp.dest('./'));
});

/* JAVASCRIPT
/------------------------*/
// from:    assets/scripts/
// actions: concatinate, minify, rename
// to:      dist/script.min.css
gulp.task('javascript', function() {
  gulp.src('assets/scripts/*.js')
  .pipe(plumber({errorHandler: notify.onError("<%= error.message %>")}))
  .pipe(concat('script.min.js'))
  .pipe(uglify())
  .pipe(rename('dist/script.min.js'))
  .pipe(gulp.dest('./'));
});

/* CLEAN
/------------------------*/
// empty dist folder
gulp.task('clean', require('del').bind(null, ['dist/*']));

/* WATCH
/------------------------*/
// watch for modifications in
// styles, scripts, images, php files, html files
gulp.task('watch', function() {
  gulp.watch('assets/styles/**/*.scss', ['css']);
  gulp.watch('assets/scripts/*.js', ['javascript']);
  gulp.watch('assets/images/*', ['images']);
});

/* DEFAULT
/------------------------*/
// default gulp tasks executed with `gulp`
gulp.task('default', ['clean', 'bower', 'icons', 'images', 'css', 'javascript']);
