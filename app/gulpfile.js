var gulp = require('gulp'),
    plumber = require('gulp-plumber'),
    rename = require('gulp-rename');
var autoprefixer = require('gulp-autoprefixer');
var uglify = require('gulp-uglify');
var minifycss = require('gulp-clean-css');
var sass = require('gulp-sass');


gulp.task('styles', function(){
    gulp.src(['src/style/**/*.sass'])
        .pipe(plumber({
            errorHandler: function (error) {
                console.log(error.message);
                this.emit('end');
            }}))
        .pipe(sass())
        .pipe(autoprefixer('last 2 versions'))
        .pipe(gulp.dest('style/'))
        .pipe(rename({suffix: '.min'}))
        .pipe(minifycss())
        .pipe(gulp.dest('style/'))
});

gulp.task('scripts', function(){
    return gulp.src('src/script/**/*.js')
        .pipe(plumber({
            errorHandler: function (error) {
                console.log(error.message);
                this.emit('end');
            }}))
        .pipe(gulp.dest('script/'))
        .pipe(rename({suffix: '.min'}))
        .pipe(uglify())
        .pipe(gulp.dest('script/'))
});

gulp.task('default', function(){
    gulp.watch("src/style/**/*.sass", ['styles']);
    gulp.watch("src/script/**/*.js", ['scripts']);
});