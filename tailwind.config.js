export default {
  darkMode: 'class',
  content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.vue",
  ],
  theme: {
      extend: {
        colors: {
          primary: {
            DEFAULT: '#2563eb', // Example blue color
            foreground: '#ffffff', // White text
            dark: '#1d4ed8'
          },
        },
        transitionProperty: {
            'transform': 'transform'
        },
        transitionDuration: {
            '300': '300ms'
        },
        transitionTimingFunction: {
            'ease-in-out': 'ease-in-out'
        }
      },
    },
    plugins: [],
  }
