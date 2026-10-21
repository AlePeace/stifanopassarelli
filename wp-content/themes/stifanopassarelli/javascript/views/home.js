import {
	initHero,
	initReveals,
	initSlats,
	initVeil,
	initPanels,
	initIndexHover,
	initNegative,
	initMarquee,
} from '../utils/animations.js';
import { initCarousels } from '../utils/slider.js';

let cleanups = [];

export default {
	namespace: 'home',
	afterEnter({ next }) {
		const scope = next.container;
		// Stesso ordine del boot della bozza.
		cleanups = [
			initHero(scope),
			initReveals(scope),
			initSlats(scope),
			initVeil(scope),
			initPanels(scope),
			initIndexHover(scope),
			initNegative(scope),
			initMarquee(scope),
			initCarousels(scope),
		];
	},
	beforeLeave() {
		cleanups.reverse().forEach((cleanup) => cleanup());
		cleanups = [];
	},
};
