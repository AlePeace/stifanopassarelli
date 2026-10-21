import Swiper from 'swiper';
import { Keyboard, Navigation } from 'swiper/modules';

/**
 * Carosello Antologia. Le frecce vivono fuori dal contenitore .swiper
 * (wrapper .sp-swiper); quella non utilizzabile prende .swiper-button-disabled
 * → nascosta da CSS mantenendo lo spazio.
 *
 * @param {Element} scope Container Barba.
 * @return {Function} Cleanup.
 */
export function initCarousels(scope) {
	const swipers = Array.from(scope.querySelectorAll('[data-swiper]')).map(
		(el) => {
			const wrap = el.closest('.sp-swiper') || el.parentElement;
			const nav = wrap ? wrap.querySelector('.sp-swiper-nav') : null;
			return new Swiper(el, {
				modules: [Navigation, Keyboard],
				slidesPerView: 1.15,
				spaceBetween: 24,
				grabCursor: true,
				speed: 700,
				breakpoints: {
					760: { slidesPerView: 2.2 },
					1200: { slidesPerView: 3.1 },
				},
				keyboard: { enabled: true },
				watchOverflow: true,
				navigation: nav
					? {
							prevEl: nav.querySelector('.sp-swiper-btn--prev'),
							nextEl: nav.querySelector('.sp-swiper-btn--next'),
						}
					: false,
			});
		}
	);

	return () => swipers.forEach((swiper) => swiper.destroy(true, true));
}
