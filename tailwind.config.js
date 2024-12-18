/** @type {import('tailwindcss').Config} */
module.exports = {
  "darkMode": "media",
  content: [
    "./vendor/tales-from-a-dev/flowbite-bundle/templates/**/*.html.twig",
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
  ],
  theme: {
    screens: {
      sm: { max: "639px" },

      md: { max: "767px" },

      lg: { max: "1023px" },

      xl: { max: "1279px" },
    },
    extend: {},
  },
  plugins: [
    require('flowbite/plugin') // add the flowbite plugin
  ],
}
