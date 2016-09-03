var gulp = require('gulp')
var magicImporter = require('node-sass-magic-importer')
var $ = require('gulp-load-plugins')()
var bs = require('browser-sync')
var webpackStream = require('webpack-stream')

var paths = {
  sass: 'styles/**/*.scss',
  js: 'js/**/*.js',
  templates: 'templates/*.twig',
}

gulp.task('sass', function() {
  gulp
    .src(paths.sass)
    .pipe($.plumber())
    .pipe($.sass({
      importer: magicImporter
    }))
    .pipe(gulp.dest('.'))
    .pipe(bs.stream({match: '**/*.css'}))
})

gulp.task('js', function() {
  gulp
    .src(paths.js)
    .pipe($.plumber())
    .pipe(webpackStream(require('./webpack.config.js')))
    .pipe(gulp.dest('./js'))
})

gulp.task('watch', function() {
  gulp.watch(paths.sass, ['sass']);
  gulp.watch(paths.js, ['js']);

  var twig = gulp.watch('templates/**/*.twig')
  twig.on('change', function(e) {
    bs.reload(e.path);
  })

  bs.init({
    proxy: 'local-made-in-hawaii.pantheonsite.io'
  })
})

gulp.task('default', ['watch']);
