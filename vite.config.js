import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';
import purge from '@erbelion/vite-plugin-laravel-purgecss';
import { join } from 'node:path';
import webfontDownload from 'vite-plugin-webfont-dl';
import prefixCustomProperties from 'postcss-prefix-custom-properties';
import critical from './resources/js/utilities/critical.js';

const { APP_URL } = loadEnv(
    process.env.NODE_ENV,
    process.cwd(),
    ['VITE', 'APP'],
);

const DEFAULT_URL = 'http://localhost';
const url = APP_URL ? new URL(APP_URL) : new URL(DEFAULT_URL);
// Without the port on purpose: the build runs inside the Sail container, where the app listens on port 80
// (the APP_URL port, e.g. 8081, only exists on the host)
const CRITICAL_URL = `${ url.protocol }//${ url.hostname }`;

// External font: vite-plugin-webfont-dl downloads it at build time and serves it from the build itself (webfonts.css).
// To change the font: build the URL on fonts.google.com with only the weights in use, and update the
// font-family of the maps in resources/scss/frontend/_fonts.scss.
// To use only a local font: leave this list empty and turn on $should-use-local-font-face in _fonts.scss.
const webfonts = [
  'https://fonts.googleapis.com/css2?family=Roboto:wght@300..700&display=swap',
];

// Third-party libs: their classes survive the purge and their custom properties don't get the bs- prefix
const vendorPrefixes = [/^swal2-/, /^swiper-/, /^plyr-/];

const purgeCheckPaths = [
  'packages/agenciafmd/frontend/resources/views/**/*.php',
  'resources/js/**/*.js',
  'node_modules/swiper/**/*.js',
  'node_modules/glightbox/dist/js/*.js',
  'node_modules/sweetalert2/dist/*.js',
  'node_modules/wow.js/dist/*.js',
  'node_modules/bootstrap/js/dist/**/*.js',
]
    .map((path) => join(import.meta.dirname, path));

// Component catalog (/html/tema): it shows every component, so it stays out of the global purge and
// loads its own stylesheet (resources/scss/pages/theme.scss). New pages are purged as usual.
const catalogView = 'packages/agenciafmd/frontend/resources/views/html/tema.blade.php';

const isCatalogCss = (file) => file.includes('/theme-');

const purgeOptions = {
  paths: purgeCheckPaths,
  // Bootstrap 6 uses prefixed classes (md:col-6, hover:opacity-50); keep the split words too
  defaultExtractor: (content) => [
    ...(content.match(/[\w:-]+/g) ?? []),
    ...(content.match(/[\w-]+/g) ?? []),
  ],
  // Include classes we don't have direct access
  safelist: {
    greedy: [
      // Bootstrap 6 RTL rules for the drawer (:root:is(:lang(ar), ...) .drawer)
      /lang/,
      /plyr/,
      // Bootstrap 6 datepicker (vanilla-calendar-pro renders the calendar at runtime)
      /data-vc/,
    ],
    standard: [
      ...vendorPrefixes,
      /^file-upload-button/,
      /^fmd-header-/,
      // GLightbox (glightbox, gslide, gclose...), without Bootstrap gutters (g-, gx-, gy-) and gap-
      /^g(?![xy]?-|ap-)/,
      // GLightbox description position, built at runtime ("desc-" + position, "description-" + position)
      /^desc(ription)?-/,
      /^js-/,
      // Bootstrap 6 avatar sizes and status, built in components/avatar.blade.php ("avatar-{$size}", "status-{$status}")
      /^avatar-/,
      /^status-/,
      // HTML from the database (admix rich editor) never shows up in the views
      /^(table|thead|tbody|tfoot|tr|th|td|caption|figure|figcaption|blockquote|kbd|abbr|code|pre|mark|dl|dt|dd|hr|sub|sup)$/,
    ],
  },
};

// The purge plugin handles every css file of the build: this runs it only on the files accepted by `filter`
const purgeOnly = (filter, options) => {
  const plugin = purge(options);
  const { generateBundle } = plugin;

  plugin.generateBundle = function (outputOptions, bundle) {
    const files = Object.entries(bundle).filter(([file]) => filter(file));

    return generateBundle.call(this, outputOptions, Object.fromEntries(files));
  };

  return plugin;
};

const assetFolders = {
  css: /\.css$/,
  fonts: /\.(woff2?|ttf|otf|eot)$/,
  svg: /\.svg$/,
  images: /\.(png|jpe?g|gif|webp|avif|ico|bmp)$/,
  videos: /\.(mp4|webm|ogv|mov)$/,
  pdf: /\.pdf$/,
};

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/scss/frontend.scss',
        'resources/scss/pages/theme.scss',
        'resources/js/frontend-imports.js',
        'resources/js/pages/theme.js',
        'resources/js/components/sliders/articles.js',
        'resources/js/components/sliders/banners.js',
        'resources/js/components/share-api.js',
      ],
      assets: [
        'resources/images/**',
        'resources/fonts/**',
        'resources/videos/**',
        'resources/pdf/**',
      ],
      refresh: [
        'resources/views/**',
        'routes/**',
        'lang/**',
        'packages/agenciafmd/**/resources/views/**',
        'packages/agenciafmd/**/src/**/*.php',
      ],
    }),
    ...(webfonts.length ? [webfontDownload(webfonts)] : []),
    // Critical css of every page of views/html (resources/js/utilities/critical.js)
    critical(`${ CRITICAL_URL }/html/`),
    // Every css file but the catalog's (frontend.css and the lazy vendor chunks)
    purgeOnly((file) => !isCatalogCss(file), {
      ...purgeOptions,
      // The catalog would keep every component in the global css
      skippedContentGlobs: [join(import.meta.dirname, catalogView)],
    }),
    // The catalog's css, purged against every view (the catalog included)
    purgeOnly(isCatalogCss, purgeOptions),
  ],
  css: {
    postcss: {
      plugins: [
        // Bootstrap 6 Sass outputs unprefixed custom properties; the bs- prefix is added here
        prefixCustomProperties({
          prefix: 'bs-',
          ignore: [
            /^bs-/,
            ...vendorPrefixes,
            /^(loading|glow|header)-/,
          ],
        }),
      ],
    },
    preprocessorOptions: {
      scss: {
        quietDeps: true,
      },
    },
  },
  build: {
    rolldownOptions: {
      output: {
        entryFileNames: 'assets/js/[name]-[hash].js',
        chunkFileNames: 'assets/js/[name]-[hash].js',
        assetFileNames: ({ names }) => {
          const name = names[0] ?? '';
          const folder = Object.entries(assetFolders)
              .find(([, pattern]) => pattern.test(name))?.[0];

          return folder
              ? `assets/${ folder }/[name]-[hash][extname]`
              : 'assets/[name]-[hash][extname]';
        },
      },
    },
  },
  resolve: {
    // to improve JS imports
    alias: {
      '@fonts': '/resources/fonts',
      '@svg': '/resources/svg',
      '@images': '/resources/images',
      '@videos': '/resources/videos',
      '@pdf': '/resources/pdf',
    },
  },
});