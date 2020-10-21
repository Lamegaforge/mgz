const { colors } = require('tailwindcss/defaultTheme');
module.exports = {
    future: {
        removeDeprecatedGapUtilities: true,
        purgeLayersByDefault: true,
    },
    purge: {
        content: ['./resources/views/**/*.blade.php', './resources/js/components/*.vue']
    },
    theme: {
        fontFamily: {
            sans: ['"Titillium Web"'],
        },
        colors: {
            transparent: 'transparent',
            current: 'current',
            black: '#0e1015',
            white: colors.white,
            gray: colors.gray,
            red: colors.red,
            yellow: colors.yellow,
            green: colors.green,
            blue: colors.blue,
            indigo: colors.indigo,
            teal: colors.teal,
            orange: colors.orange,
        },
        extend: {
            padding: {
                'full': '100%',
                '2/1': '50%',
                '3/1': '33.333%',
                '2/3': '150%',
                '3/4': '133.3333%',
                '4/5': '125%',
                '16/9': '56.25%'
            },
            height: {
                '400px': '400px'
            },
            minWidth: {
                '350px': '350px'
            },
            maxWidth: {
                '7xl': '80rem'
            },
            transitionProperty: {
                translate: 'translate'
            }
        }
    },
    variants: {
        scale: ['responsive', 'hover', 'group-hover'],
        textColor: ['responsive', 'hover', 'group-hover'],
    },
    plugins: [require("@tailwindcss/custom-forms")],
}