import { defineConfig, loadEnv } from 'vite';
import path from 'path';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig(({ mode }) => {
	const env = loadEnv(mode, process.cwd(), '');

	return {
		plugins: [tailwindcss()],
		build: {
			manifest: true,
			outDir: path.resolve(__dirname, env.VITE_OUT_DIR),
			emptyOutDir: true,
			rollupOptions: {
				input: {
					main: path.resolve(__dirname, env.VITE_MAIN_ROOT),
				},
			},
		},
	};
});
