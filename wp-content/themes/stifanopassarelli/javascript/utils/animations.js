/**
 * Animazioni della homepage, portate da `main.js` della bozza mantenendo
 * selettori e comportamento. Ogni init riceve il container Barba e ritorna
 * una cleanup (gsap.context + listener fuori dal container).
 */
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { isTouch, prefersReduced } from './env.js';

gsap.registerPlugin(ScrollTrigger);

/* ---------------------------------------------- HERO: parallasse del media */
export function initHero(scope) {
	const ctx = gsap.context(() => {
		const media = scope.querySelector('.sp-hero__media');
		if (media && !prefersReduced) {
			gsap.to(media, {
				yPercent: 18,
				ease: 'none',
				scrollTrigger: {
					trigger: media.closest('.sp-hero'),
					start: 'top top',
					end: 'bottom top',
					scrub: true,
				},
			});
		}
	}, scope);

	return () => ctx.revert();
}

/* ---------------------------------------- reveal generico righe / parole */
export function initReveals(scope) {
	const ctx = gsap.context(() => {
		scope.querySelectorAll('[data-reveal-lines]').forEach((el) => {
			gsap.from(el.querySelectorAll('.line-inner'), {
				yPercent: 120,
				duration: 1,
				ease: 'power4.out',
				stagger: 0.08,
				scrollTrigger: { trigger: el, start: 'top 82%' },
			});
		});
		scope.querySelectorAll('[data-reveal-words]').forEach((el) => {
			const words = el.querySelectorAll('.sp-reveal-word > span');
			gsap.set(words, { yPercent: 110 });
			gsap.to(words, {
				yPercent: 0,
				duration: 0.9,
				ease: 'power4.out',
				stagger: 0.03,
				scrollTrigger: { trigger: el, start: 'top 78%' },
			});
		});
		// fade-up semplice
		scope.querySelectorAll('[data-fade]').forEach((el) => {
			gsap.fromTo(
				el,
				{ opacity: 0, y: 40 },
				{
					opacity: 1,
					y: 0,
					duration: 1,
					ease: 'power3.out',
					scrollTrigger: { trigger: el, start: 'top 88%' },
				}
			);
		});
	}, scope);

	return () => ctx.revert();
}

/* ------------------------------ SLAT REVEAL (immagine in listoni, ref eleos)
   Uso: <div class="sp-slats" data-slats="8"><img class="sp-slats__img">
   <div class="sp-slats__overlay"></div></div> */
export function initSlats(scope) {
	const ctx = gsap.context(() => {
		scope.querySelectorAll('.sp-slats').forEach((box) => {
			const overlay = box.querySelector('.sp-slats__overlay');
			const n = parseInt(box.dataset.slats || '8', 10);
			overlay.innerHTML = '';
			for (let i = 0; i < n; i++) {
				const s = document.createElement('div');
				s.className = 'sp-slats__slat';
				overlay.appendChild(s);
			}
			gsap.to(overlay.querySelectorAll('.sp-slats__slat'), {
				yPercent: (i) => (i % 2 === 0 ? -101 : 101),
				duration: 1.1,
				ease: 'power4.inOut',
				stagger: { each: 0.06, from: 'start' },
				scrollTrigger: { trigger: box, start: 'top 78%' },
			});
			// leggero zoom-out dell'immagine
			const img = box.querySelector('.sp-slats__img');
			if (img && !prefersReduced) {
				gsap.fromTo(
					img,
					{ scale: 1.18 },
					{
						scale: 1,
						duration: 1.6,
						ease: 'power3.out',
						scrollTrigger: { trigger: box, start: 'top 78%' },
					}
				);
			}
		});
	}, scope);

	return () => ctx.revert();
}

/* --------------------- SEPTIEMBRE: sticky, logo centrale + binari infiniti
   1) i binari scorrono in loop dentro lo sticky (overflow hidden): le foto
      vengono clonate finché coprono lo stage, poi la posizione viene
      "wrappata" → non si svuotano mai;
   2) a fine timeline ALCUNE foto dei binari restano e si spostano nelle
      posizioni del collage (alternate destra/sinistra, sfalsate), tutte le
      altre vanno a opacità 0. Le posizioni evitano il logo centrale. */

// slot del collage: centro (frazioni dello stage) + scala della foto.
// L/R alternati e y sfalsate; nessuno slot cade sopra il monogramma.
const VEIL_SLOTS = [
	{ cx: 0.1, cy: 0.22, s: 1.15 },
	{ cx: 0.88, cy: 0.18, s: 1.0 },
	{ cx: 0.27, cy: 0.56, s: 0.85 },
	{ cx: 0.73, cy: 0.46, s: 1.1 },
	{ cx: 0.13, cy: 0.81, s: 1.0 },
	{ cx: 0.9, cy: 0.75, s: 0.9 },
	{ cx: 0.35, cy: 0.16, s: 0.75 },
	{ cx: 0.64, cy: 0.86, s: 0.8 },
];
// mobile: una foto da 40vw non entra a fianco del logo → gli slot stanno
// tutti sopra/sotto la fascia centrale, mai dietro al monogramma
const VEIL_SLOTS_MOBILE = [
	{ cx: 0.26, cy: 0.13, s: 1.0 },
	{ cx: 0.74, cy: 0.21, s: 0.85 },
	{ cx: 0.24, cy: 0.8, s: 0.9 },
	{ cx: 0.76, cy: 0.88, s: 0.82 },
];

export function initVeil(scope) {
	const veil = scope.querySelector('.sp-veil');
	if (!veil || prefersReduced) {
		return () => {};
	}
	const stage = veil.querySelector('.sp-veil__sticky');
	const cols = Array.from(veil.querySelectorAll('.sp-veil__col'));
	const logo = veil.querySelector('.sp-veil__logo');

	const ctx = gsap.context(() => {
		// --- 1. rende ogni binario un loop continuo -------------------------
		const stageH = stage.offsetHeight;
		const rails = cols
			.map((col) => {
				const originals = Array.from(col.children);
				if (!originals.length) {
					return null;
				}
				let guard = 0;
				while (col.scrollHeight < stageH * 1.2 && guard++ < 12) {
					originals.forEach((n) =>
						col.appendChild(n.cloneNode(true))
					);
				}
				const gap = () => parseFloat(getComputedStyle(col).rowGap) || 0;
				const rail = { col, gap, unit: col.scrollHeight + gap() }; // altezza di un ciclo
				Array.from(col.children).forEach((n) =>
					col.appendChild(n.cloneNode(true))
				); // 2ª copia
				// dopo il clone: scrollHeight = 2·unit − gap → ricalcolabile al resize
				rail.measure = () => {
					rail.unit = (col.scrollHeight + rail.gap()) / 2;
				};
				return rail;
			})
			.filter(Boolean);

		// --- 2. timeline unica, agganciata allo scroll della sezione --------
		const tl = gsap.timeline({
			scrollTrigger: {
				trigger: veil,
				start: 'top top',
				end: 'bottom bottom',
				scrub: 0.6,
				onRefresh: () => rails.forEach((r) => r.measure()),
			},
		});

		const RAIL_END = 0.62; // fine scorrimento binari
		rails.forEach((rail) => {
			const col = rail.col;
			const speed = parseFloat(col.dataset.speed || '1');
			const dir = parseFloat(col.dataset.dir || '-1'); // -1 sale, +1 scende
			const startY = dir < 0 ? 0 : -rail.unit;
			gsap.set(col, { y: startY });
			// posizione a cui il binario si ferma: serve per calcolare il collage
			rail.yEnd = gsap.utils.wrap(
				-rail.unit,
				0,
				startY + dir * rail.unit * 1.7 * speed
			);
			tl.to(
				col,
				{
					y: `+=${dir * rail.unit * 1.7 * speed}`,
					ease: 'none',
					duration: RAIL_END,
					modifiers: {
						y: (v) =>
							gsap.utils.wrap(-rail.unit, 0, parseFloat(v)) +
							'px',
					},
				},
				0
			);
		});

		// --- 3. il collage: alcune foto dei binari restano e si compongono,
		//        tutte le altre spariscono (opacity 0) ------------------------
		const stageW = stage.offsetWidth;
		const slots = (
			window.matchMedia('(max-width: 760px)').matches
				? VEIL_SLOTS_MOBILE
				: VEIL_SLOTS
		).map((sl) => Object.assign({}, sl));

		// zona proibita = il monogramma centrale (+ margine): nessuna foto ci va sopra
		const pad = Math.max(24, stageW * 0.02);
		const noGo = logo
			? {
					l: logo.offsetLeft - pad,
					r: logo.offsetLeft + logo.offsetWidth + pad,
					t: logo.offsetTop - pad,
					b: logo.offsetTop + logo.offsetHeight + pad,
				}
			: null;

		// candidate = tutte le foto visibili sui binari, con la posizione che
		// avranno a binari fermi (offset nella colonna + yEnd della colonna)
		const candidates = [];
		rails.forEach((rail) => {
			if (!rail.col.offsetParent) {
				return; // colonna nascosta (mobile)
			}
			Array.from(rail.col.children).forEach((img) => {
				const src = img.getAttribute('src') || '';
				candidates.push({
					el: img,
					w: img.offsetWidth,
					h: img.offsetHeight,
					cx:
						rail.col.offsetLeft +
						img.offsetLeft +
						img.offsetWidth / 2,
					cy: img.offsetTop + rail.yEnd + img.offsetHeight / 2,
					src,
					// set di scatti: data-set dal template (cartella della foto di
					// default), altrimenti la cartella del file come nella bozza
					set: img.dataset.set || src.split('/').slice(-2, -1)[0],
				});
			});
		});

		const keepers = [];
		const usedSrc = new Set();
		const usedSets = new Set();
		slots.forEach((slot) => {
			let tx = slot.cx * stageW,
				ty = slot.cy * stageH;
			const ref = candidates[0];
			if (!ref) {
				return;
			}
			const w = ref.w * slot.s,
				h = ref.h * slot.s;
			// se lo slot invade il logo lo si spinge fuori (prima in orizzontale,
			// altrimenti sopra/sotto): su mobile è lì che le foto finivano dietro
			if (
				noGo &&
				tx - w / 2 < noGo.r &&
				tx + w / 2 > noGo.l &&
				ty - h / 2 < noGo.b &&
				ty + h / 2 > noGo.t
			) {
				const push = tx < stageW / 2 ? noGo.l - w / 2 : noGo.r + w / 2;
				// di lato solo se la foto ci sta davvero (schermi stretti: quasi mai),
				// altrimenti la si porta sopra o sotto il logo
				if (
					push - w / 2 > -w * 0.12 &&
					push + w / 2 < stageW + w * 0.12
				) {
					tx = push;
				} else {
					ty = ty < stageH / 2 ? noGo.t - h / 2 : noGo.b + h / 2;
				}
			}
			// foto più vicina allo slot fra quelle libere (movimento breve e naturale),
			// con una penalità se dallo stesso set di scatti → collage più vario
			let best = null,
				bestD = Infinity;
			candidates.forEach((c) => {
				if (c.taken || usedSrc.has(c.src)) {
					return;
				}
				const d =
					Math.hypot(c.cx - tx, c.cy - ty) *
					(usedSets.has(c.set) ? 1.7 : 1);
				if (d < bestD) {
					bestD = d;
					best = c;
				}
			});
			if (!best) {
				return;
			}
			best.taken = true;
			usedSrc.add(best.src);
			usedSets.add(best.set);
			keepers.push({
				el: best.el,
				dx: tx - best.cx,
				dy: ty - best.cy,
				s: slot.s,
			});
		});

		const others = candidates.filter((c) => !c.taken).map((c) => c.el);

		tl.to(
			others,
			{
				opacity: 0,
				ease: 'power2.inOut',
				duration: 0.26,
				stagger: { each: 0.008, from: 'random' },
			},
			RAIL_END
		);

		keepers.forEach((k, i) => {
			gsap.set(k.el, { zIndex: 2, position: 'relative' });
			tl.to(
				k.el,
				{
					x: k.dx,
					y: k.dy,
					scale: k.s,
					ease: 'power2.inOut',
					duration: 0.38,
				},
				RAIL_END + i * 0.03
			);
		});

		// il logo respira e resta il centro della composizione
		if (logo) {
			tl.fromTo(
				logo,
				{ scale: 0.86, opacity: 0.25 },
				{ scale: 1, opacity: 1, ease: 'none', duration: 0.5 },
				0
			);
		}
		tl.to({}, { duration: 0.2 }); // respiro finale prima di uscire dalla sezione
	}, scope);

	return () => ctx.revert();
}

/* ------------------------ ORDINARIUM: pannelli espandibili (ref normalis) */
export function initPanels(scope) {
	const wrap = scope.querySelector('.sp-panels');
	const panels = wrap ? wrap.querySelectorAll('.sp-panel') : [];
	if (!panels.length) {
		return () => {};
	}
	let refreshTimer = null;

	const ctx = gsap.context(() => {
		panels.forEach((p) => {
			// hover desktop
			if (!isTouch) {
				p.addEventListener('mouseenter', () => {
					panels.forEach((x) => x.classList.remove('is-open'));
					p.classList.add('is-open');
				});
			}
			// click / touch: accordion (ri-clic sul pannello aperto lo richiude)
			p.addEventListener('click', () => {
				const wasOpen = p.classList.contains('is-open');
				panels.forEach((x) => x.classList.remove('is-open'));
				if (!wasOpen) {
					p.classList.add('is-open');
				}
				// su mobile l'altezza della pagina cambia → ricalcolo a transizione finita
				clearTimeout(refreshTimer);
				refreshTimer = setTimeout(() => ScrollTrigger.refresh(), 700);
			});
		});
		// apertura progressiva legata allo scroll (parte chiuso → si apre il 1°)
		panels[0].classList.add('is-open');
		if (!prefersReduced) {
			ScrollTrigger.create({
				trigger: wrap,
				start: 'top 60%',
				onEnter: () => {
					panels.forEach((x) => x.classList.remove('is-open'));
					panels[0].classList.add('is-open');
				},
			});
		}
	}, scope);

	return () => {
		clearTimeout(refreshTimer);
		ctx.revert();
	};
}

/* -------------------- LISTA OPERE hover→immagine al cursore (septiembre) */
export function initIndexHover(scope) {
	if (isTouch) {
		return () => {};
	}
	const listeners = [];

	const ctx = gsap.context(() => {
		scope.querySelectorAll('.sp-index').forEach((idx) => {
			const items = idx.querySelectorAll('.sp-index__item');
			const medias = idx.querySelectorAll('.sp-index__media');
			if (!medias.length) {
				return;
			}
			// ogni immagine è centrata sul cursore (xPercent/yPercent) e lo segue con smoothing
			gsap.set(medias, { xPercent: -50, yPercent: -50 });
			const xTo = gsap.quickTo(medias, 'x', {
				duration: 0.55,
				ease: 'power3',
			});
			const yTo = gsap.quickTo(medias, 'y', {
				duration: 0.55,
				ease: 'power3',
			});
			const onMove = (e) => {
				xTo(e.clientX);
				yTo(e.clientY);
			};
			window.addEventListener('mousemove', onMove);
			listeners.push(onMove);
			let active = null;
			items.forEach((it, i) => {
				it.addEventListener('mouseenter', () => {
					idx.classList.add('is-hovering');
					medias.forEach((m) => m.classList.remove('is-active'));
					active = medias[i];
					if (active) {
						active.classList.add('is-active');
					}
				});
				it.addEventListener('mouseleave', () => {
					idx.classList.remove('is-hovering');
					if (active) {
						active.classList.remove('is-active');
					}
					active = null;
				});
			});
		});
	}, scope);

	return () => {
		listeners.forEach((fn) => window.removeEventListener('mousemove', fn));
		ctx.revert();
	};
}

/* ------------------------------- NEGATIVO: lente invertita al cursore
   Desktop: la lente segue il mouse. Touch: la lente si sposta al tap/drag
   (con easing) e dentro c'è l'etichetta "Click" (vedi .sp-negative__hint). */
export function initNegative(scope) {
	const ctx = gsap.context(() => {
		scope.querySelectorAll('.sp-negative').forEach((sec) => {
			const pos = { x: 50, y: 50 };
			const apply = () => {
				sec.style.setProperty('--mx', pos.x + '%');
				sec.style.setProperty('--my', pos.y + '%');
			};
			const toPct = (cx, cy) => {
				const r = sec.getBoundingClientRect();
				return {
					x: ((cx - r.left) / r.width) * 100,
					y: ((cy - r.top) / r.height) * 100,
				};
			};
			apply();

			if (isTouch) {
				const move = (e) => {
					const t = e.touches && e.touches[0] ? e.touches[0] : e;
					if (t.clientX == null) {
						return;
					}
					const p = toPct(t.clientX, t.clientY);
					gsap.to(pos, {
						x: p.x,
						y: p.y,
						duration: 0.5,
						ease: 'power3.out',
						onUpdate: apply,
					});
				};
				sec.addEventListener('touchstart', move, { passive: true });
				sec.addEventListener('touchmove', move, { passive: true });
				sec.addEventListener('click', move);
			} else {
				sec.addEventListener('mousemove', (e) => {
					const p = toPct(e.clientX, e.clientY);
					pos.x = p.x;
					pos.y = p.y;
					apply();
				});
			}
		});
	}, scope);

	return () => ctx.revert();
}

/* --------------------------------------------------- MARQUEE discover */
export function initMarquee(scope) {
	const clones = [];

	const ctx = gsap.context(() => {
		scope.querySelectorAll('.sp-marquee__track').forEach((tr) => {
			const clone = tr.cloneNode(true);
			tr.parentNode.appendChild(clone);
			clones.push(clone);
			gsap.to([tr, clone], {
				xPercent: -100,
				repeat: -1,
				duration: 24,
				ease: 'none',
			});
		});
	}, scope);

	return () => {
		ctx.revert();
		clones.forEach((clone) => clone.remove());
	};
}

/* --------------------------- FAQ (Accademia): <details> che cambiano altezza */
export function initDetails(scope) {
	const items = scope.querySelectorAll('details');
	let refreshTimer = null;
	const onToggle = () => {
		clearTimeout(refreshTimer);
		refreshTimer = setTimeout(() => ScrollTrigger.refresh(), 100);
	};
	items.forEach((item) => item.addEventListener('toggle', onToggle));

	return () => {
		clearTimeout(refreshTimer);
		items.forEach((item) => item.removeEventListener('toggle', onToggle));
	};
}
