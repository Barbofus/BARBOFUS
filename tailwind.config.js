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

            'refusedBackground': 'var(--refusedBackground)',
            'pendingBackground': 'var(--pendingBackground)',

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
            opacityFade: {
                '0%': { opacity: 0 },
                '100%': { opacity: 1 },
            },
            topFade: {
                '0%': { opacity: 0, transform: 'translateY(calc(var(--custom-translate-y)*-1)) rotate(var(--tw-rotate)) scale(var(--tw-scale-x), var(--tw-scale-y))' },
                '100%': { opacity: 1, transform: 'translateY(var(--tw-translate-y)) rotate(var(--tw-rotate)) scale(var(--tw-scale-x), var(--tw-scale-y))' },
            },
            textSlide: {
                '0%': { transform: 'translate(0px, 0px)' },
                '100%': { transform: 'translate(-100%, 0px)' },
            },
            skinSlide: {
                '0%': { transform: 'translateX(var(--custom-translate-x))' },
                '100%': { transform: 'translateX(calc(var(--custom-translate-x) - 50%))' },
            },
            onePing: {
                '0%': { transform: 'scale(1)', opacity: 1 },
                '100%': { transform: 'scale(2)', opacity: 0  },
            },
            pulseFast: {
                '0%,25%,50%': { opacity: 0.25 },
                '12%,37%': { opacity: 0.7 },
            },
            pageLoad: {
                '0%': { opacity: 0 },
                '100%': { opacity: 1 },
            },
            dofus: {
                '0%,80%': { transform: 'translateY(0px) rotate(var(--tw-rotate))', animationTimingFunction: 'cubic-bezier(.05,.41,0,1)' },
                '25%,55%': { transform: 'translateY(-5px) rotate(var(--tw-rotate))', animationTimingFunction: 'cubic-bezier(.05,.41,0,1)' },
                '30%': { transform: 'translateY(-5px) rotate(calc(var(--tw-rotate) - 10deg))' },
                '35%': { transform: 'translateY(-5px) rotate(calc(var(--tw-rotate) + 10deg))' },
                '40%': { transform: 'translateY(-5px) rotate(calc(var(--tw-rotate) - 5deg))' },
                '45%': { transform: 'translateY(-5px) rotate(calc(var(--tw-rotate) + 5deg))' },
                '50%': { transform: 'translateY(-5px) rotate(calc(var(--tw-rotate) - 2.5deg))' },
            },
            cawotte: {
                '0%,3%,6%': { transform: 'translateY(0%) rotate(0deg)' },
                '1%,4%': { transform: 'translateY(0%) scaleY(85%)' },
                '2%,5%': { transform: 'translateY(-5px) rotate(5deg) scaleY(100%)' },
            },
            skinReflection: {
                '0%': { top: '--tw-top' },
                '100%': { top: '200%' },
            },
            feather: {
                '0%,100%': { transform: 'translateY(0px) rotate(var(--tw-rotate))' },
                '50%': { transform: 'translateY(-10px) rotate(calc(var(--tw-rotate) - 20deg))' },
            },
            featherLeft: {
                '0%,100%': { transform: 'translateY(0px) scaleX(-1) rotate(calc(var(--tw-rotate) - 40deg))' },
                '50%': { transform: 'translateY(-10px) scaleX(-1) rotate(calc(var(--tw-rotate) - 20deg))' },
            },
            slideX: {
                '0%,100%': { transform: 'translateX(calc(var(--custom-translate-x) / 2 * -1)) scale(var(--tw-scale-x), var(--tw-scale-y))' },
                '50%': { transform: 'translateX(calc(var(--custom-translate-x) / 2)) scale(var(--tw-scale-x), var(--tw-scale-y))' },
            },
            slideY: {
                '0%,100%': { transform: 'translateY(calc(var(--custom-translate-y) / 2 * -1)) scale(var(--tw-scale-x), var(--tw-scale-y))' },
                '50%': { transform: 'translateY(calc(var(--custom-translate-y) / 2)) scale(var(--tw-scale-x), var(--tw-scale-y))' },
            },
            dice: {
                '0%': { transform: 'rotate(0deg)' },
                '100%': { transform: 'rotate(720deg)' },
            },
        },
        animation: {
            skinApparition: 'skinApparition .5s linear forwards',
            opacityFade: 'opacityFade var(--custom-animation-time) linear forwards',
            topFade: 'topFade var(--custom-animation-time) ease forwards',
            textSlide: 'textSlide 5s linear infinite',
            skinSlide: 'skinSlide var(--custom-animation-time) linear infinite',
            onePing: 'onePing 0.35s linear forwards',
            pulseFast: 'pulseFast 3s linear infinite',
            pageLoad: 'pageLoad 0.5s linear forwards',
            dofus: 'dofus 2s',
            cawotte: 'cawotte 16s ease-out infinite',
            skinReflection: 'skinReflection 0.75s linear',
            feather: 'feather 5s ease-in-out infinite',
            featherLeft: 'featherLeft 5s ease-in-out infinite',
            slideX: 'slideX var(--custom-animation-time) ease-in-out infinite',
            slideY: 'slideY var(--custom-animation-time) ease-in-out infinite',
            dice: 'dice var(--custom-animation-time) ease-in-out',
        },
    },
  },
  plugins: [],
}
