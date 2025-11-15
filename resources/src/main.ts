import Alpine from 'alpinejs'
import './index.css'
import navbar from './components/navbar'

declare global {
	interface Window {
		Alpine: typeof Alpine
	}
}

window.Alpine = Alpine

Alpine.data('navbar', navbar)

Alpine.start()
