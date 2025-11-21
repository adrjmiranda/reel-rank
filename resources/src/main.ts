import Alpine from 'alpinejs';
import './index.css';
import navbar from './components/navbar';
import imagePreview from './components/image-preview';

declare global {
	interface Window {
		Alpine: typeof Alpine;
	}
}

window.Alpine = Alpine;

Alpine.data('navbar', navbar);
Alpine.data('imagePreview', imagePreview);

Alpine.start();
