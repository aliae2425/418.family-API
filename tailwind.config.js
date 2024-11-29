/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./vendor/tales-from-a-dev/flowbite-bundle/templates/**/*.html.twig",
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
  ],
  darkMode: 'media',
  theme: {
    extend: {},
  },
  plugins: [
     require('flowbite/plugin'),
  ],
}
