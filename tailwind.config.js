import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                brand: {
                    50: '#EEF5FF',
                    100: '#D9E9FF',
                    500: '#3EA3D9',
                    600: '#304A89',
                    700: '#263C73',
                    800: '#1F315F',
                    900: '#18264B',
                },
                logo: {
                    sky: '#3EA3D9',
                    pink: '#D92D73',
                    green: '#84C341',
                    orange: '#F47B2A',
                    yellow: '#F6B739',
                },
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
