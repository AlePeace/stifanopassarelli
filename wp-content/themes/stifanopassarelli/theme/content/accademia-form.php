<?php
/**
 * Modulo Contact Form 7 dell'Accademia ("Richiedi il programma dei corsi"),
 * creato da Opere > Importa contenuti. Il markup usa le classi del tema
 * (`sp-field`, `sp-choices`, `sp-btn`): lo stile è in academy.css.
 *
 * @package stifanopassarelli
 */

return array(
	'title'    => 'Accademia — Richiesta informazioni',
	'form'     => <<<'FORM'
<div class="sp-field"><label for="acc-nome">Nome e Cognome *</label>[text* nome id:acc-nome autocomplete:name]</div>
<div class="sp-field"><label for="acc-email">Email *</label>[email* email id:acc-email autocomplete:email]</div>
<div class="sp-field"><label for="acc-telefono">Telefono *</label>[tel* telefono id:acc-telefono autocomplete:tel]</div>
<div class="sp-field"><label for="acc-citta">Città / Provincia di provenienza *</label>[text* citta id:acc-citta autocomplete:address-level2]</div>
<fieldset class="sp-choices"><legend>Corso di interesse *</legend>[checkbox* corso use_label_element "Argilla e Ceramica" "Mosaico Contemporaneo" "Percorso Completo (Argilla + Mosaico)" "Workshop intensivi del Weekend"]</fieldset>
<div class="sp-field"><label for="acc-messaggio">Messaggio o domande particolari (opzionale)</label>[textarea messaggio id:acc-messaggio x3]</div>
<div class="sp-choices sp-choices--privacy">[acceptance privacy] Acconsento al trattamento dei miei dati personali per ricevere informazioni sui corsi. [/acceptance]</div>
[submit class:sp-btn "Richiedi informazioni →"]
FORM,
	'subject'  => 'Accademia — richiesta info da [nome]',
	'body'     => <<<'BODY'
Nuova richiesta di informazioni sui corsi dell'Accademia.

Nome e Cognome: [nome]
Email: [email]
Telefono: [telefono]
Città / Provincia: [citta]
Corso di interesse: [corso]

Messaggio:
[messaggio]

--
Inviato dal form Accademia di [_site_title] ([_site_url])
BODY,
	'messages' => array(
		'mail_sent_ok'      => 'Grazie! Ti invieremo al più presto il programma dei corsi.',
		'mail_sent_ng'      => "Si è verificato un errore durante l'invio. Riprova più tardi.",
		'validation_error'  => 'Uno o più campi contengono errori: controlla e riprova.',
		'spam'              => "Si è verificato un errore durante l'invio. Riprova più tardi.",
		'accept_terms'      => 'Per inviare la richiesta è necessario accettare il trattamento dei dati.',
		'invalid_required'  => 'Questo campo è obbligatorio.',
		'invalid_too_long'  => 'Il testo è troppo lungo.',
		'invalid_too_short' => 'Il testo è troppo corto.',
		'upload_failed'     => 'Errore nel caricamento del file.',
		'invalid_email'     => 'Inserisci un indirizzo email valido.',
		'invalid_tel'       => 'Inserisci un numero di telefono valido.',
	),
);
