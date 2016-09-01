var gulp = require('gulp')
var magicImporter = require('node-sass-magic-importer')
var $ = require('gulp-load-plugins')()
var bs = require('browser-sync')

var paths = {
  sass: 'styles/**/*.scss',
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

gulp.task('watch', function() {
  gulp.watch(paths.sass, ['sass']);

  var twig = gulp.watch('templates/**/*.twig')
  twig.on('change', function(e) {
    bs.reload(e.path);
  })

  bs.init({
    proxy: 'local-made-in-hawaii.pantheonsite.io'
  })
})

gulp.task('default', ['watch']);
