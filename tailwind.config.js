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
                sans: ['"Plus Jakarta Sans"', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                ink: '#0f172a',
                navy: { 900: '#0c1222', 800: '#131b31', 700: '#1b2347' },
                gold: { 300: '#f1d58a', 400: '#e9cf8c', 500: '#c8a14a', 600: '#a8812f' },
                brand: { 50: '#eef0ff', 500: '#4f46e5', 600: '#4338ca', 700: '#3730a3' },
            },
        },
    },

    plugins: [forms],
};
