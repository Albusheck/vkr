import { fileURLToPath, URL } from 'node:url'

import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
  server: {
    host: '0.0.0.0',
  },
  define: {
    'API_AUTH_KEY': JSON.stringify(process.env.API_AUTH_KEY),
    'API_BASE_URL': JSON.stringify(process.env.API_BASE_URL),
  },
  plugins: [
    vue(),
  ],
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url))
    }
  },
  build: {
    outDir: '/app-web',
    assetsDir: 'app-spa',
    assetsInlineLimit: 1024,
    rollupOptions: {
      output: {
        entryFileNames: 'app-spa/app.js',
        assetFileNames: "app-spa/asset.[ext]",
      },
    },
  },
})
