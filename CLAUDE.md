# CLAUDE.md — Ember & Oak WordPress Theme

## Project Overview

**Ember & Oak Coffee Roasters** is a fictional artisan small-batch coffee roastery and café based in Brooklyn, NY. This WordPress theme was designed and built entirely using Claude Code as the primary development environment — from initial architecture decisions to final file writes, without leaving the terminal.

The design philosophy is warm, intentional, and craft-forward. The color palette centers on espresso browns (`#1a0f0a`) and caramel ambers (`#c47a3a`) against cream and milk whites, evoking the physical warmth of a specialty coffee shop. Typography pairs Playfair Display (serif, headings) with Inter (sans-serif, body) for a balance of heritage craft and modern readability.

## How This Was Built with Claude Code

**Phase 1 — Architecture before code.** Before a single PHP file was written, Claude Code was used to think through the content model. The two custom post types — `ember_blend` and `ember_event` — were chosen because blends and events are genuinely distinct content entities with structured metadata (roast level, process method, tasting notes; event date, capacity, price) that benefit from dedicated archives, single templates, and SEO-friendly URLs. A taxonomy (`blend_origin`) was added for filterable origin browsing. This kind of upfront CPT design prevents the common WordPress mistake of shoehorning structured content into pages with custom fields bolted on later.

**Phase 2 — Parallel file generation with the Workflow tool.** The core build used Claude Code's `/workflow` capability to fan out 15+ agents simultaneously, each responsible for one file — `style.css`, `functions.php`, all PHP template files, `assets/css/main.css`, `assets/js/main.js`, `theme.json`, and documentation. This mirrors how a real team might divide work across developers, except the "team" spun up in seconds. The Workflow tool's `parallel()` primitive was used within phases so that independent files (e.g. `footer.php` and `page.php`) generated concurrently while files with dependencies (e.g. `template-parts/content-blend.php` which calls `ember_oak_get_blend_meta()` defined in `functions.php`) were specified after their dependencies were locked in.

**Phase 3 — Cross-file consistency as the primary constraint.** The hardest part of generating a multi-file codebase with parallel agents is keeping shared interfaces consistent. In this build, `functions.php` defined the canonical meta keys (`roast_level`, `tasting_notes`, `process`, `price`), the helper function signatures (`ember_oak_get_blend_meta($post_id)`), and the Customizer `get_theme_mod` key names (`ember_oak_phone`, `ember_oak_address`, etc.). These were passed explicitly in the prompts for every template file that needed to call them — agents were told the exact function signatures and key names, not left to invent their own. This is where the human directing Claude Code adds the most value: holding the interface contract and making sure every agent honors it.

**Phase 4 — Zero-dependency constraint.** A deliberate decision was made to use no external plugin dependencies, no jQuery, no CSS preprocessor, and no build toolchain. The theme works by dropping the folder into `wp-content/themes/` — nothing to install or compile. This was enforced in the JS prompt ("vanilla JS only, no jQuery") and the CSS prompt ("CSS custom properties, no Sass"). The result is a theme that will still activate correctly on any WordPress 6.0+ install in 2030.

## Claude Code Workflow Patterns Used

- **`/workflow` with `parallel()`** — fan out 15+ file-generation agents simultaneously
- **`Write` tool** — agents wrote files directly to disk rather than returning content for the orchestrator to write
- **Explicit interface contracts in prompts** — function signatures, meta key names, and `get_theme_mod` keys specified verbatim in every agent prompt that needed them
- **Sequential dependency ordering** — `functions.php` locked before template files that call its helpers
- **Grep for verification** — after generation, `Grep` was used to verify consistent meta key usage across `functions.php` and template-parts

## Architecture Decisions

| Decision | Rationale |
|----------|-----------|
| `ember_blend` as CPT, not pages | Structured meta (roast, notes, price), custom archive at `/blends/`, taxonomy support |
| `ember_event` as CPT | Date-based querying, structured meta, clean archive at `/events/` |
| CSS custom properties over Sass | Zero build step, natively overridable in child themes, works with `theme.json` |
| Vanilla JS, no jQuery | WordPress no longer bundles jQuery by default in modern themes; ~30KB saved |
| `theme.json` for block editor | Palette and typography exposed to the block editor without PHP |
| No ACF dependency | Custom meta boxes in `functions.php` keep the theme self-contained |
| Walker extension for nav | Adds `aria-expanded` and keyboard toggle buttons without a plugin |

## Development Commands

```bash
# With wp-env (recommended for clean environment)
npx @wordpress/env start
# Theme activates at http://localhost:8888

# Or copy into any local WordPress install
cp -r ember-oak /path/to/wp-content/themes/
wp theme activate ember-oak

# Import demo content
wp plugin install wordpress-importer --activate
wp import demo-content.xml --authors=create

# Flush rewrite rules after activation (required for CPT archives)
wp rewrite flush
```

## File Structure

```
ember-oak/
├── style.css                      # Theme header + CSS reset + base utilities
├── theme.json                     # Block editor color palette + typography scale
├── functions.php                  # Theme setup, CPTs, taxonomies, meta boxes, customizer, helpers
├── index.php                      # Blog index (loop fallback)
├── front-page.php                 # Homepage: hero, blends, process, events, testimonials, CTA
├── page.php                       # Default page template
├── single.php                     # Single post router → delegates to template-parts
├── archive.php                    # Archive router: blends catalog, events list, blog grid
├── search.php                     # Search results
├── 404.php                        # Not found page
├── header.php                     # Site header, sticky nav, mobile hamburger
├── footer.php                     # 4-column footer, social links, email signup
├── sidebar.php                    # Blog sidebar (dynamic widgets with fallback)
├── template-parts/
│   ├── content.php                # Standard blog post card
│   ├── content-none.php           # Empty state / no results
│   ├── content-blend.php          # Full single blend detail layout
│   └── content-event.php          # Full single event detail layout
├── templates/
│   ├── page-about.php             # About Us: story, team, values, press
│   ├── page-menu.php              # Coffee Menu: filterable blend catalog
│   └── page-contact.php          # Contact: form, info, FAQ accordion
├── assets/
│   ├── css/main.css               # All component and page-level styles
│   └── js/main.js                 # Mobile nav, sticky header, tabs, filters, animations
├── demo-content.xml               # WXR import: 4 blends, 2 events, 3 posts, 4 pages
├── screenshot.svg                 # Theme preview image
├── README.md                      # Setup and usage documentation
└── CLAUDE.md                      # This file
```

## Theme Customizer

**Appearance → Customize → Ember & Oak Settings**

- **Hero Section**: `hero_heading`, `hero_subheading`, `hero_cta_text`, `hero_cta_url`
- **Contact Info**: `ember_oak_phone`, `ember_oak_email`, `ember_oak_address`, `ember_oak_hours_weekday`, `ember_oak_hours_weekend`
- **Social Links**: `ember_oak_social_instagram`, `ember_oak_social_facebook`, `ember_oak_social_twitter`

## Custom Post Types

**Coffee Blends** — registered as `ember_blend`, archive at `/blends/`
Meta fields (Blend Details metabox): `roast_level`, `tasting_notes`, `origin_region`, `process`, `price`, `weight_options`
Taxonomy: `blend_origin` (Origin) at `/origin/`

**Events** — registered as `ember_event`, archive at `/events/`  
Meta fields (Event Details metabox): `event_date`, `event_time`, `event_location`, `event_price`, `event_capacity`
