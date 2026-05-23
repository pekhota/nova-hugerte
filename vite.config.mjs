// vite.config.mjs
import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import path from 'path'

export default defineConfig(({ mode }) => ({
    plugins: [vue()],
    optimizeDeps: {
        // Don't try to prebundle Nova
        exclude: ['laravel-nova'],
    },
    build: {
        lib: {
            entry: path.resolve(__dirname, 'resources/js/field.js'),
            name: 'NovaHugerteField',
            formats: ['iife'],
            fileName: () => 'js/field.js',
            cssFileName: 'css/field.css',
        },
        outDir: 'dist',
        emptyOutDir: true,
        cssCodeSplit: false,
        rollupOptions: {
            // Treat Vue and Nova as externals
            external: ['vue', 'laravel-nova'],
            output: {
                globals: {
                    vue: 'Vue',
                    'laravel-nova': 'Nova',
                },
                // ⬇️ put it here
                inlineDynamicImports: true,
                assetFileNames: (assetInfo) =>
                    assetInfo.name?.endsWith('.css') ? 'css/field.css' : 'assets/[name]-[hash][extname]',
            },
        },
        minify: mode === 'production' ? 'esbuild' : false,
        target: 'es2018',
    },
}))
