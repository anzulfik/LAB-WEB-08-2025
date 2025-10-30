// postcss.config.js

export default {
    plugins: {
        // Plugin 1: Mengimpor konfigurasi Tailwind CSS
        'tailwindcss': {},
        
        // Plugin 2: Digunakan untuk menambahkan prefix (seperti -webkit-) 
        // secara otomatis pada properti CSS untuk dukungan browser yang luas
        'autoprefixer': {},
    },
};