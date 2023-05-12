module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
        colors: {
            primary: {
                DEFAULT: 'var(--anthracite)',
                100: 'var(--anthraciteLit)',
            },
            secondary: {
                DEFAULT: 'var(--ivory)',
                100: 'var(--ivoryDark)',
            },

            'goldText': 'var(--goldText)',
            'goldTextLit': 'var(--goldTextLit)',

            'heartGray': 'var(--heartGray)',
            'heartDark': 'var(--heartDark)',
            'heartLit': 'var(--heartLit)',

            'inactiveText': 'var(--inactiveText)',
        },
        fontFamily: {
            sans: ["MADE Okin", 'sans-serif'],
            display: ["MV Boli", 'sans-serif'],
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
