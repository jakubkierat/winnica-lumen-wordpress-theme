# Winnica Lumen - motyw WordPress (projekt demonstracyjny)

Autorski motyw WordPress dla fikcyjnej winiarni **Winnica Lumen**. Projekt
portfolio stworzony, żeby pokazać w praktyce stack technologiczny często
wymagany przy utrzymaniu i rozwoju mniejszych stron opartych o WordPress:
**HTML5, CSS3, JavaScript, PHP, WordPress, Git/GitHub**, plus dokumentację
dot. wdrożenia (SSH) i CDN/DNS (Cloudflare).

> Branża (winiarnia/sklep z winem) i nazwa marki są całkowicie fikcyjne —
> to projekt portfolio, nie strona żadnej istniejącej firmy.

## Szybki podgląd bez instalacji WordPressa

Katalog [`preview/`](preview/) zawiera statyczny podgląd całej strony
(jedna strona, ze wszystkimi sekcjami łącznie z formularzem kontaktowym)
- ten sam HTML/CSS/JS co w motywie, tylko bez zależności od bazy danych
i silnika WordPressa. Wystarczy otworzyć `preview/index.html` w
przeglądarce (albo wystawić katalog przez dowolny serwer statyczny /
GitHub Pages).

## Struktura repozytorium

```
winnica-lumen-wordpress-theme/
├── theme/                    ← właściwy motyw WordPress (wrzuć do wp-content/themes/)
│   ├── style.css             ← nagłówek motywu (wymagany przez WP)
│   ├── functions.php         ← konfiguracja motywu, enqueue CSS/JS, menu
│   ├── header.php / footer.php
│   ├── front-page.php        ← strona główna: hero, oferta, o nas, proces,
│   │                            galeria, opinie, FAQ i formularz kontaktowy
│   │                            (#kontakt) — wszystko na jednej stronie
│   ├── page.php              ← domyślny szablon zwykłej podstrony
│   ├── archive-wino.php      ← katalog win (archiwum CPT)
│   ├── single-wino.php       ← widok pojedynczego wina
│   ├── inc/
│   │   ├── custom-post-types.php ← CPT "Wino" + taksonomia "Typ wina" + metabox
│   │   ├── contact-form.php      ← walidacja + wysyłka formularza (wp_mail)
│   │   └── photos.php            ← mapowanie zdjęć z Unsplash użytych w motywie
│   ├── template-parts/
│   │   └── content-wino.php  ← karta wina używana w pętlach
│   └── assets/
│       ├── css/main.css      ← czysty CSS3 (custom properties, grid/flex, animacje)
│       └── js/main.js        ← czysty JavaScript (bez zależności)
├── preview/                  ← statyczny podgląd (patrz wyżej)
├── deploy.example.sh         ← przykładowy skrypt wdrożenia przez SSH/rsync
├── LICENSE                   ← GPLv2 (standard dla motywów WordPress)
└── README.md
```

## Funkcje motywu

- **Jednostronicowy układ** - Oferta, O nas, Jak to działa, Galeria, Opinie,
  FAQ i formularz kontaktowy żyją na jednej stronie głównej (`#kontakt`
  zamiast osobnej podstrony), z płynnym przewijaniem między sekcjami.
- **Custom Post Type „Wino”** z własną taksonomią „Typ wina” (czerwone,
  białe, różowe, musujące) i metaboxem w panelu admina (rocznik, region,
  zawartość alkoholu, cena) - zapisywanym z pełną walidacją i nonce.
- **Formularz kontaktowy bez wtyczek** (`inc/contact-form.php`) - sanityzacja
  danych, nonce, honeypot antyspamowy, wysyłka przez `wp_mail()`, komunikaty
  błędów/sukcesu i „sticky” wypełnione pola po nieudanej walidacji.
- **Zdjęcia z Unsplash** (`inc/photos.php`) zamiast pustych placeholderów -
  darmowa licencja Unsplash License, autorzy wymienieni w kodzie z uprzejmości.
- **Zgodność z Template Hierarchy WordPressa**: `front-page.php`, `page.php`,
  `archive-{post_type}.php`, `single-{post_type}.php`, `404.php`, `index.php`
  jako fallback.
- **Czysty JS (bez frameworków)**: menu mobilne, nagłówek reagujący na
  scroll, paralaksa zdjęcia w hero, animowane liczniki w statystykach,
  animacje pojawiania się sekcji przez `IntersectionObserver`, akordeon FAQ
  na czystym `<details>`/`<summary>` (CSS-only), walidacja formularza jako
  *progressive enhancement* (formularz działa też bez JS - walidacja i tak
  odbywa się w PHP po stronie serwera). Wszystkie animacje respektują
  `prefers-reduced-motion`.
- **CSS3** oparty o custom properties, CSS Grid/Flexbox, responsywność.
- Kod zgodny z konwencjami WordPress Coding Standards (escaping: `esc_html`,
  `esc_attr`, `esc_url`; internacjonalizacja przez `__()` / `esc_html_e()`).

## Instalacja w WordPressie

1. Skopiuj katalog `theme/` do `wp-content/themes/winnica-lumen` w swojej
   instalacji WordPress (lokalnie np. przez LocalWP, `wp-env`, XAMPP, albo
   na serwerze).
2. W panelu **Wygląd → Motywy** aktywuj „Winnica Lumen”.
3. W **Ustawienia → Czytanie** ustaw stronę główną jako statyczną (motyw
   używa `front-page.php`) - formularz kontaktowy i wszystkie pozostałe
   sekcje są już częścią tej strony, nie trzeba tworzyć osobnej podstrony.
4. Dodaj kilka wpisów typu **Wina** (z panelu bocznego), przypisz **Typ
   wina** i uzupełnij metabox „Szczegóły wina”.
5. W **Wygląd → Menu** przypisz menu do lokalizacji „Menu główne” / „Menu w
   stopce” (motyw ma sensowny fallback, jeśli menu nie jest ustawione).

## Mapowanie na wymagania technologiczne

| Wymaganie z ogłoszenia | Gdzie w projekcie |
| --- | --- |
| HTML5 | semantyczna struktura w `header.php`, `footer.php`, szablonach |
| CSS3 | `theme/assets/css/main.css` - custom properties, Grid/Flexbox, animacje |
| JavaScript | `theme/assets/js/main.js` — bez zależności, vanilla JS |
| PHP | całość logiki motywu i CPT w `theme/*.php`, `theme/inc/*.php` |
| WordPress | Template Hierarchy, CPT, taksonomie, `wp_mail`, `wp_nav_menu`, metaboxy |
| GitHub | to repozytorium - historia commitów, README, licencja |
| Praca w terminalu (SSH) | `deploy.example.sh` — przykładowy przepływ wdrożenia |
| Cloudflare | sekcja niżej - zalecenia konfiguracyjne |
| Selly | zobacz uwagę poniżej tabeli |

> **Selly** to zamknięta, komercyjna platforma e-commerce - nie da się jej
> odtworzyć w otwartym projekcie demo. CPT „Wino” pokazuje jednak
> transferowalne umiejętności potrzebne przy pracy z podobnymi systemami:
> modelowanie katalogu produktów, pola niestandardowe, taksonomie/kategorie.

## Uwagi dot. wdrożenia i Cloudflare

Dla domeny spiętej z Cloudflare warto:

- włączyć proxy DNS (pomarańczowa chmurka) dla ochrony przed atakami i
  cache'owania zasobów statycznych,
- ustawić **Cache Rules** dla `theme/assets/*` (długi cache, wersjonowanie
  przez `WINNICA_LUMEN_VERSION` w `functions.php` odświeża cache po
  wdrożeniu),
- używać **Page Rules / SSL: Full (strict)** między Cloudflare a
  serwerem,
- po każdym wdrożeniu czyścić cache CDN (patrz komentarz w
  `deploy.example.sh`).

## Zdjęcia

Zdjęcia pochodzą z [Unsplash](https://unsplash.com) i są używane na
[Unsplash License](https://unsplash.com/license) — darmowej w użyciu
komercyjnym i niekomercyjnym, bez wymogu podawania autora. Pełna lista
z linkami i podpisami autorów: [`theme/inc/photos.php`](theme/inc/photos.php).

## Licencja

Kod motywu jest udostępniony na licencji GPLv2 lub późniejszej — zgodnie ze
standardową konwencją motywów WordPress. Zobacz [LICENSE](LICENSE).

---

Autor: [Jakub Kierat](https://github.com/jakubkierat)
