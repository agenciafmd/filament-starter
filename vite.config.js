import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';
import purge from '@erbelion/vite-plugin-laravel-purgecss';
import { join } from 'node:path';
import PluginCritical from 'rollup-plugin-critical';
import webfontDownload from 'vite-plugin-webfont-dl';

const { APP_URL } = {
  ...loadEnv(
      process.env.NODE_ENV,
      process.cwd(),
      ['VITE', 'APP'],
  ),
};

const DEFAULT_URL = 'http://localhost';
const url = APP_URL ? new URL(APP_URL) : new URL(DEFAULT_URL);
const CRITICAL_URL = `${ url.protocol }//${ url.hostname }`;

const purgeCheckPaths = [
  'packages/agenciafmd/frontend/resources/views/**/*.php',
  'resources/js/**/*.js',
  'node_modules/swiper/**/*.js',
  'node_modules/glightbox/dist/js/*.js',
  'node_modules/sweetalert2/dist/*.js',
  'node_modules/tom-select/dist/js/*.js',
  'node_modules/wow.js/dist/*.js',
  'node_modules/bootstrap/dist/js/bootstrap.min.js',
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
      refresh: true, // TODO add all paths to watch and refresh on change
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
        dimensions: [
          {
            width: 375,
            height: 667,
          },
          {
            width: 1024,
            height: 768,
          },
          {
            width: 1280,
            height: 720,
          },
          {
            width: 1366,
            height: 768,
          },
          {
            width: 1920,
            height: 1080,
          },
        ],
      },
    }),
    purge({
      paths: purgeCheckPaths,
      // Include classes we don't have direct access
      safelist: {
        greedy: [
          /lang/,
          /plyr/,
        ],
        standard: [
          /^file-upload-button/,
          /^fmd-header-/,
          // GLightbox (glightbox, gslide, gclose...), without Bootstrap gutters (g-, gx-, gy-) and gap-
          /^g(?![xy]?-|ap-)/,
          /^hs-/,
          /^js-/,
          /^swal2-/,
          /^swiper-/,
          /^ts-/,
          /^was-/,
        ],
      },
    }),
  ],
  css: {
    preprocessorOptions: {
      scss: {
        // Bootstrap 5 does not support the Sass module system (@use) yet
        quietDeps: true,
        silenceDeprecations: ['import'],
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