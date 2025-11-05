// tailwind.config.js

/** @type {import('tailwindcss').Config} */
export default {
    // MENGGANTIKAN @source
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
    ],
    theme: {
        // MENGGANTIKAN @theme
        extend: {
            fontFamily: {
                sans: [
                    'Instrument Sans', 
                    'ui-sans-serif', 
                    'system-ui', 
                    'sans-serif', 
                    'Apple Color Emoji', 
                    'Segoe UI Emoji',
                    'Segoe UI Symbol', 
                    'Noto Color Emoji'
                ],
            },
        },
    },
    plugins: [],
};