# Primex

A premium, Elementor-first WordPress theme for logistics, transportation, freight, shipping, warehousing, and supply-chain businesses. Built on a clean design-token foundation (`theme.json` + CSS custom properties), with full WooCommerce support, RTL readiness, accessibility (WCAG 2.1 AA target), and performance tuned for Core Web Vitals.

Layouts are never hardcoded — everything is editable in Elementor.

## Requirements

- WordPress 6.4+
- PHP 8.2+
- Elementor (recommended) and/or Elementor Pro for visual layout
- WooCommerce (optional) for e-commerce

## Installation

1. Copy the `primex/` folder to `wp-content/themes/`.
2. In WordPress admin: **Appearance → Themes → Activate Primex**.
3. (Recommended) Install Elementor and Elementor Pro to edit layouts visually.

## What's in this build (Phase 1 — Foundation)

- `style.css` — theme header + minimal reset
- `theme.json` — design tokens: color palette (Primary `#0B5FFF`, Secondary `#FFB400`, Dark, Gray, Success), Inter/Manrope font families, 8px spacing scale, layout sizes
- `functions.php` — bootstrap only; constants, PHP version guard, autoloader, module includes
- `inc/autoloader.php` — file-map autoloader for `Primex_*` classes
- `inc/theme-setup.php` — `add_theme_support` calls, menu locations, image sizes, widget areas
- `inc/scripts.php` — enqueue strategy (base + components CSS, deferred vanilla JS, resource hints, font preload)
- `inc/accessibility.php` — skip-to-content link, focus management
- `assets/css/base.css` — reset + design-token variables + typography (mirror of `theme.json`)
- `assets/css/components.css` — buttons, cards, breadcrumbs, pagination, widgets
- `assets/js/main.js` — vanilla ES6+: dark mode, toggles, escape-to-close
- `editor-style.css` — block-editor typography mirror
- `header.php`, `footer.php`, `index.php`, `template-parts/content/*.php` — minimal semantic scaffolding (Phase 2 expands)

## Design tokens (single source of truth)

| Token | Value |
|-------|-------|
| Primary | `#0B5FFF` |
| Secondary | `#FFB400` |
| Dark | `#1A1A1A` |
| Gray BG | `#F5F7FA` |
| Success | `#28C76F` |
| Headings | Manrope |
| Body | Inter |
| Spacing unit | 8px |
| Container | 1320px |
| Content | 800px |

Tokens are defined in `theme.json`, mirrored as CSS custom properties in `assets/css/base.css` (`--primex-color-*`, `--primex-space-*`), and surfaced to Elementor via Global Colors/Fonts in Phase 3.

## Roadmap

Remaining phases (see `.agents/skills/wp-logistics-theme/references/build-guide.md`):

- Phase 2 — Layout primitives (header/footer layouts, page templates)
- Phase 3 — Elementor integration (Theme Builder locations, global color/font mapping)
- Phase 4 — Template parts, custom post types, RTL, child theme
- Phase 5 — Elementor sections & custom widgets (homepage sections)
- Phase 6 — WooCommerce
- Phase 7 — Customizer (global options only)
- Phase 8 — Performance
- Phase 9 — Accessibility & SEO
- Phase 10 — Security pass
- Phase 11 — Demo content & one-click import
- Phase 12 — Docs, child theme, licensing

## License

GPL-2.0-or-later. Bundled third-party assets are listed in `credits.md` (added in Phase 12).

## Notes

- `screenshot.png` (1200×900) is a placeholder slot — original artwork lands in Phase 12.
- Fonts are loaded from Google Fonts CDN during development; Phase 8 self-hosts them with preload + `font-display: swap`.
- This theme is an original work. The reference site at https://demo.artureanec.com/themes/transx-new/home-logistic/ is a quality/UX benchmark only — no design, assets, or implementation is copied.
