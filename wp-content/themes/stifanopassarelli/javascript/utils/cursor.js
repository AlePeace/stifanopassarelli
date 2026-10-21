import { gsap } from 'gsap';
import { isTouch } from './env.js';

const HOVER_SELECTOR = 'a, button, [data-cursor]';
const STATE_CLASSES = { link: 'cursor-link', view: 'cursor-view' };

let current = null;
let currentClass = null;

/**
 * Toglie lo stato hover attivo: Barba sostituisce il container sotto al
 * mouse, senza un `mouseover` che lo chiuda.
 */
export function resetCursor() {
	if (currentClass) {
		document.body.classList.remove(currentClass);
	}
	current = null;
	currentClass = null;
}

/**
 * Cursore custom (fuori dal container Barba, init una tantum). Gli stati
 * hover passano per delegation sul document, così valgono anche per i
 * container caricati da Barba:
 * - `data-cursor="link"` (default su a/button) → il logo cresce;
 * - `data-cursor="view"` + `data-cursor-label` → anello grande + etichetta.
 */
export function initCursor() {
	if (isTouch) {
		return;
	}
	const cursor = document.querySelector('.sp-cursor');
	if (!cursor) {
		return;
	}
	const body = document.body;
	const label = cursor.querySelector('.sp-cursor__label');
	const xTo = gsap.quickTo(cursor, 'x', { duration: 0.35, ease: 'power3' });
	const yTo = gsap.quickTo(cursor, 'y', { duration: 0.35, ease: 'power3' });

	window.addEventListener('mousemove', (e) => {
		xTo(e.clientX);
		yTo(e.clientY);
	});
	document.addEventListener('mouseleave', () =>
		body.classList.add('cursor-hidden')
	);
	document.addEventListener('mouseenter', () =>
		body.classList.remove('cursor-hidden')
	);

	document.addEventListener('mouseover', (e) => {
		const el = e.target.closest(HOVER_SELECTOR);
		if (el === current) {
			return;
		}
		resetCursor();
		if (!el) {
			return;
		}
		current = el;
		currentClass =
			STATE_CLASSES[el.getAttribute('data-cursor') || 'link'] ||
			STATE_CLASSES.link;
		body.classList.add(currentClass);
		const text = el.getAttribute('data-cursor-label');
		if (text && label) {
			label.textContent = text;
		}
	});
}
