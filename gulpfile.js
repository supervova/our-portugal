/**
 * -----------------------------------------------------------------------------
 * 🧩 PLUGINS AND PATHS
 * -----------------------------------------------------------------------------
 */
// #region

// ☝️🧐 In order to build a Jekyll site and run a local server,
// it is preferable to keep package.json, node_modules and execute gulp commands
// within the source directory.

// ☝️🧐 The combination of Jekyll built-in server + gulp watchers + Chrome Live
// Reload Extension is much more faster than the 'gulp only' process.
// And the first workflow allows us to use extension-free links.

// The last option: symlink
const { src, dest, watch, series, parallel, lastRun } = require('gulp');

const browserSync = require('browser-sync').create();
const changed = require('gulp-changed');
const gulpif = require('gulp-if');
// const newer       = require('gulp-newer');
// Prevent pipe breaking caused by errors from gulp plugins
const plumber = require('gulp-plumber');
const size = require('gulp-size');
const sourcemaps = require('gulp-sourcemaps');
const yargs = require('yargs').alias('p', 'production');

// Look for the --p flag
const PRODUCTION = !!yargs.argv.production;

// Paths
const root = {
  src: './web/wp-content/themes/our-portugal-2020/src',
  dest: './web/wp-content/themes/our-portugal-2020',
  server: './web',
};

const paths = {
  css: {
    src: {
      main: `${root.src}/style.scss`,
      head: `${root.src}/css/head-styles/*.scss`,
    },
    watch: `${root.src}/**/*.scss`,
    tmp: `${root.src}/css`,
    dest: {
      main: `${root.dest}`,
      head: `${root.dest}/css`,
    },
  },

  js: {
    src: {
      main: `${root.src}/**/*.js`,
    },
    dest: `${root.dest}/js`,
  },

  markup: {
    src: [
      `${root.src}/pages/**/*.twig`,
      `!${root.src}/pages/**/_*.twig`,
      `!${root.src}/pages/base/*.twig`,
    ],
    watch: `${root.src}/**/*.twig`,
    dest: `${root.src}`,
  },

  img: {
    src: {
      graphics: [
        `${root.src}/**/*.+(jpg|jpeg|png|svg|gif|webp)`,
        `!${root.src}/base/graphics/sprite/**/*`,
        `!${root.src}/img/**/*`,
      ],
      content: `${root.src}/img/**/*.+(jpg|jpeg|png|svg|gif|webp)`,
    },
    // Vars array in watchers breaks build process, so there is one var for a watcher
    watch: [
      `${root.src}/**/*.+(jpg|jpeg|png|svg|gif|webp)`,
      `!${root.src}/base/graphics/sprite/**/*`,
    ],
    dest: `${root.dest}/img`,
  },

  sprite: {
    src: `${root.src}/base/graphics/sprite/*.svg`,
    dest: `${root.src}/base/graphics`,
  },
};
// #endregion

/**
 * -----------------------------------------------------------------------------
 * 🎨 STYLES
 * -----------------------------------------------------------------------------
 */
// #region

const autoprefixer = require('gulp-autoprefixer');
const cleanCSS = require('gulp-clean-css');
const sass = require('gulp-sass');
const postcss = require('gulp-postcss');
const uncss = require('postcss-uncss');

// COMMON STYLES FUNCTION
const cssTasks = (source, subtitle, uncssHTML, destination, link = true) =>
  src(source)
    .pipe(changed(`${paths.css.dest.main}/**/*.css`))
    .pipe(plumber())
    .pipe(gulpif(!PRODUCTION, sourcemaps.init()))
    .pipe(
      sass({
        precision: 4,
        includePaths: ['.'],
      }).on('error', sass.logError)
    )
    // autoprefixer (browserslist) has been set in package.json
    .pipe(autoprefixer({ cascade: false }))
    .pipe(gulpif(!PRODUCTION, sourcemaps.write()))
    .pipe(dest(paths.css.tmp))
    .pipe(
      gulpif(
        PRODUCTION,
        gulpif(
          link,
          postcss([
            uncss({
              html: uncssHTML,
              ignore: [
                /* eslint-disable max-len */
                // Bootstrap
                /\w\.fade/,
                /\.collapse?(ing)?/,
                /\.carousel(-[a-zA-Z]+)?/,

                // Custom
                /\[data-has-shared-alert\]\.is-invalid/,
                /\.[hs]laquo-[a-z0-9]+/,
                /\.[mp][btlrx]-(((sm|md|mdl|lg|xl|xxl)-)*?)[0-9s]+/,
                /\.form__control\.is-textarea\.is-touched/,
                /\.form__control\.is-touched/,
                /\.mx-(.*?)auto+/,
                /\.vk/,
                /\w\.(has-been-validated|has-spinner|is-active|is-on|is-open|is-pressed|is-touched)/,
                /\w\.(sm|md|mdl|lg|xl|xxl)/,
                /iframe/,

                /* eslint-enable max-len */
              ],
            }),
          ])
        )
      )
    )
    .pipe(gulpif(PRODUCTION, cleanCSS()))
    .pipe(size({ title: `styles: ${subtitle}` }))
    .pipe(dest(destination))
    .pipe(browserSync.stream());

// MAIN
function css(done) {
  cssTasks(
    paths.css.src.main, // src
    'main', // subtitle
    // uncssHTML; use array syntax for normal results
    [`${root.src}/pages/uncss/**/*.html`],
    paths.css.dest.main
  );
  done();
}
// #endregion

/**
 * -----------------------------------------------------------------------------
 * 📰 MARKUP
 * -----------------------------------------------------------------------------
 */
// #region

// TWIG
const prettify = require('gulp-jsbeautifier');
const twig = require('gulp-twig');

function buildTwig() {
  // build to the same folder
  return src(paths.markup.src, {
    base: './web/wp-content/themes/our-portugal-2020/src/',
  })
    .pipe(plumber())
    .pipe(
      twig({
        base: paths.markup.dest,
      })
    )
    .pipe(
      prettify({
        html: {
          indent_size: 2,
          max_preserve_newlines: 0,
          wrap_line_length: 0,
          unformatted: ['a', 'abbr', 'br', 'small', 'span', 'strong', 'svg'],
        },
      })
    )
    .pipe(size({ title: 'html' }))
    .pipe(dest(paths.markup.dest));
}
// #endregion

/**
 * -----------------------------------------------------------------------------
 * 🖼 IMAGES
 * -----------------------------------------------------------------------------
 */
// #region

const imagemin = require('gulp-imagemin');
const imageminGIF = require('imagemin-gifsicle');
const imageminJPG = require('imagemin-mozjpeg');
const imageminPNG = require('imagemin-pngquant');
const imageminSVG = require('imagemin-svgo');

// Common images function
const imgTasks = (source, subtitle) =>
  src(source, { since: lastRun(imgTasks) })
    .pipe(changed(`${paths.img.dest}/**/*`))
    .pipe(
      imagemin(
        [
          imageminGIF({
            interlaced: true,
            optimizationLevel: 3,
          }),
          imageminJPG({ quality: 85 }),
          imageminPNG([0.8, 0.9]),
          imageminSVG({
            plugins: [{ removeViewBox: false }, { cleanupIDs: false }],
          }),
        ],
        { verbose: true }
      )
    )
    .pipe(dest(`${root.dest}/img`))
    .pipe(browserSync.stream())
    .pipe(size({ title: `images: ${subtitle}` }));

// Graphics
function imgGraphics(done) {
  imgTasks(
    paths.img.src.graphics, // src
    'graphics' // subtitle
  );
  done();
}

// Content
function imgContent(done) {
  imgTasks(
    paths.img.src.content, // src
    'content' // subtitle
  );
  done();
}

exports.imgc = imgContent;

// OPTIMIZE
const img = parallel(imgGraphics, imgContent);
// #endregion

/**
 * -----------------------------------------------------------------------------
 * ❤️ SVG SPRITE
 * -----------------------------------------------------------------------------
 */
// #region

const svgSprite = require('gulp-svg-sprite');

// If we need to build several sprites, it is better to put the settings
// in a variable. And then pass it into the method call:
// .pipe(svgSprite(spriteConfig))

// const spriteConfig = {
//   mode: {
//     // put all stuff here
//   },
// };

function svg() {
  return src(paths.sprite.src)
    .pipe(
      svgSprite({
        mode: {
          symbol: {
            dest: '.', // Mode specific output directory
            sprite: 'sprite.svg', // Sprite path and name
            prefix: '.', // Prefix for CSS selectors
            dimensions: '', // Suffix for dimension CSS selectors
            example: true, // Create an HTML example document
          },
        },
        svg: {
          xmlDeclaration: false, // strip out the XML attribute
          doctypeDeclaration: false, // don't include the !DOCTYPE declaration
        },
      })
    )
    .pipe(dest(paths.sprite.dest));
}

const sprite = series(svg, parallel(css, img));
// #endregion

/**
 * -----------------------------------------------------------------------------
 * 💾 SCRIPTS
 * -----------------------------------------------------------------------------
 */
// #region
const webpack = require('webpack-stream');

function scripts() {
  return (
    src(`${root.src}/main.js`)
      .pipe(changed(`${paths.js.dest}/**/*.js`))
      .pipe(plumber())
      .pipe(
        webpack({
          mode: 'production',
          entry: `${root.src}/main.js`,
          output: {
            filename: '[name].js',
            library: 'ourPortugal',
          },
        })
      )
      // .pipe(
      //   gulpif(
      //     PRODUCTION,
      //     webpack({
      //       mode: 'production',
      //       entry: `${root.src}/main.js`,
      //       output: { filename: '[name].js' },
      //     }),
      //     webpack({
      //       mode: 'none',
      //       entry: `${root.src}/main.js`,
      //       output: { filename: '[name].js' },
      //     })
      //   )
      // )
      .pipe(dest(paths.js.dest))
      .pipe(browserSync.stream())
  );
}

// #endregion

/**
 * -----------------------------------------------------------------------------
 * 🛠 UTILITIES
 * -----------------------------------------------------------------------------
 */
// #region

// CLEAN
const del = require('del');

// Assets
function cleanAssets() {
  return del([
    // ⚠️ Use the .css extension to prevent cleaning up the whole WP theme
    `${root.dest}/*.css`,
    `${paths.css.dest.main}/**/*.css`,
    `${paths.js.dest}/**/*`,
    `${paths.img.dest}/**/*`,
  ]);
}

// COPY FILES TO DESTINATION
function copyFonts() {
  return src(`${root.src}/fonts/**/*`).pipe(dest(`${root.dest}/fonts`));
}
// #endregion

/**
 * -----------------------------------------------------------------------------
 * 📶 SERVER
 * -----------------------------------------------------------------------------
 */
// #region

const { reload } = browserSync;

function watchFiles() {
  watch(paths.css.watch, series(css));
  watch(paths.js.src.main, series(scripts));
  watch(paths.img.watch).on('change', series(img));
  watch(paths.markup.watch).on('change', series(buildTwig, reload));
}

function serve(done) {
  browserSync.init({
    server: {
      baseDir: root.server,
    },
    port: 9000,
    notify: false,
  });
  watchFiles();
  done();
}
// #endregion

/**
 * -----------------------------------------------------------------------------
 * 🏗 BUILD / DEFAULT
 * -----------------------------------------------------------------------------
 */
// #region

const build = series(svg, img, parallel(css, scripts));
// #endregion

/**
 * -----------------------------------------------------------------------------
 * ☑️ TASKS
 * -----------------------------------------------------------------------------
 */

/* eslint-disable no-multi-spaces */
exports.clean = cleanAssets;
exports.fonts = copyFonts;
exports.sprite = sprite;
exports.img = img;
exports.js = scripts;
exports.twig = buildTwig;
exports.css = css;
exports.w = watchFiles;
exports.s = serve;
exports.default = build;
