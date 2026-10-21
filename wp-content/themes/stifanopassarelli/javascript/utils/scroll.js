import Lenis from 'lenis';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { prefersReduced } from './env.js';

gsap.registerPlugin(ScrollTrigger);

let lenis = null;

// Opzioni della bozza; le ancore #… le gestisce Lenis (`anchors`).
// Con prefers-reduced-motion niente smooth scroll.
export function initSmoothScroll() {
	if (prefersReduced) {
		return null;
	}

	lenis = new Lenis({
		autoRaf: false,
		anchors: true,
		duration: 1.1,
		easing: (t) => 1 - Math.pow(1 - t, 3),
		smoothWheel: true,
	});

	lenis.on('scroll', ScrollTrigger.update);

	gsap.ticker.add((time) => {
		lenis.raf(time * 1000);
	});
	gsap.ticker.lagSmoothing(0);

	return lenis;
}

export function getLenis() {
	return lenis;
}
