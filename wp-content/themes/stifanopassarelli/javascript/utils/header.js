import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

export const HEADER_TRIGGER_ID = 'header-hide';

/**
 * Header: si nasconde scrollando verso il basso, ricompare risalendo.
 * Fuori dal container Barba: trigger persistente.
 */
export function initHeader() {
	const header = document.querySelector('.sp-header');
	if (!header) {
		return;
	}
	let last = 0;
	ScrollTrigger.create({
		id: HEADER_TRIGGER_ID,
		start: 0,
		end: 'max',
		onUpdate: (self) => {
			const y = self.scroll();
			if (y > 200 && y > last) {
				gsap.to(header, { yPercent: -130, duration: 0.4 });
			} else {
				gsap.to(header, { yPercent: 0, duration: 0.4 });
			}
			last = y;
		},
	});
}
