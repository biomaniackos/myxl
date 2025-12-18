const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');

module.exports = {
    darkMode: false, // or 'media' or 'class'
    future:   {
        purgeLayersByDefault:         true,
        removeDeprecatedGapUtilities: true,
    },
    mode:     'jit',     // Voir : https://tailwindcss.com/docs/just-in-time-mode
    plugins:  [
        require('@tailwindcss/aspect-ratio'),
        require('@tailwindcss/forms'),
        require('@tailwindcss/line-clamp'),
        require('tailwindcss-children'),
        require('tailwindcss-debug-screens'),
        require('tailwindcss-elevation')([ 'responsive' ]),
        require('tailwindcss-responsive-embed'),
        ({addUtilities, e, theme}) => {
            const unpack = (obj, prefix = '') => {
                return Object.keys(obj).reduce((acc, key) => {
                    if (typeof (obj[key]) === 'string') {
                        acc[prefix ? `${prefix}-${key}` : key] = obj[key];
                    } else {
                        acc = {...acc, ...unpack(obj[key], key)};
                    }

                    return acc;
                }, {});
            };

            const utilities = {
                '.container': {
                    marginInline: 'auto',
                    maxWidth: '1061px',
                },
                '.container-wide': {
                    marginInline: 'auto',
                    maxWidth: '1280px',
                },
                '.container-full': {
                    marginInline: 'auto',
                    maxWidth: '100%',
                },
            };

            // Add components colors support
            const colors = unpack(theme('colors'));
            Object.keys(colors).forEach((key) => {
                utilities[`.${e(`has-${key}-background-color`)}`] = {
                    backgroundColor: colors[key],
                };
                utilities[`.${e(`has-${key}-color`)}`] = {
                    color: colors[key],
                };
            });

            addUtilities(utilities);
        },
    ],
    // /!\ uniquement hors JIT !!
    purge: {
        enabled:           true,
        content:           [
            './dist/**/*.html',
            './src/**/*.{js,jsx,ts,tsx,vue}',
            // used with Sage
            './index.php',
            './../../mu-plugins/app/src/components/**/*.php',
            // used with Laravel
            './resources/**/*.{js,jsx,ts,tsx,vue}',
            './resources/**/*.blade.php',
        ],
        whitelistPatterns: [
            /^home(-.*)?$/,
            /^blog(-.*)?$/,
            /^archive(-.*)?$/,
            /^date(-.*)?$/,
            /^error404(-.*)?$/,
            /^admin-bar(-.*)?$/,
            /^search(-.*)?$/,
            /^nav(-.*)?$/,
            /^wp(-.*)?$/,
            /^screen(-.*)?$/,
            /^navigation(-.*)?$/,
            /^(.*)-template(-.*)?$/,
            /^(.*)?-?single(-.*)?$/,
            /^postid-(.*)?$/,
            /^post-(.*)?$/,
            /^attachmentid-(.*)?$/,
            /^attachment(-.*)?$/,
            /^page(-.*)?$/,
            /^(post-type-)?archive(-.*)?$/,
            /^author(-.*)?$/,
            /^category(-.*)?$/,
            /^tag(-.*)?$/,
            /^menu(-.*)?$/,
            /^tags(-.*)?$/,
            /^tax-(.*)?$/,
            /^term-(.*)?$/,
            /^date-(.*)?$/,
            /^(.*)?-?paged(-.*)?$/,
            /^depth(-.*)?$/,
            /^children(-.*)?$/,
        ],
        options:           {
            safelist: {
                greedy: [
                    /-background-color$/,
                    /-color$/,
                ],
            },
        },
    },
    // @see https://tailwindcss.com/docs/theme
    theme:    {
        // override default theme
        // @see https://tailwindcss.com/docs/customizing-colors
        colors: {
            black: colors.black,
            danger: '#FF4707',
            dark: colors.black,
            gray: colors.coolGray,
            info: colors.cyan,
            light: colors.white,
            primary: {
                800: '#051074',
                400: '#3097F2',
                100: '#B8EDFF',
            },
            secondary: {
                400: '#6633A7',
                100: '#9B4DFF',
                50: '#C699FF',
            },
            success: '#28A745',
            transparent: 'transparent',
            warning: '#FED70A',
            white: colors.white,
        },

        extend: {
            // extend default theme
            // colors: {},
            fontFamily: {
                sans: [
                    'Roboto', ...defaultTheme.fontFamily.sans,
                ],
                // ibm: [
                //     'IBM Plex Sans', ...defaultTheme.fontFamily.sans,
                // ],
            },
        },
    },
    // @see https://tailwindcss.com/docs/configuration#variants
    variants: {
        extend: {},
    },
};
