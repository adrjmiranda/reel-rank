import Alpine from 'alpinejs';
import './index.css';
import navbar from './components/navbar';
import imagePreview from './components/image-preview';
import dashboardRow from './components/dashboard-row';

declare global {
	interface Window {
		Alpine: typeof Alpine;
	}
}

window.Alpine = Alpine;

document.addEventListener('alpine:init', () => {
	Alpine.store('loading', {
		open: false,
		show() {
			this.open = true;
		},
		hide() {
			this.open = false;
		},
	});
	Alpine.store('toast', {
		message: '',
		type: 'success',
		visible: false,
		timeout: null as number | null,

		show(message: string, type: 'success' | 'error' | 'warning' = 'success') {
			this.message = message;
			this.type = type;
			this.visible = true;

			if (this.timeout) clearTimeout(this.timeout);

			this.timeout = window.setTimeout(() => {
				this.visible = false;
			}, 3000);
		},
	});

	Alpine.data('navbar', navbar);
	Alpine.data('imagePreview', imagePreview);
	Alpine.data('dashboardRow', dashboardRow);
});

Alpine.start();
