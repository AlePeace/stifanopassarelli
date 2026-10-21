import { gsap } from 'gsap';

const tween = (target, vars) =>
	new Promise((resolve) => gsap.to(target, { ...vars, onComplete: resolve }));

export default {
	name: 'fade',
	leave({ current }) {
		return tween(current.container, {
			autoAlpha: 0,
			duration: 0.4,
			ease: 'power2.out',
		});
	},
	enter({ next }) {
		gsap.set(next.container, { autoAlpha: 0 });
		return tween(next.container, {
			autoAlpha: 1,
			duration: 0.4,
			ease: 'power2.out',
			clearProps: 'opacity,visibility',
		});
	},
};
