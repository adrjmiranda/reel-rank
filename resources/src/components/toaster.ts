import Alpine from 'alpinejs';

export function toast(
	message: string,
	type: 'success' | 'error' | 'warning' = 'success'
) {
	Alpine.store('toast').show(message, type);
}
