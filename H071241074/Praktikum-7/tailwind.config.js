const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
  theme: {
    extend: {
      fontFamily: {
        'sans': ['Coolvetica', ...defaultTheme.fontFamily.sans], 
        'cool': ['Coolvetica', ...defaultTheme.fontFamily.sans], 
      },
    },
  },
};