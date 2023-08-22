const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    prefix: 'tw-',
    important: true,
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    DEFAULT: '#07102a'
                },
                secondary: {
                    DEFAULT: '#e3ecf1'
                },
                accent: {
                    DEFAULT: '#9C27B0'
                },
                dark: {
                    DEFAULT: '#1D1D1D'
                },
                positive: {
                    DEFAULT: '#16aa1b'
                },
                negative: {
                    DEFAULT: '#ff0000'
                },
                info: {
                    DEFAULT: '#0085ff'
                },
                warning: {
                    DEFAULT: '#f3b900'
                },
                'corporate-black': {
                    DEFAULT: '#A3ABBD',
                    10: '#FAFBFC',
                    20: '#F3F6FA',
                    30: '#E1E5EB',
                    40: '#BDC7D3',
                    50: '#A3ABBD',
                    60: '#8A90A7',
                    70: '#6F7390',
                    80: '#59577A',
                    90: '#443C63',
                    100: '#322550',
                    110: '#1F0E3D',
                  },
                  green: {
                    DEFAULT: '#33DF6B',
                    10: '#DCFFE6',
                    20: '#C3FED4',
                    30: '#7CFCA3',
                    40: '#36FA71',
                    50: '#33DF6B',
                    60: '#31C365',
                    70: '#2EA75F',
                    80: '#2A7E56',
                    90: '#26554D',
                    100: '#1C3F39',
                  },
                  'careful-blue': {
                    DEFAULT: '#0053ED',
                    10: '#EEF5FF',
                    20: '#DFECFE',
                    30: '#C7DFFD',
                    40: '#87B9FB',
                    50: '#6196EC',
                    60: '#0053ED',
                    70: '#002EE3',
                    80: '#010AAF',
                    90: '#00077B',
                    100: '#111448',
                  },
                  'immersive-red': {
                    DEFAULT: '#FD6969',
                    50: '#FFECEC',
                    100: '#FFDFDF',
                    200: '#FEC8C8',
                    300: '#FDA9A9',
                    400: '#FD8989',
                    500: '#FD6969',
                    600: '#FC4949',
                    700: '#D63E47',
                    800: '#AF3445',
                    900: '#612041',
                  },
                  orange: {
                    DEFAULT: '#FF8212',
                    50: '#FFF0E3',
                    100: '#FFE2C9',
                    200: '#FFCFA5',
                    300: '#FFBB80',
                    400: '#FFA85B',
                    500: '#FF8212',
                    600: '#E7680D',
                    700: '#CF4E09',
                    800: '#B63404',
                    900: '#9E1A00',
                  },
                  yellow: {
                    DEFAULT: '#E7A80D',
                    50: '#FFF5D6',
                    100: '#FEEBAF',
                    200: '#FDDC7C',
                    300: '#FCCE48',
                    400: '#FBBF14',
                    500: '#E7A80D',
                    600: '#D39007',
                    700: '#BF7800',
                    800: '#9F5600',
                    900: '#7F3300',
                  },
            }
        }
    },

    plugins: [require('@tailwindcss/forms')],
};
