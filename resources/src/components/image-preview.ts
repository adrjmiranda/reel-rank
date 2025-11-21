export default function imagePreview() {
	return {
		previewUrl: '',

		updatePreview(event: Event) {
			const input = event.target as HTMLInputElement;
			const file = input.files?.[0] ?? null;

			if (file) {
				const reader = new FileReader();
				reader.onload = () => {
					this.previewUrl = reader.result as string;
				};
				reader.readAsDataURL(file);
			} else {
				this.previewUrl = '';
			}
		},
	};
}
