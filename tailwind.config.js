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
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    blue: '#159BFC',
                    'blue-dark': '#0C7AD1',
                    'blue-light': '#5CBBFD',
                    yellow: '#FEDF01',
                    'yellow-dark': '#D9BC00',
                },
                surface: {
                    base: '#f3f4f6',
                    card: '#ffffff',
                    border: '#e5e7eb',
                },
            },
        },
    },

    plugins: [forms],
};
