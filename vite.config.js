import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';
import purge from '@erbelion/vite-plugin-laravel-purgecss';
import { join } from 'node:path';
import PluginCritical from 'rollup-plugin-critical';
import webfontDownload from 'vite-plugin-webfont-dl';
import prefixCustomProperties from 'postcss-prefix-custom-properties';

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

const assetFolders = {
  css: /\.css$/,
  fonts: /\.(woff2?|ttf|otf|eot)$/,
  svg: /\.svg$/,
  images: /\.(png|jpe?g|gif|webp|avif|ico|bmp)$/,
};

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/scss/frontend.scss',
        'resources/js/frontend-imports.js',
        'resources/js/pages/theme.js',
        'resources/js/components/sliders/articles.js',
        'resources/js/components/sliders/banners.js',
        'resources/js/components/share-api.js',
      ],
      assets: [
        'resources/images/**',
        'resources/fonts/**',
      ],
      refresh: [
        'resources/views/**',
        'routes/**',
        'lang/**',
        'packages/agenciafmd/**/resources/views/**',
        'packages/agenciafmd/**/src/**/*.php',
      ],
    }),
    webfontDownload([
      'https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap',
    ]),
    PluginCritical({
      criticalUrl: `${ CRITICAL_URL }/html/`,
      criticalBase: 'public/css/critical',
      criticalPages: [
        {
          uri: '', template: 'index',
        },
      ],
      criticalConfig: {
        // One viewport per breakpoint of $grid-breakpoints (resources/scss/frontend/_variables.scss)
        dimensions: [
          { width: 375, height: 667 }, // xs
          { width: 768, height: 1024 }, // sm
          { width: 1024, height: 768 }, // md
          { width: 1366, height: 768 }, // lg
          { width: 1920, height: 1080 }, // xl
        ],
      },
    }),
    purge({
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
          /^js-/,
        ],
      },
    }),
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
    },
  },
});