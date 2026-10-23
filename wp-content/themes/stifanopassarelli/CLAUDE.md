# CLAUDE.md — Stifano Passarelli (tema WordPress)

Tema classico che porta in WordPress la **bozza statica** della homepage
(`/home/aledev/Documents/Backup_siti_laptop/Local Sites/draft_stifano_passarelli/`):
one-page per il duo Emanuele Stifano (scultura) e Carla Passarelli (mosaico),
*"Non è l'oggetto a essere sacro, è il rito che lo abita."*

## ⚠️ Regola d'oro — la bozza vince

1. **Codice della bozza** (`index.html`, `assets/css/style.css`, `assets/js/main.js`): riferimento 1:1 per layout, classi, animazioni e copy.
   Eccezione: le modifiche chieste dal cliente a ottobre 2026 (Marmo al posto di Ordinarium, Mosaico, Accademia, opere nuove) esistono **solo nel tema**, la bozza non è stata aggiornata.
2. **`claude.md` della bozza**: decisioni, reference (eleos, septiembre, normalisboring), TODO contenuti.
3. **Boilerplate _tw/approdo** (struttura WP, Barba, ACF): vale solo dove la bozza non dice nulla.

Per verificare si confronta il sito WP con la bozza servita in statico
(`python3 -m http.server` nella cartella della bozza).

---

## Sito locale

- **Local**: sito `stifanopassarelli` (id `kS4_Ij_6h`), `http://stifanopassarelli.local`, root WP `/home/aledev/Local Sites/stifanopassarelli/app/public/`. Il tema è in `wp-content/themes/stifanopassarelli/`; WordPress lo vede come `stifanopassarelli/theme`.
- **Plugin**: Advanced Custom Fields (free) e Contact Form 7. In locale CF7 è fermo alla **6.1.4** perché la 6.2 richiede PHP 8.3 e Local è su 8.2 (in produzione aggiornare). Modulo "Accademia — Richiesta informazioni" (id 7), destinatario `[_site_admin_email]`.
- **Impostazioni**: titolo "Stifano Passarelli", motto "Sintonizzazione Scultorea e Musiva", permalink `/%postname%/`, homepage statica = pagina "Home" (slug `home`).
- **WP-CLI** con il PHP di Local (il sito deve essere avviato), da lanciare in `app/public/`:
  ```sh
  LD_LIBRARY_PATH=~/.config/Local/lightning-services/php-8.2.29+0/bin/linux/shared-libs \
    ~/.config/Local/lightning-services/php-8.2.29+0/bin/linux/bin/php \
    -c ~/.config/Local/run/kS4_Ij_6h/conf/php/php.ini \
    /opt/Local/resources/extraResources/bin/wp-cli/wp-cli.phar <comando>
  ```
  ⚠️ Non esportare `LD_LIBRARY_PATH` nella shell: rompe `curl` di sistema.
- **Git**: la repo è la cartella del tema (questa). `.gitignore` di _tw: esclusi `node_modules`, `vendor` e i file compilati (`theme/style.css`, `theme/style-editor.css`, `*.min.js`, `tailwind-intellisense.css`) → dopo un clone serve `npm install && npm run dev`.

---

## Stack

- **WordPress** classico, block editor disattivato, admin bar nascosta sul front end. Generato a partire dalla base _tw di `approdo`.
- **CSS**: Tailwind v4 via PostCSS (_tw). Entry `tailwind.css` → `theme/style.css` (non editare).
- **JS**: esbuild. Entry `javascript/script.js` → `theme/js/script.min.js` (non editare).
- **Build**: `npm run watch` lo lancia l'utente. `npm run bundle` → `stifanopassarelli.zip`.
- **Dipendenze**: `gsap` (+ScrollTrigger), `lenis`, `swiper` (Navigation, Keyboard), `@barba/core`, `@barba/prefetch`.
- **Plugin**: ACF (free: niente repeater/gallery/options page → campi numerati e pagina "impostazioni-globali", come approdo).

### Struttura

```
stifanopassarelli/
  theme/
    functions.php                 ← setup, enqueue, stifanopassarelli_img()
    header.php / footer.php       ← cursore, preloader, header, footer FUORI dal container Barba
    page-home.php                 ← <main data-barba="container" data-barba-namespace="home"> + 12 sezioni
    inc/
      acf-helpers.php             ← stifanopassarelli_field/the_field/setting/the_setting (fallback = copy bozza)
      acf-fields.php              ← gruppi Homepage (12 tab) e Impostazioni globali + colonne Work in progress
      opere.php                   ← CPT `opera` + tassonomia `collezione`, lettura opere con fallback bozza
      accademia.php               ← copy di default dell'Accademia (condivisa ACF/template) + filtri CF7
      setup.php                   ← after_switch_theme: pagine Home + Impostazioni globali, collezioni, permalink
      importer.php                ← Opere > Importa contenuti (solo admin): bottoni "Crea opere" e "Crea modulo Accademia"
      template-functions.php      ← asset_url, home_anchor, nav_items, lines (+ helper _tw)
    template-parts/
      layout/                     ← cursor, preloader, header-content, footer-content
      components/monogram.php     ← SVG ufficiale (parts: all | o | e)
      sections/home/              ← hero, manifesto, work-in-progress, il-rito, negativo, marmo, mosaico, antologia, artisti, discover, accademia, contatti
    content/                      ← dati per l'importer: opere.php (15 opere + foto), accademia-form.php (modulo CF7)
    assets/{img,logo,video}/      ← file usati dalla bozza (stessi path) + img/opere/ (foto delle opere nuove, per l'importer)
    fonts/                        ← Playfair Display + Inter (variabili), Space Mono 400/700 — woff2 Fontsource, latin + latin-ext
  javascript/
    script.js                     ← init persistenti + hook Barba
    utils/                        ← env, scroll (Lenis), cursor, preloader, header, footer (persistenti) · animations, slider, forms (scoped + cleanup)
    views/home.js · transitions/fade.js
  tailwind/
    tailwind-theme.css            ← @theme: SOLO colori e font-family
    custom/base.css               ← :root --sp-* (→ token), body, h1-h4, cursore nativo nascosto
    custom/components/*.css       ← CSS della bozza copiato 1:1, un file per componente
    custom/utilities.css          ← .sp-only-desktop / .sp-only-touch
```

---

## CSS

- Le custom properties `--sp-*` della bozza restano (il CSS dei componenti le usa) ma in `base.css` puntano ai token Tailwind: `--sp-bone: var(--color-bone)` ecc. Utility disponibili: `bg-bone`, `text-ink`, `font-serif`/`font-mono`/`font-sans`…
- `components/*.css` = `style.css` della bozza diviso per intervalli di righe, **copiato 1:1** (anche le poche regole non usate, es. `.sp-hero__title`). Se si modifica un componente, va fatto lì. Fuori dalla bozza: `mosaic.css`, `academy.css` (fondo `--sp-paper`) e il `padding-right` del marquee (giuntura col clone).
- Gli stili inline della bozza sono diventati utility (`relative z-[2]`, `aspect-[4/5]`, `px-(--sp-gutter)`, `text-[length:clamp(…)]`…).
- ⚠️ **Precedenza**: in _tw i componenti vengono **prima** delle utility e il CSS base di Swiper **dopo**. `.swiper { padding: 0 }` batte le utility → sul carosello `px-(--sp-gutter)!`.
- ⚠️ **Font nella bozza**: il Tailwind Play CDN si caricava dopo `style.css` e sovrascriveva `.font-mono` / `.font-serif` con i font di default (monospace di sistema e Georgia). Nel tema le classi usano Space Mono e Playfair come previsto: didascalie e titoli dell'Antologia risultano diversi dalla bozza (il Manifesto è 19px più basso). È voluto.

## JavaScript / Barba

- Fuori dal container (init una tantum al `DOMContentLoaded`): Lenis, cursore (hover via delegation sul document), header, reveal del footer, preloader (solo al primo caricamento).
- Trigger persistenti: `header-hide`, `footer-reveal` (`PERSISTENT_TRIGGERS` in `script.js`); gli altri vengono uccisi in `afterLeave`.
- View `home`: `initHero`, `initReveals`, `initSlats`, `initVeil`, `initPanels`, `initIndexHover`, `initNegative`, `initMarquee`, `initCarousels`, `initDetails` (FAQ → `ScrollTrigger.refresh`). Ognuna è scoped al container e ritorna una cleanup (gsap.context + listener su window + cloni del marquee).
- CF7: al primo caricamento i form li inizializza il plugin; dopo una navigazione Barba li inizializza `initForms` (`utils/forms.js`).
- Lenis con le opzioni della bozza, `anchors: true`; con `prefers-reduced-motion` **niente Lenis** (come nella bozza), quindi `getLenis()` può essere `null`.
- Work in progress: resta `position: sticky` come nella bozza (niente pin GSAP). Per variare il collage `initVeil` usa `data-set` sulle foto (= cartella dello shooting della foto di default).
- Rimossi rispetto a `main.js`: il reveal del titolo hero (`.sp-hero__title` non c'è nell'HTML) e la classe `is-loading` sul body (nessuno stile la usava).

## Contenuti (ACF + CPT)

- **Homepage** (location `front_page`): un tab per sezione. Ogni campo vuoto mostra la copy/foto della bozza (fallback nei template = `default_value` del campo).
- **Work in progress**: 16 campi immagine `home_wip_col_{1-4}_foto_{1-4}`; colonne/velocità in `stifanopassarelli_wip_columns()`.
- **Opere** (CPT `opera`, archivio `/opere/`, tassonomia `collezione`: `marmo` (ex `ordinarium`), `mosaico`, `antologia`). Immagine = immagine in evidenza. Ordine = "Ordine" negli attributi; la data del post = anno dell'opera (serve all'etichetta dell'indice). Campi: `opera_sottotitolo`, `opera_descrizione`, `opera_tecnica`, `opera_anno_luogo` (Marmo, Mosaico), `opera_nota` (Antologia), `opera_in_indice`, `opera_indice_etichetta` (vuoto = "Collezione · anno").
  - Le 15 opere sono nel CPT (5 marmo, 4 mosaico, 6 antologia: le 4 della bozza con "Il Rito della Forma" → Anthea, la Spigolatrice e in coda Aedicula, ex Ordinarium). Sacellum, Fenesta e Centriello tolti su richiesta del cliente (nel cestino in locale).
  - Su un sito nuovo (es. stifanopassarelli.art/preview, installazione manuale senza migrare il DB): Opere > **Importa contenuti** crea collezioni, opere con foto (da `content/opere.php`) e il modulo CF7 dell'Accademia collegato alla Home. Salta ciò che esiste già. Se si cambia un'opera in locale va aggiornato anche `content/opere.php`.
  - Senza opere pubblicate: l'Antologia mostra quelle della bozza (`stifanopassarelli_opere_bozza()`, con Aedicula in coda); Marmo e Mosaico non compaiono.
  - L'indice = opere con "Mostra nell'indice": Marmo, Mosaico, Antologia; link all'ancora della sezione.
- **Accademia** (`#accademia`, fondo chiaro): copy in `stifanopassarelli_accademia()`, campi `home_accademia_*`; form = shortcode CF7 in `home_accademia_form`. Per non fare muro di testo riusa i pattern del sito: sottotitolo con reveal parola per parola, corsi nei pannelli espandibili del Marmo (`initPanels` gestisce tutti i `.sp-panels` della pagina), marquee dei punti chiave (`home_accademia_marquee`, uno per riga), destinatari a righe grandi tipo indice, info della sede in `<details>` come le FAQ. Le foto dei corsi di default sono `il_rito_della_forma.jpg` e `carla.jpg`.
- **Impostazioni globali** (pagina slug `impostazioni-globali`, redirect 301 alla home dal front end): social (Contatti) e footer.
- **Nav header**: menu nella posizione "Header" se assegnato, altrimenti le ancore della bozza (`#…` sulla home, `home_url('/#…')` altrove).
- **Contatti**: campo `home_contatti_form` = shortcode (es. CF7). Se è vuoto resta il form della bozza, che non invia nulla.

## TODO (dalla bozza + porting)

- [ ] Menu mobile: il bottone "Menu" della bozza non ha comportamento.
- [ ] Video hero definitivo, video split "Doppia Pelle", copy Ordinarium, bio, P.IVA (vedi `claude.md` della bozza, §8).
- [ ] Inserire le opere reali nel CPT (immagini in evidenza + collezione).
- [ ] Discover → CPT "esposizioni" in stile blog (ora textarea, un luogo per riga).
- [ ] Accademia: destinatario delle email del form (ora l'admin email), link alla privacy policy nel consenso, eventuale autorisposta (mail_2).
- [ ] Anthea: mancano anno/tecnica/nota.
- [ ] Single/archivio `opera` con template dedicati (ora usano i template generici _tw).
- [ ] Preloader: ora parte a ogni caricamento completo di qualsiasi pagina; valutare di limitarlo alla home.
- [ ] Immagini webp/avif e `loading="lazy"` sui file di fallback (le opere da media library hanno già srcset/lazy).
