import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
    // Cấu hình Server để hỗ trợ ngrok và Docker
    server: {
        host: '0.0.0.0', // Cho phép truy cập từ bên ngoài container
        port: 5173,      // Cổng mặc định của Vite
        strictPort: true,
        hmr: {
            host: 'localhost', // Vite sẽ gửi các gói tin HMR qua localhost để tunnel nhận diện
        },
        // Quan trọng: Cho phép các domain ngrok truy cập vào server Vite
        allowedHosts: ['.ngrok-free.app', '.ngrok.io'] 
    },
    resolve: {
        alias: {
            '@': path.resolve(__dirname, './resources/js'),
            '~': path.resolve(__dirname, './resources'),
        },
    },
    build: {
        chunkSizeWarningLimit: 1600,
        rollupOptions: {
            output: {
                manualChunks(id) {
                    if (id.includes('node_modules')) {
                        return id.toString().split('node_modules/')[1].split('/')[0].toString();
                    }
                },
            },
        },
    },
});