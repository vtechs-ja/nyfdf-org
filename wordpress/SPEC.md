# NYFDI WordPress Theme — Implementation Spec

## Overview

This document defines the approach for converting the existing `index.html` into a bespoke
WordPress theme for the Northgate Youth and Family Development Initiative.

The live static site (`index.html`) remains untouched during development. All WordPress code
lives under the `wordpress/` subfolder.

Everything — CPT registration, field definitions, options pages, templates — lives in a single
theme package. A companion plugin is not used; the content model is specific to this organisation
and there is no reuse case that would justify the split.

---

## Folder Structure

```
wordpress/
├── SPEC.md
└── nyfdf-theme/
    ├── style.css                         ← theme header (name, version, text domain)
    ├── functions.php                     ← bootstraps all inc/ files
    ├── front-page.php                    ← homepage: loads all section template parts
    ├── single-nyfdf_programme.php        ← individual programme landing page
    ├── archive-nyfdf_programme.php       ← /programmes/ listing (if enabled)
    ├── header.php                        ← nav with hamburger toggle
    ├── footer.php
    ├── inc/
    │   ├── cpt.php                       ← CPT registration
    │   ├── taxonomies.php
    │   ├── fields.php                    ← all CMB2 meta box + options page definitions
    │   ├── enqueue.php                   ← wp_enqueue_scripts / styles
    │   └── template-tags.php            ← reusable helper functions for templates
    ├── template-parts/
    │   ├── section-hero.php
    │   ├── section-gold-band.php
    │   ├── section-about.php
    │   ├── section-pillars.php
    │   ├── section-programmes.php
    │   ├── section-reach.php
    │   ├── section-leadership.php
    │   ├── section-flagship.php          ← dynamic: renders whichever programme is flagged
    │   ├── section-social-feed.php
    │   └── section-connect.php
    └── assets/
        ├── css/
        │   └── style.css                 ← main stylesheet (ported from static site)
        └── js/
            └── site.js                   ← hamburger toggle, years-of-service calc
```

---

## Dependencies

| Dependency | Required | Notes |
|---|---|---|
| **CMB2** | Yes | Custom fields, repeater groups, options pages. Install as a required plugin (not bundled in theme). Free, maintained by WebDevStudios. |
| **WordPress 6.4+** | Yes | |
| ACF (any tier) | No | Not used |
| Page builder | No | Not used |

CMB2 covers all field needs: text, textarea, WYSIWYG, image/file upload, checkbox, select, and
repeater groups (`group` field type). Options pages are registered via
`new_cmb2_box( [ 'show_on' => [ 'key' => 'options-page' ] ] )`.

---

## Content Model

### Custom Post Types

#### `nyfdf_programme`

The central CPT. Powers both the homepage programmes grid and the flagship section, and has its
own public landing page.

| Field | Type | Notes |
|---|---|---|
| Post title | WP native | Programme name |
| Post content | WP editor | Full description — background, purpose, who it serves (used on single page) |
| Featured image | WP native | Hero image for the single programme page |
| `programme_order` | Number | Controls position in the homepage grid |
| `programme_short_description` | Textarea | Short card description for the homepage grid |
| `programme_is_flagship` | Checkbox | If checked, this programme renders in the flagship homepage section. Only one should be checked at a time. |
| `programme_impact` | Textarea or WYSIWYG | Impact/outcomes content — displayed on the single page |
| `programme_timeline` | Group (repeater) | Each row: `month_number` (Number), `date_tag` (Text), `event_name` (Text), `event_description` (Textarea), `is_complete` (Checkbox) |

**Public**: Yes · **Rewrite slug**: `programmes` · **Has archive**: Yes · **Supports**: `title`,
`editor`, `thumbnail`

The timeline repeater renders on both the flagship homepage section (when `is_flagship` is true)
and on the single programme page. When a programme is no longer the flagship, its timeline is
only visible on its own page.

---

#### `nyfdf_reach`

Impact and reach cards displayed in the Reach section.

| Field | Type | Notes |
|---|---|---|
| Post title | WP native | Card heading (e.g. "30+ Schools Engaged") |
| `reach_label` | Text | Small category label above the title (e.g. "Education") |
| `reach_description` | Textarea | Card body |
| `reach_order` | Number | Display order |

**Public**: No · **Has archive**: No · **Supports**: `title`

Taxonomy: `nyfdf_reach_category` (see below). Not strictly required now but costs nothing and
allows filtering if the section expands.

---

### Taxonomies

#### `nyfdf_reach_category`
Applied to `nyfdf_reach`.

**Hierarchical**: No · **Public**: No · **Show in REST**: No

Seed terms: `Education`, `Community`, `Institutions`, `Regional`, `Corrections`,
`Education — Secondary`

---

### CMB2 Options Pages

All registered under a top-level **NYFDI** admin menu. Each sub-page corresponds to a
homepage section or site-wide settings.

---

#### Site Settings
Slug: `nyfdf-settings`

| Field | Type | Notes |
|---|---|---|
| `site_address` | Text | Ocho Rios, Saint Ann, Jamaica |
| `site_email` | Text | |
| `site_phone` | Text | |
| `site_whatsapp` | Text | Placeholder until confirmed |
| `site_facebook_url` | Text | Used for the Facebook embed and channel card |
| `site_instagram_handle` | Text | Without @ |
| `site_youtube_handle` | Text | |
| `site_twitter_handle` | Text | |
| `gold_band_items` | Textarea | One focus area label per line |

---

#### Hero
Slug: `nyfdf-hero`

| Field | Type | Notes |
|---|---|---|
| `hero_image` | Image | Replaces the current `img-ph` placeholder (portrait, min 900×1100px) |
| `hero_headline` | Textarea | Multi-line headline — line breaks preserved in template |
| `hero_subtext` | Textarea | Paragraph below the headline |
| `hero_cta_primary_label` | Text | Default: "Our Mission" |
| `hero_cta_primary_anchor` | Text | Default: `#about` |
| `hero_cta_secondary_label` | Text | Default: "What We Do" |
| `hero_cta_secondary_anchor` | Text | Default: `#programmes` |
| `hero_quote` | Textarea | Italic quote in the stat card |
| `hero_stat_schools` | Text | Default: "30+" |
| `hero_stat_parishes` | Text | Default: "6+" |

Years of service is calculated dynamically in `site.js` (year − 2008) and does not need a field.

---

#### About
Slug: `nyfdf-about`

| Field | Type | Notes |
|---|---|---|
| `about_body_1` | Textarea | First paragraph |
| `about_body_2` | Textarea | Second paragraph |
| `about_body_3` | Textarea | Third paragraph |
| `about_vision` | Textarea | Vision statement |
| `about_mission` | Textarea | Mission statement |
| `about_quote` | Textarea | Blockquote text |
| `about_quote_attribution` | Text | e.g. "Wesley Boynes, JP · Founder & Chairman, NYFDI" |
| `about_community_photo` | Image | Replaces the team/community `img-ph` placeholder |
| `about_affiliations` | Group (repeater) | Each row: `aff_name` (Text), `aff_logo` (Image), `aff_url` (Text), `aff_order` (Number) |

---

#### Pillars
Slug: `nyfdf-pillars`

| Field | Type | Notes |
|---|---|---|
| `pillars` | Group (repeater) | Each row: `pillar_icon` (Text — emoji or unicode), `pillar_title` (Text), `pillar_description` (Textarea) |

---

#### Programmes
Slug: `nyfdf-programmes`

| Field | Type | Notes |
|---|---|---|
| `programmes_intro` | Textarea | Intro paragraph in the section header |
| `programmes_banner_image` | Image | Replaces the wide banner `img-ph` placeholder |

---

#### Leadership
Slug: `nyfdf-leadership`

**Founder card:**

| Field | Type | Notes |
|---|---|---|
| `founder_photo` | Image | Portrait |
| `founder_name` | Text | Full name with post-nominals |
| `founder_title` | Text | e.g. "Founder & Chairman · Justice of the Peace, St. Mary" |
| `founder_bio` | Textarea | Paragraph biography |
| `founder_highlights` | Group (repeater) | Each row: `highlight_text` (Text) |

**Governance tiers:**

| Field | Type | Notes |
|---|---|---|
| `governance_tiers` | Group (repeater) | Each row: `tier_title` (Text), `tier_named_lead` (Text — optional), `tier_description` (Textarea), `tier_order` (Number) |

---

#### Reach — Awards
Slug: `nyfdf-awards`

| Field | Type | Notes |
|---|---|---|
| `awards` | Group (repeater) | Each row: `award_source` (Text), `award_description` (Textarea) |

---

#### Connect
Slug: `nyfdf-connect`

| Field | Type | Notes |
|---|---|---|
| `connect_intro` | Textarea | Section intro paragraph |

---

## Section → Template Mapping

| Homepage Section | Template Part | Data Source |
|---|---|---|
| Nav | `header.php` | WP nav menu (`primary`), site logo via Customizer |
| Hero | `section-hero.php` | CMB2 options: Hero |
| Gold Band | `section-gold-band.php` | `gold_band_items` from Site Settings (split by newline) |
| About | `section-about.php` | CMB2 options: About (inc. affiliations repeater) |
| Pillars | `section-pillars.php` | CMB2 options: Pillars repeater |
| Programmes | `section-programmes.php` | `nyfdf_programme` query ordered by `programme_order`, excluding flagship; banner image from Programmes options |
| Reach | `section-reach.php` | `nyfdf_reach` query ordered by `reach_order`; awards repeater from Reach — Awards options |
| Leadership | `section-leadership.php` | CMB2 options: Leadership (founder + governance tiers) |
| Flagship | `section-flagship.php` | `nyfdf_programme` query where `programme_is_flagship = 1` (single result) |
| Social Feed | `section-social-feed.php` | `site_facebook_url` from Site Settings |
| Connect | `section-connect.php` | CMB2 options: Connect; social handles + contact info from Site Settings |
| Footer | `footer.php` | Site Settings, WP nav menu (`footer`) |

---

## Programme Landing Page (`single-nyfdf_programme.php`)

Each programme has a public page at `/programmes/{slug}/`. Sections:

1. **Header** — programme name over featured image (full-width hero)
2. **Background** — WP post content (editor), rendered via `the_content()`
3. **Impact** — `programme_impact` CMB2 field
4. **Timeline** — rendered only if `programme_timeline` has rows; same component as used in `section-flagship.php`
5. **CTA** — contact/partner prompt linking to `#connect` on the homepage

A shared timeline template part (`template-parts/programme-timeline.php`) is used by both
`section-flagship.php` and `single-nyfdf_programme.php` to avoid duplication.

---

## Flagship Section Lifecycle

The flagship section on the homepage is a slot, not a fixed section:

- **Active**: one programme has `programme_is_flagship` checked → `section-flagship.php` renders its title, description paragraphs, timeline, and CTA
- **Transition**: uncheck the outgoing programme, check the incoming one. The outgoing programme remains in the programmes grid and its timeline is still visible on its `/programmes/{slug}/` page
- **No flagship set**: `section-flagship.php` renders nothing (or a configurable fallback message)

An admin note in `fields.php` (CMB2 `title` field type used as a hint) will remind editors that
only one programme should have this flag active at a time.

---

## Navigation

Two nav menus registered in `functions.php`:

- `primary` — sticky top nav; collapses to hamburger at ≤960px
- `footer` — footer links

**Mobile nav**: a `<button class="nav-toggle">` is added to `header.php`. `site.js` toggles a
`.nav-open` class on `<body>`. CSS shows/hides `.nav-links` based on that class. No library
required.

---

## JavaScript (`assets/js/site.js`)

- Years-of-service counter: `new Date().getFullYear() - 2008` → injected into `.stat-num[data-stat="years"]`
- Hamburger toggle: `.nav-toggle` click → toggle `.nav-open` on `body`
- Footer year: handled in PHP via `date('Y')` — no JS needed

---

## Styles (`assets/css/style.css`)

Port from the static site's `css/style.css` with minimal changes:

- Google Fonts `<link>` replaced by `wp_enqueue_style()` in `inc/enqueue.php`
- `.img-ph` placeholder styles can be removed once real images are in place
- No `theme.json` — this is a classic theme; the design system is fully controlled by the existing CSS custom properties

---

## Image Placeholders → Managed Fields

| Current placeholder | Section | CMB2 field |
|---|---|---|
| Hero right panel | Hero | `hero_image` |
| Team/community photo | About | `about_community_photo` |
| Programmes in Action banner | Programmes | `programmes_banner_image` |

---

## Programmes Archive (`/programmes/`)

Proposed layout, consistent with the site's design language:

```
┌─────────────────────────────────────────────────────┐
│  ARCHIVE HEADER  (ink background)                   │
│  Eyebrow: "What We Do"                              │
│  H1: "Our Programmes"                               │
│  Intro text (from Programmes options)               │
└─────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────┐
│  FEATURED PROGRAMME  (teal background)              │
│  — rendered only if a flagship is set —             │
│  Left: eyebrow "Current Initiative", programme      │
│        name, short description, first 2 timeline    │
│        entries as a mini-preview, "View Programme→" │
│  Right: featured image                              │
└─────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────┐
│  ALL PROGRAMMES  (mist background)                  │
│  Eyebrow: "All Programmes"                          │
│  3-column card grid — each card:                    │
│    Featured image (top)                             │
│    Programme number  ·  "Current Initiative" tag    │
│                         (if flagship)               │
│    Programme name                                   │
│    Short description                                │
│    "Learn More →"                                   │
└─────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────┐
│  CTA STRIP  (gold background)                       │
│  "Want to get involved?" → "Partner With Us"        │
│  Links to homepage #connect                         │
└─────────────────────────────────────────────────────┘
```

The flagship programme appears in both the featured block and the main grid (tagged "Current
Initiative") so the grid is always a complete listing.

---

## Open Items

- **WhatsApp number** — `site_whatsapp` field is in place; to be populated in WP admin when confirmed.
