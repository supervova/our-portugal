# Our Portugal

### Markup

- The project uses [Twig.js](https://github.com/twigjs/twig.js/wiki) HTML templating engine.
- The main content markup uses microdata:
  - [Article](http://schema.org/Article)
  - [Event](http://schema.org/Event)
  - [Offer](http://schema.org/Offer)
  - [Person](http://schema.org/Person)
  - [Product](http://schema.org/Product)
  - [Service](http://schema.org/Service)
- For information about the company, the [Jason-LD](https://schema.org/Corporation) format is used.

### Outline

```pug
.wrapper
  header.header
    nav.navbar
  main
    header.hero
      .hero__content
      .ribbon
    article.main
      .row.justify-center
        header.main__header
          h1.main__eyebrow
          p.main__title(itemprop='price')
          ul.main__summary
        .main__gallery.carousel.slide
  footer
```

See also `src/pages/boilerplate.pug`.

## CSS

- Styles are written using Bootstrap grid and utilities.
- [Sass (SCSS)](https://sass-lang.com) is used for pre-processing CSS files.
- The principles of [BEM](https://en.bem.info) and [SMACSS](http://smacss.com/) methodologies are used for naming classes: `.block__element.is-modifier`.

## JavaScript

The site code is divided into component files, which are stored in the appropriate folders. All scripts are written in vanilla JS. Each script contains short documentation in [JSDoc](https://devdocs.io/jsdoc/about-getting-started).

- `/src/base/content/content.js` — preventing the download of videos on mobile devices to save the user's mobile traffic
- `src/base/form/form.js` — validation
- `/src/components/collapsible-panel/collapsible-panel.js` — collapsible panel
- `/src/components/navbar/navbar.js` — opening the mobile drawer

### The source code architecture

```yaml
base/
  content/
    _body.scss
    _code.scss
    _headings.scss
    _lists-advanced.scss
    _media.scss
    content.js
  form/                     # Various field styles and
                            # validation script
  graphics/                 # SVG sprite source
  table/
  _animation.scss
  _buttons.scss
  _functions.scss
  _layout.scss
  _mixins.scss
  _normalize.scss
  _print.scss
  _variables.scss
components/
  alert/
  card/
  carousel/
  footer/
  hero/
  kpi/
  list-item/
  logo/
  main/
  modal/
  navbar/
  pagination/
  section/
  social-tools/
                            # And other components, their
                            # styles and scripts
pages/
  base/
    base.twig
    head.twig
    scripts.twig
  home/
  uncss/                    # Pages containing markup for
                            # which styles are optimized
  wip/                      # Source files for new pages
  boilerplate.pug           # Page layout outline
util/
  _content.scss
  _dev.scss
  _layout.scss
style.scss                  # The main SCSS file into which
                            # all the above fragments are
                            # imported.
```

## The Timber Starter Theme

The theme is based on the Timber Starter Theme: a dead-simple theme that you can build from.

1. Make sure you have installed the plugin for the [Timber Library](https://wordpress.org/plugins/timber-library/) (and Advanced Custom Fields - they [play quite nicely](https://timber.github.io/docs/guides/acf-cookbook/#nav) together).
2. Activate the theme in Appearance >  Themes.
3. Do your thing! And read [the docs](https://github.com/jarednova/timber/wiki).

### What's here?

`templates/` contains all of your Twig templates. These pretty much correspond 1 to 1 with the PHP files that respond to the WordPress template hierarchy. At the end of each PHP template, you'll notice a `Timber::render()` function whose first parameter is the Twig file where that data (or `$context`) will be used. Just an FYI.

`bin/` and `tests/` ... basically don't worry about (or remove) these unless you know what they are and want to.

### Other Resources

The [main Timber Wiki](https://github.com/jarednova/timber/wiki) is super great, so reference those often. Also, check out these articles and projects for more info:

- [This branch](https://github.com/laras126/timber-starter-theme/tree/tackle-box) of the starter theme has some more example code with ACF and a slightly different set up.
- [Twig for Timber Cheatsheet](http://notlaura.com/the-twig-for-timber-cheatsheet/)
- [Timber and Twig Reignited My Love for WordPress](https://css-tricks.com/timber-and-twig-reignited-my-love-for-wordpress/) on CSS-Tricks
- [A real live Timber theme](https://github.com/laras126/yuling-theme).
- [Timber Video Tutorials](http://timber.github.io/timber/#video-tutorials) and [an incomplete set of screencasts](https://www.youtube.com/playlist?list=PLuIlodXmVQ6pkqWyR6mtQ5gQZ6BrnuFx-) for building a Timber theme from scratch.

## How to work with frontend sources

The project uses [Gulp](https://gulpjs.com) — a cross-platform, streaming task runner that automate all development tasks including a build process.

1. Install [Node.js](https://nodejs.org/en/).
2. For Windows, you may need to install a Unix shell command line interface, such as [Git Bash](https://git-scm.com/downloads).
3. Check npm (node package manager) is installed via command prompt: `$ npm`.
4. Open terminal from this folder and run `$ npm install`.
5. Run `$ npm install gulp-cli -g` to install Gulp CLI.
6. Check Gulp CLI is installed via `$ gulp --help`.
7. Run development server: `$ gulp s`. Or build for production:  `$ gulp --p`

More information can be found inside gulpfile.js.


