/**
 * Contact Form 7 dentro il container Barba. Al primo caricamento i form li
 * inizializza CF7 (DOMContentLoaded); dopo una navigazione Barba il nuovo
 * container non è inizializzato, quindi lo si fa qui. Senza init il form
 * funziona lo stesso, ma con submit classico e ricarica della pagina.
 */
export function initForms(scope) {
	const wpcf7 = window.wpcf7;
	if (typeof wpcf7?.init !== 'function') {
		return;
	}
	scope.querySelectorAll('.wpcf7 > form').forEach((form) => {
		// CF7 salva il suo stato in form.wpcf7: già inizializzato.
		if (!form.wpcf7) {
			wpcf7.init(form);
			form.closest('.wpcf7')?.classList.replace('no-js', 'js');
		}
	});
}
