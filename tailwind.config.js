// tailwind.config.js
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
          DEFAULT: '#2563eb',
          foreground: '#ffffff',
          dark: '#1d4ed8'
        },
      },
    },
  },
  plugins: [],
}