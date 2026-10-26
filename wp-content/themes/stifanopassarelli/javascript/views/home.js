import {
	initHero,
	initReveals,
	initSlats,
	initVeil,
	initPanels,
	initNegative,
	initMarquee,
	initDetails,
} from '../utils/animations.js';
import { initCarousels, initScrollers } from '../utils/slider.js';
import { initForms } from '../utils/forms.js';

let cleanups = [];

export default {
	namespace: 'home',
	afterEnter({ next, trigger }) {
		const scope = next.container;
		// Al primo caricamento (trigger 'barba') i form li inizializza CF7.
		if (trigger !== 'barba') {
			initForms(scope);
		}
		// Stesso ordine del boot della bozza.
		cleanups = [
			initHero(scope),
			initReveals(scope),
			initSlats(scope),
			initVeil(scope),
			initPanels(scope),
			initNegative(scope),
			initMarquee(scope),
			initCarousels(scope),
			initScrollers(scope),
			initDetails(scope),
		];
	},
	beforeLeave() {
		cleanups.reverse().forEach((cleanup) => cleanup());
		cleanups = [];
	},
};
