# CLAUDE.md — Stifano Passarelli (tema WordPress)

Tema classico che porta in WordPress la **bozza statica** della homepage
(`/home/aledev/Documents/Backup_siti_laptop/Local Sites/draft_stifano_passarelli/`):
one-page per il duo Emanuele Stifano (scultura) e Carla Passarelli (mosaico),
*"Non è l'oggetto a essere sacro, è il rito che lo abita."*

## ⚠️ Regola d'oro — la bozza vince

1. **Codice della bozza** (`index.html`, `assets/css/style.css`, `assets/js/main.js`): riferimento 1:1 per layout, classi, animazioni e copy.
2. **`claude.md` della bozza**: decisioni, reference (eleos, septiembre, normalisboring), TODO contenuti.
3. **Boilerplate _tw/approdo** (struttura WP, Barba, ACF): vale solo dove la bozza non dice nulla.

Per verificare si confronta il sito WP con la bozza servita in statico
(`python3 -m http.server` nella cartella della bozza).

---

## Sito locale

- **Local**: sito `stifanopassarelli` (id `kS4_Ij_6h`), `http://stifanopassarelli.local`, root WP `/home/aledev/Local Sites/stifanopassarelli/app/public/`. Il tema è in `wp-content/themes/stifanopassarelli/`; WordPress lo vede come `stifanopassarelli/theme`.
- **Plugin**: Advanced Custom Fields (free) attivo. Nient'altro per ora (CF7 o simili quando si collega il form dei Contatti).
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
    page-home.php                 ← <main data-barba="container" data-barba-namespace="home"> + 10 sezioni
    inc/
      acf-helpers.php             ← stifanopassarelli_field/the_field/setting/the_setting (fallback = copy bozza)
      acf-fields.php              ← gruppi Homepage (10 tab) e Impostazioni globali + colonne Work in progress
      opere.php                   ← CPT `opera` + tassonomia `collezione`, lettura opere con fallback bozza
      setup.php                   ← after_switch_theme: pagine Home + Impostazioni globali, collezioni, permalink
      template-functions.php      ← asset_url, home_anchor, nav_items, lines (+ helper _tw)
    template-parts/
      layout/                     ← cursor, preloader, header-content, footer-content
      components/monogram.php     ← SVG ufficiale (parts: all | o | e)
      sections/home/              ← hero, manifesto, work-in-progress, il-rito, negativo, ordinarium, antologia, artisti, discover, contatti
    assets/{img,logo,video}/      ← solo i file usati dalla bozza (stessi path)
    fonts/                        ← Playfair Display + Inter (variabili), Space Mono 400/700 — woff2 Fontsource, latin + latin-ext
  javascript/
    script.js                     ← init persistenti + hook Barba
    utils/                        ← env, scroll (Lenis), cursor, preloader, header, footer (persistenti) · animations, slider (scoped + cleanup)
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
- `components/*.css` = `style.css` della bozza diviso per intervalli di righe, **copiato 1:1** (anche le poche regole non usate, es. `.sp-hero__title`). Se si modifica un componente, va fatto lì.
- Gli stili inline della bozza sono diventati utility (`relative z-[2]`, `aspect-[4/5]`, `px-(--sp-gutter)`, `text-[length:clamp(…)]`…).
- ⚠️ **Precedenza**: in _tw i componenti vengono **prima** delle utility e il CSS base di Swiper **dopo**. `.swiper { padding: 0 }` batte le utility → sul carosello `px-(--sp-gutter)!`.
- ⚠️ **Font nella bozza**: il Tailwind Play CDN si caricava dopo `style.css` e sovrascriveva `.font-mono` / `.font-serif` con i font di default (monospace di sistema e Georgia). Nel tema le classi usano Space Mono e Playfair come previsto: didascalie e titoli dell'Antologia risultano diversi dalla bozza (il Manifesto è 19px più basso). È voluto.

## JavaScript / Barba

- Fuori dal container (init una tantum al `DOMContentLoaded`): Lenis, cursore (hover via delegation sul document), header, reveal del footer, preloader (solo al primo caricamento).
- Trigger persistenti: `header-hide`, `footer-reveal` (`PERSISTENT_TRIGGERS` in `script.js`); gli altri vengono uccisi in `afterLeave`.
- View `home`: `initHero`, `initReveals`, `initSlats`, `initVeil`, `initPanels`, `initIndexHover`, `initNegative`, `initMarquee`, `initCarousels`. Ognuna è scoped al container e ritorna una cleanup (gsap.context + listener su window + cloni del marquee).
- Lenis con le opzioni della bozza, `anchors: true`; con `prefers-reduced-motion` **niente Lenis** (come nella bozza), quindi `getLenis()` può essere `null`.
- Work in progress: resta `position: sticky` come nella bozza (niente pin GSAP). Per variare il collage `initVeil` usa `data-set` sulle foto (= cartella dello shooting della foto di default).
- Rimossi rispetto a `main.js`: il reveal del titolo hero (`.sp-hero__title` non c'è nell'HTML) e la classe `is-loading` sul body (nessuno stile la usava).

## Contenuti (ACF + CPT)

- **Homepage** (location `front_page`): un tab per sezione. Ogni campo vuoto mostra la copy/foto della bozza (fallback nei template = `default_value` del campo).
- **Work in progress**: 16 campi immagine `home_wip_col_{1-4}_foto_{1-4}`; colonne/velocità in `stifanopassarelli_wip_columns()`.
- **Opere** (CPT `opera`, archivio `/opere/`, tassonomia `collezione`: `ordinarium`, `antologia`). Immagine = immagine in evidenza. Ordine = "Ordine" negli attributi. Campi: `opera_sottotitolo`, `opera_descrizione` (Ordinarium), `opera_nota` (Antologia), `opera_in_indice`, `opera_indice_etichetta` (vuoto = "Collezione · anno").
  - Una collezione senza opere pubblicate mostra le opere della bozza (`stifanopassarelli_opere_bozza()`).
  - L'indice = opere con "Mostra nell'indice", prima Ordinarium poi Antologia; link all'ancora della sezione.
- **Impostazioni globali** (pagina slug `impostazioni-globali`, redirect 301 alla home dal front end): social (Contatti) e footer.
- **Nav header**: menu nella posizione "Header" se assegnato, altrimenti le ancore della bozza (`#…` sulla home, `home_url('/#…')` altrove).
- **Contatti**: campo `home_contatti_form` = shortcode (es. CF7). Se è vuoto resta il form della bozza, che non invia nulla.

## TODO (dalla bozza + porting)

- [ ] Menu mobile: il bottone "Menu" della bozza non ha comportamento.
- [ ] Video hero definitivo, video split "Doppia Pelle", copy Ordinarium, bio, P.IVA (vedi `claude.md` della bozza, §8).
- [ ] Inserire le opere reali nel CPT (immagini in evidenza + collezione).
- [ ] Discover → CPT "esposizioni" in stile blog (ora textarea, un luogo per riga).
- [ ] Single/archivio `opera` con template dedicati (ora usano i template generici _tw).
- [ ] Preloader: ora parte a ogni caricamento completo di qualsiasi pagina; valutare di limitarlo alla home.
- [ ] Immagini webp/avif e `loading="lazy"` sui file di fallback (le opere da media library hanno già srcset/lazy).
