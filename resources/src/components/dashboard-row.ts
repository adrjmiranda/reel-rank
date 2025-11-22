import axios from 'axios';
import Alpine from 'alpinejs';
import { toast } from './toaster';

export default function dashboardRow() {
	return {
		async remove(id: number, root: HTMLElement) {
			try {
				Alpine.store('loading').show();

				const response = await axios.delete(`/filme/remove/${id}`);

				if (response.data.status) {
					root.remove();
					toast(response.data.message);
				} else {
					toast(response.data.message, 'error');
				}
			} catch (error) {
				toast('Falha ao tentar remover filme!', 'error');
			} finally {
				Alpine.store('loading').hide();
			}
		},
	};
}
