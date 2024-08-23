import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            colors: {
                primary     : "#080808",
                secondary   : "#151515",
                accent      : "#252525",
            },
            fontFamily: {
                light:      ["Nunito Light"],
                regular:    ["Nunito Regular"],
                medium:     ["Nunito Medium"],
                semibold:   ["Nunito SemiBold"],
                bold:       ["Nunito Bold"],
                extrabold:  ["Nunito ExtraBold"],
            }
        },
    },

    plugins: [forms],
};
