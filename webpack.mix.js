const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss')
require("laravel-mix-vue3");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.webpackConfig({
  resolve: {
    alias: {
      'vue': 'vue/dist/vue.esm-bundler.js'
    },
  },
  module: {
    rules: [
      {
        test: /\.js$/, exclude: /node_modules/, loader: "babel-loader"
      }
    ]
  }
})


mix.vue3("resources/js/app.js", "public/js")

mix.sass('resources/sass/app.scss', 'public/css')
  .options({
    processCssUrls: false,
    postCss: [tailwindcss('./tailwind.config.js')],
  })
