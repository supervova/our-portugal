const paths = {
  js: {
    src: {
      main: [`${root.src}/**/*.js`, `!${root.src}/js/vendor/*.js`],
      plugins: [
        // './node_modules/popper.js/dist/umd/popper.js',
        './node_modules/bootstrap/js/dist/util.js',
        // './node_modules/bootstrap/js/dist/alert.js',
        // './node_modules/bootstrap/js/dist/button.js',
        './node_modules/bootstrap/js/dist/carousel.js',
        // './node_modules/bootstrap/js/dist/collapse.js',
        './node_modules/bootstrap/js/dist/dropdown.js',
        './node_modules/bootstrap/js/dist/modal.js',
        // './node_modules/bootstrap/js/dist/tab.js',
      ],
      search: `${root.src}/js/search.js`,
      unoptimized: [
        `${root.src}/js/vendor/*.js`,
        `!${root.src}/js/vendor/jquery.mobile.custom.js`,
      ],
    },
    dest: `${root.dest}/js`,
  },
};

const babel = require('gulp-babel');
const concat = require('gulp-concat');
const uglify = require('gulp-terser');

// Common scripts function
const jsTasks = (source, file, compiler) =>
  src(source, { since: lastRun(jsTasks) })
    .pipe(changed(paths.js.dest))
    .pipe(plumber())
    // With modular project structure use webpack instead others
    // .pipe(webpackstream(webpackconfig, webpack))
    .pipe(gulpif(!PRODUCTION, sourcemaps.init()))
    .pipe(gulpif(compiler, babel({ presets: ['@babel/preset-env'] })))
    .pipe(concat(`${file}.js`))
    .pipe(uglify())
    .pipe(gulpif(!PRODUCTION, sourcemaps.write()))
    .pipe(size({ title: `scripts: ${file}` }))
    .pipe(dest(paths.js.dest));
// .pipe(browserSync.stream());

// Plugins
function jsPlugins(done) {
  jsTasks(
    paths.js.src.plugins, // src
    'plugins' // file
  );
  done();
}

// Main
function jsMain(done) {
  jsTasks(
    paths.js.src.main, // src
    'main', // file
    true
  );
  done();
}

// SCRIPTS BUILD
const scripts = parallel(jsPlugins, jsMain);
