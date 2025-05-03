import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'

export default defineConfig({
  optimizeDeps: {
    include: ['alpinejs'],
    exclude: ['@alpinejs/persist']
},
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/livewire.js','resources/js/app.js', 'resources/js/client.js'],
      refresh: true,
    }),
  ],
  css: {
    postcss: './postcss.config.mjs'
  }
})