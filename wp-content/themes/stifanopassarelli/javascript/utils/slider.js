import Swiper from 'swiper';
import { Keyboard, Navigation } from 'swiper/modules';
import { prefersReduced } from './env.js';

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

/**
 * Righe a scorrimento nativo (Mosaico su mobile) con le frecce dell'Antologia:
 * ogni click scorre di un'opera (lo scroll-snap la allinea); la freccia non
 * utilizzabile prende .swiper-button-disabled come con Swiper.
 *
 * @param {Element} scope Container Barba.
 * @return {Function} Cleanup.
 */
export function initScrollers(scope) {
	const cleanups = Array.from(scope.querySelectorAll('[data-scroller]')).map(
		(el) => {
			const nav = el.parentElement.querySelector('.sp-swiper-nav');
			if (!nav) {
				return () => {};
			}
			const prev = nav.querySelector('.sp-swiper-btn--prev');
			const next = nav.querySelector('.sp-swiper-btn--next');
			const step = () => {
				const items = el.children;
				return items.length > 1
					? items[1].offsetLeft - items[0].offsetLeft
					: el.clientWidth;
			};
			const go = (dir) =>
				el.scrollBy({
					left: dir * step(),
					behavior: prefersReduced ? 'auto' : 'smooth',
				});
			const onPrev = () => go(-1);
			const onNext = () => go(1);
			const update = () => {
				const max = el.scrollWidth - el.clientWidth;
				prev.classList.toggle(
					'swiper-button-disabled',
					el.scrollLeft <= 1
				);
				next.classList.toggle(
					'swiper-button-disabled',
					el.scrollLeft >= max - 1
				);
			};

			prev.addEventListener('click', onPrev);
			next.addEventListener('click', onNext);
			el.addEventListener('scroll', update, { passive: true });
			window.addEventListener('resize', update);
			update();

			return () => {
				prev.removeEventListener('click', onPrev);
				next.removeEventListener('click', onNext);
				el.removeEventListener('scroll', update);
				window.removeEventListener('resize', update);
			};
		}
	);

	return () => cleanups.forEach((cleanup) => cleanup());
}
