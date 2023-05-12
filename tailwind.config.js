module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
        colors: {
            'anthracite': 'var(--anthracite)',
            'anthraciteLit': 'var(--anthraciteLit)',

            'ivory': 'var(--ivory)',
            'ivoryDark': 'var(--ivoryDark)',

            'goldText': 'var(--goldText)',
            'goldTextLit': 'var(--goldTextLit)',

            'heartGray': 'var(--heartGray)',
            'heartDark': 'var(--heartDark)',
            'heartLit': 'var(--heartLit)',

            'inactiveText': 'var(--inactiveText)',
        },
        keyframes: {
            skinApparition: {
                '0%': { opacity: 0 },
                '100%': { opacity: 1 },
            },
            textSlide: {
                '0%': { transform: 'translate(0px, 0px)' },
                '100%': { transform: 'translate(-100%, 0px)' },
            }
        },
        animation: {
            skinApparition: 'skinApparition 0.5s linear forwards',
            textSlide: 'textSlide 5s linear infinite',
        }
    },
  },
  plugins: [],
}
