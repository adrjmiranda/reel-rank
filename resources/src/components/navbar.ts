export default function navbar() {
	return {
		active: false,
		toggle(): void {
			this.active = !this.active
		},
	}
}
