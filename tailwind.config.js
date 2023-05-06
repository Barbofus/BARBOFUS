module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
        keyframes: {
            skinApparition: {
                '0%': { opacity: 0 },
                '100%': { opacity: 1 },
            }
        },
        animation: {
            skinApparition: 'skinApparition 0.5s linear forwards',
        }
    },
  },
  plugins: [],
}
