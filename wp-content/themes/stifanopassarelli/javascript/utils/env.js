export const prefersReduced = window.matchMedia(
	'(prefers-reduced-motion: reduce)'
).matches;

export const isTouch = window.matchMedia('(hover: none)').matches;
