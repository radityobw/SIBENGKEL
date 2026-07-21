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
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                sora: ['Sora', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                "on-secondary": "#ffffff",
                "outline-variant": "#c4c6cf",
                "on-tertiary-container": "#62a5f9",
                "on-primary-fixed": "#001c3b",
                "on-background": "#191c1e",
                "error": "#ba1a1a",
                "tertiary": "#002447",
                "on-secondary-fixed": "#2f1500",
                "surface-container-low": "#f2f4f6",
                "primary-container": "#1e3a5f",
                "surface-bright": "#f8f9fb",
                "surface": "#f8f9fb",
                "on-primary-container": "#8aa4cf",
                "inverse-on-surface": "#f0f1f3",
                "surface-container-lowest": "#ffffff",
                "on-tertiary": "#ffffff",
                "surface-container-highest": "#e1e2e4",
                "primary-fixed-dim": "#adc8f5",
                "primary": "#022448",
                "secondary-fixed": "#ffdcc3",
                "secondary": "#904d00",
                "tertiary-fixed": "#d4e3ff",
                "on-primary-fixed-variant": "#2d486d",
                "surface-tint": "#455f87",
                "tertiary-fixed-dim": "#a4c9ff",
                "on-error-container": "#93000a",
                "secondary-fixed-dim": "#ffb77d",
                "on-error": "#ffffff",
                "surface-dim": "#d9dadc",
                "surface-variant": "#e1e2e4",
                "surface-container": "#edeef0",
                "inverse-surface": "#2e3132",
                "on-tertiary-fixed": "#001c39",
                "surface-container-high": "#e7e8ea",
                "tertiary-container": "#003a6c",
                "outline": "#74777f",
                "inverse-primary": "#adc8f5",
                "on-surface-variant": "#43474e",
                "on-primary": "#ffffff",
                "on-tertiary-fixed-variant": "#004883",
                "on-secondary-container": "#713b00",
                "primary-fixed": "#d5e3ff",
                "on-surface": "#191c1e",
                "background": "#f8f9fb",
                "secondary-container": "#ffa454",
                "on-secondary-fixed-variant": "#6e3900",
                "error-container": "#ffdad6"
            }
        },
    },

    plugins: [forms],
};
