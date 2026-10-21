import { gsap } from 'gsap';
import { prefersReduced } from './env.js';

/**
 * Preloader identità (solo al primo caricamento, è fuori dal container
 * Barba): la O (Emanuele) entra da sinistra, le 3 tessere della e (Carla)
 * arrivano da destra una a una e compongono il monogramma, poi la tenda si
 * apre. Contatore 000→100. Saltato con prefers-reduced-motion.
 *
 * @param {Function} done Chiamata a preloader finito (o saltato).
 */
export function initPreloader(done) {
	const pre = document.querySelector('.sp-preloader');
	if (!pre || prefersReduced) {
		if (pre) {
			pre.style.display = 'none';
		}
		done?.();
		return;
	}

	const oEl = pre.querySelector('.m-o'); // Emanuele → la O
	const eEl = pre.querySelector('.m-e'); // Carla → la e
	const eStrokes = pre.querySelectorAll('.m-e path'); // le 3 tessere
	const merge = pre.querySelector('.mono-merge');
	const count = pre.querySelector('.sp-preloader__count');

	const tl = gsap.timeline({
		defaults: { ease: 'power3.inOut' },
		onComplete: () => {
			pre.style.display = 'none'; // rimuove del tutto il layer (niente ghost di compositing)
			done?.();
		},
	});

	// contatore 000→100
	const c = { v: 0 };
	tl.to(
		c,
		{
			v: 100,
			duration: 1.8,
			ease: 'power1.inOut',
			onUpdate: () => {
				if (count) {
					count.textContent = String(Math.round(c.v)).padStart(
						3,
						'0'
					);
				}
			},
		},
		0
	);

	// la O (Emanuele) entra da sinistra
	tl.fromTo(
		oEl,
		{ xPercent: -170, opacity: 0, rotate: -10 },
		{ xPercent: 0, opacity: 1, rotate: 0, duration: 1.2 },
		0.2
	);
	// le 3 tessere della e (Carla) arrivano da destra una a una e si uniscono alla O (come nel video)
	gsap.set(eEl, { opacity: 1 });
	tl.fromTo(
		eStrokes,
		{ x: 270, opacity: 0 },
		{ x: 0, opacity: 1, duration: 0.9, ease: 'power3.out', stagger: 0.16 },
		0.95
	);
	// piccolo "assestamento" del monogramma unito
	tl.fromTo(
		merge,
		{ scale: 1.04 },
		{ scale: 1, duration: 0.5, ease: 'power2.out' },
		2.0
	);
	// breve respiro e la tenda si apre (senza wordmark esteso)
	tl.to(pre, { yPercent: -100, duration: 0.9, ease: 'power4.inOut' }, 2.7);
}
