import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                body : ['Libre+Baskerville']
            },
            spacing: {
                sm: '8px',
                md: '12px',
                lg: '16px',
                xl: '24px',
              }
        },
    },

    plugins: [
        require("@designbycode/tailwindcss-text-shadow")
        ({
            shadowColor: "rgba(0, 0, 0, 0.9)",
            shadowBlur: "12px",
            shadowOffsetX: "4px",
            shadowOffsetY: "3px",
        }),
    ],
};
