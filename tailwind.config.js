/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './templates/**/*.html.twig',
    './assets/**/*.js',
  ],
  theme: {
    extend: {
      boxShadow: {
        '3xl' : '0px 15px 50px 1px #EB1A9181',
      },
    },
    fontFamily: {
      'sans': ['Hammersmith One', 'sans-serif'],
    },
  },
  daisyui: {
    themes: [
      {
        'blossom-dark': {
          "primary": "#EB1A91",
          "secondary": "#f3f4f6",
          "accent": "#ffe4e6",
          "neutral": "#EB1A91",
          "base-100": "#131313",
          "info": "#3ABFF8",
          "success": "#36D399",
          "warning": "#FBBD23",
          "error": "#F87272",
        },
        'blossom-light': {
          "primary": "#EB1A91",
          "secondary": "#f3f4f6",
          "accent": "#ffe4e6",
          "neutral": "#EB1A91",
          "base-100": "#FFFFFF",
          "info": "#3ABFF8",
          "success": "#36D399",
          "warning": "#FBBD23",
          "error": "#F87272",
        },
      },
    ],
  },
  plugins: [require("daisyui")],
}
