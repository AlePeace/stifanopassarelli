import { gsap } from 'gsap';

export const FOOTER_TRIGGER_ID = 'footer-reveal';

/**
 * Footer ("Umana è l'opera."): reveal per righe. Fuori dal container Barba:
 * trigger persistente.
 */
export function initFooterReveal() {
	const el = document.querySelector('.sp-footer [data-reveal-lines]');
	if (!el) {
		return;
	}
	gsap.from(el.querySelectorAll('.line-inner'), {
		yPercent: 120,
		duration: 1,
		ease: 'power4.out',
		stagger: 0.08,
		scrollTrigger: { id: FOOTER_TRIGGER_ID, trigger: el, start: 'top 82%' },
	});
}
