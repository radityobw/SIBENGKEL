import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    darkMode: 'class',

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                sora: ['Sora', ...defaultTheme.fontFamily.sans],
                "label-md": ["Inter"],
                "body-lg": ["Inter"],
                "headline-lg-mobile": ["Sora"],
                "body-md": ["Inter"],
                "headline-md": ["Sora"],
                "headline-xl": ["Sora"],
                "label-sm": ["Inter"],
                "headline-lg": ["Sora"]
            },
            fontSize: {
                "label-md": ["14px", { "lineHeight": "20px", "letterSpacing": "0.01em", "fontWeight": "600" }],
                "body-lg": ["18px", { "lineHeight": "28px", "fontWeight": "400" }],
                "headline-lg-mobile": ["24px", { "lineHeight": "32px", "fontWeight": "600" }],
                "body-md": ["16px", { "lineHeight": "24px", "fontWeight": "400" }],
                "headline-md": ["20px", { "lineHeight": "28px", "fontWeight": "600" }],
                "headline-xl": ["40px", { "lineHeight": "48px", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                "label-sm": ["12px", { "lineHeight": "16px", "letterSpacing": "0.02em", "fontWeight": "500" }],
                "headline-lg": ["32px", { "lineHeight": "40px", "letterSpacing": "-0.01em", "fontWeight": "600" }]
            },
            spacing: {
                "sm": "16px",
                "lg": "32px",
                "base": "4px",
                "md": "24px",
                "margin-mobile": "16px",
                "margin-desktop": "32px",
                "xl": "48px",
                "xs": "8px",
                "gutter": "20px"
            },
            borderRadius: {
                "DEFAULT": "0.25rem",
                "lg": "0.5rem",
                "xl": "0.75rem",
                "full": "9999px"
            },
            colors: {
                "on-secondary": "#ffffff",
                "outline-variant": "var(--color-outline-variant, #c4c6cf)",
                "on-tertiary-container": "#62a5f9",
                "on-primary-fixed": "#001c3b",
                "on-background": "var(--color-on-background, #191c1e)",
                "error": "#ba1a1a",
                "tertiary": "#111111",
                "on-secondary-fixed": "#2f1500",
                "surface-container-low": "var(--color-surface-container-low, #f2f4f6)",
                "primary-container": "#1a1a1a",
                "surface-bright": "var(--color-surface-bright, #f8f9fb)",
                "surface": "var(--color-surface, #f8f9fb)",
                "on-primary-container": "#8aa4cf",
                "inverse-on-surface": "#f0f1f3",
                "surface-container-lowest": "var(--color-surface-container-lowest, #ffffff)",
                "on-tertiary": "#ffffff",
                "surface-container-highest": "var(--color-surface-container-highest, #e1e2e4)",
                "primary-fixed-dim": "#cccccc",
                "primary": "var(--color-primary, #000000)",
                "secondary-fixed": "#ffdcc3",
                "secondary": "#FF6B00",
                "tertiary-fixed": "#d4e3ff",
                "on-primary-fixed-variant": "#2d486d",
                "surface-tint": "#455f87",
                "tertiary-fixed-dim": "#a4c9ff",
                "on-error-container": "#93000a",
                "secondary-fixed-dim": "#ffb77d",
                "on-error": "#ffffff",
                "surface-dim": "var(--color-surface-dim, #d9dadc)",
                "surface-variant": "var(--color-surface-variant, #e1e2e4)",
                "surface-container": "var(--color-surface-container, #edeef0)",
                "inverse-surface": "#2e3132",
                "on-tertiary-fixed": "#001c39",
                "surface-container-high": "var(--color-surface-container-high, #e7e8ea)",
                "tertiary-container": "#222222",
                "outline": "var(--color-outline, #74777f)",
                "inverse-primary": "#adc8f5",
                "on-surface-variant": "var(--color-on-surface-variant, #43474e)",
                "on-primary": "var(--color-on-primary, #ffffff)",
                "on-tertiary-fixed-variant": "#004883",
                "on-secondary-container": "#713b00",
                "primary-fixed": "#d5e3ff",
                "on-surface": "var(--color-on-surface, #191c1e)",
                "background": "var(--color-background, #f8f9fb)",
                "secondary-container": "#ffa454",
                "on-secondary-fixed-variant": "#6e3900",
                "error-container": "#ffdad6"
            }
        },
    },

    plugins: [forms],
};
