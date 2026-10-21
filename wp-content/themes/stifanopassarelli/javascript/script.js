/**
 * Front-end JavaScript
 *
 * Compilato da esbuild in `../theme/js/script.min.js`.
 */

import barba from '@barba/core';
import barbaPrefetch from '@barba/prefetch';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { initSmoothScroll, getLenis } from './utils/scroll.js';
import { initCursor, resetCursor } from './utils/cursor.js';
import { initHeader, HEADER_TRIGGER_ID } from './utils/header.js';
import { initFooterReveal, FOOTER_TRIGGER_ID } from './utils/footer.js';
import { initPreloader } from './utils/preloader.js';
import fade from './transitions/fade.js';
import home from './views/home.js';

const PERSISTENT_TRIGGERS = [HEADER_TRIGGER_ID, FOOTER_TRIGGER_ID];

// iOS: riaprendo il browser dal multitasking la pagina torna dalla bfcache o ricarica già scrollata, e i trigger vengono misurati male.
ScrollTrigger.clearScrollMemory('manual');

window.addEventListener('pageshow', (event) => {
	if (event.persisted) {
		window.location.reload();
	}
});

document.addEventListener('visibilitychange', () => {
	if (document.visibilityState === 'visible') {
		requestAnimationFrame(() => {
			getLenis()?.resize();
			ScrollTrigger.refresh();
		});
	}
});

document.addEventListener('DOMContentLoaded', () => {
	// Elementi fuori dal container Barba: inizializzati una sola volta.
	initSmoothScroll();
	initCursor();
	initHeader();
	initFooterReveal();

	barba.use(barbaPrefetch);

	barba.hooks.beforeLeave(() => {
		resetCursor();
	});

	// Dopo le cleanup delle view, con il vecchio container già uscito.
	barba.hooks.afterLeave(() => {
		ScrollTrigger.getAll()
			.filter((st) => !PERSISTENT_TRIGGERS.includes(st.vars.id))
			.forEach((st) => st.kill());
		const lenis = getLenis();
		if (lenis) {
			lenis.scrollTo(0, { immediate: true, force: true });
		} else {
			window.scrollTo(0, 0);
		}
	});

	barba.hooks.beforeEnter(({ next }) => {
		const match = next.html.match(/<body[^>]*\sclass="([^"]*)"/);
		if (match) {
			document.body.setAttribute('class', match[1]);
		}
	});

	barba.hooks.after(() => {
		ScrollTrigger.refresh();
	});

	barba.init({
		preventRunning: true,
		prevent: ({ el }) => /\/wp-(admin|login)/.test(el.href),
		transitions: [fade],
		views: [home],
	});

	// Il preloader parte dopo le view (come nella bozza): a tenda aperta si
	// rimisurano i trigger.
	initPreloader(() => ScrollTrigger.refresh());
});

// refresh dopo il caricamento di immagini/video
window.addEventListener('load', () => ScrollTrigger.refresh());
