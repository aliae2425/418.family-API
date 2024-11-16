/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
  ],
  theme: {
    extend: {
      'white-linen': {
        '50': '#f9f5f3',
        '100': '#f1eae4',
        '200': '#e1d2c7',
        '300': '#ceb4a3',
        '400': '#ba917d',
        '500': '#ab7964',
        '600': '#9e6858',
        '700': '#84554a',
        '800': '#6c4640',
        '900': '#583b36',
        '950': '#2f1e1b',
      },
    },
  },
  plugins: [
     require('@tailwindcss/forms'),
  ],
}
