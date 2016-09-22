var gulp = require('gulp')
var magicImporter = require('node-sass-magic-importer')
var $ = require('gulp-load-plugins')()
var bs = require('browser-sync')
var webpackStream = require('webpack-stream')
var lost = require('lost')
var path = require('path')

var paths = {
  sass: 'styles/**/*.scss',
  js: [
    'js/src/**/*.js',
    'components/**/*.js',
  ],
  templates: 'templates/*.twig',
}

gulp.task('sass', function() {
  gulp
    .src(paths.sass)
    .pipe($.plumber())
    .pipe($.sass({
      outputStyle: 'compressed',
      importer: magicImporter
    }))
    .pipe($.postcss([
      lost
    ]))
    .pipe(gulp.dest('.'))
    .pipe(bs.stream({match: '**/*.css'}))
})

gulp.task('svg', function() {
  var svgs =
    gulp.src('./icons/*.svg')
      .pipe($.svgmin(function (file) {
        var prefix = path.basename(file.relative, path.extname(file.relative));
          return {
            plugins: [{
              cleanupIDs: {
                prefix: prefix + '-',
                minify: true
              }
            }]
          }
      }))
      .pipe($.svgstore())

    function fileContents(filePath, file) {
      return file.contents.toString();
    }

    return gulp
      .src('./templates/icons.twig')
      .pipe($.inject(svgs, {transform: fileContents}))
      .pipe(gulp.dest('./templates'))
});


gulp.task('js', function() {
  gulp
    .src(paths.js)
    .pipe($.plumber())
    .pipe(webpackStream(require('./webpack.config.js')))
    .pipe(gulp.dest('./js'))
})

gulp.task('watch', function() {
  gulp.watch(['styles/**/*.scss', 'components/**/*.scss'], ['sass']);
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
