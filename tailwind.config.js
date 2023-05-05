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
                '0%': { opacity: 0, transform: 'translateX(40px)' },
                '100%': { opacity: 1, transform: 'translateX(0px)' },
            }
        },
        animation: {
            skinApparition: 'skinApparition 0.5s linear',
        }
    },
  },
  plugins: [],
}
