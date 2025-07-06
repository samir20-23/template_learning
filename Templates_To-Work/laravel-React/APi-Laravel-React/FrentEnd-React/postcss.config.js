module.exports = {
  plugins: [
    require('@tailwindcss/postcss')({
      plugins: [require('tailwindcss'), require('autoprefixer')],
    }),
  ],
}
