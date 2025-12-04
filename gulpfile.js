const gulp          = require("gulp"),
    path          = require("path"),
    postcss       = require("gulp-postcss"),
    browserSync   = require('browser-sync').create(),
    sourcemaps    = require('gulp-sourcemaps'),
    cssnano       = require('cssnano'),
    uglify        = require('gulp-uglify'),
    browserify    = require('browserify'),
    babelify      = require('babelify'),
    source        = require('vinyl-source-stream'),
    buffer        = require('vinyl-buffer'),
    uglifyEs      = require('gulp-uglify-es').default,
    JSFILES       = ['admin'];



JSFILES.forEach( (js) => {

    gulp.task(`dev:js-${js}`, () => {
        const bundler = browserify(`snapdragon/src/scripts/${js}.js`, {
            debug: true
        });
    
        bundler.transform(babelify.configure({
            presets: [['@babel/preset-env', {
                        "forceAllTransforms": true,
                        "spec": true,
                        "loose": true
                    }]
            ]
        }));
    
        return bundler.bundle()
        .pipe(source(`${js}.js`))
        .pipe(buffer())
        .pipe(uglifyEs())
        .pipe(gulp.dest('snapdragon/assets/scripts'))
        .pipe(browserSync.stream());
    });

});



gulp.task('dev:css', function() {
    return gulp.src('snapdragon/src/styles/*.css')
        .pipe(sourcemaps.init())
        .pipe(postcss([
            require('@tailwindcss/postcss'),
            require('autoprefixer'),
            cssnano(),
        ]))
        .pipe(sourcemaps.write())
        .pipe(gulp.dest("snapdragon/assets/styles"))
        .pipe(browserSync.stream());
});



gulp.task('serve', function() {
    browserSync.init({
        proxy: "http://localhost:8888"
    });
    

    gulp.watch(['./snapdragon/src/styles/**/*.css' , './snapdragon/**/*.php'], gulp.parallel('dev:css'));
    gulp.watch('./snapdragon/src/scripts/**/*.js', gulp.parallel('dev:js-admin'));
    gulp.watch(['./snapdragon/**/*.php', './snapdragon/**/styles/**/*.css', './snapdragon/src/scripts/*.js']).on('change', browserSync.reload);
});




gulp.task('default', gulp.parallel(['serve']));

