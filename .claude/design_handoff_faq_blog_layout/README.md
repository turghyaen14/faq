# Handoff: FAQ2U Home + Blog Listing + Blog Article Layout Update

## Overview
Layout update/enhancement for an existing FAQ2U app: a redesigned homepage hero + two-column articles/FAQ layout, a new blog listing page, and a new blog article detail page. This is additive to the app's existing blog and `blog/:id` routes — homepage is an enhancement of what's already live.

## About the Design Files
The files in this bundle (`FAQ2U Home.dc.html`, `FAQ2U Blog.dc.html`, `FAQ2U Article.dc.html`) are **design references built in HTML** — prototypes showing intended look, structure, and responsive behavior, not production code to copy directly. The task is to **recreate these HTML designs in the app's existing codebase** (its existing framework, component library, routing, and data layer), matching the app's established patterns rather than porting the HTML/inline-styles as-is.

## Fidelity
**High-fidelity.** Colors, typography, spacing, corner radii, and responsive breakpoints shown are final — recreate pixel-close using the codebase's existing styling approach (CSS modules/Tailwind/styled-components/etc., whichever the app already uses).

## Screens / Views

### 1. Home (`FAQ2U Home.dc.html`)
**Purpose:** Landing page — hero splash card leading with a featured blog title + image, search, then a two-column "Articles" (2×2 grid) + "FAQs" (compact list) section.

**Layout:**
- Header: logo left + inline nav (Home / FAQs / Blog / About Us), flex row, space-between.
- Hero: centered card (max-width 1120px), background `#FBF8F1`, border `1px solid #E4DDC9`, radius 20px, shadow `0 20px 50px -20px rgba(27,42,86,0.25)`. Inside: featured post title (serif, 32px desktop) padded 32px top/sides, then a full-width splash image (320px tall desktop) filling the bottom of the card, radius matches card bottom corners.
- Search bar: pill shape, 560px max-width, centered, 16px gap below hero card, border `1.5px solid #1B2A56`, circular search button (38px) filled `#1B2A56`.
- Main grid: `grid-template-columns: 2fr 1fr` desktop (Articles left, FAQs right), gap 16px (1rem).
  - Articles: `<h2>` + "View all" link, 2×2 card grid (gap 16px). Each card: title (serif 20px) on top, category/date meta row, then image (150px tall) at bottom of card.
  - FAQs: `<h2>` + "View all" link, vertical list of compact rows — company name (small, muted, truncated) + question (bold) + arrow icon, each in a bordered pill-corner row.
- Footer: logo + tagline + description (left), copyright/credits (right), border-top divider.

### 2. Blog Listing (`FAQ2U Blog.dc.html`)
**Purpose:** Full article index with search and a Grid/List view toggle.

**Layout:**
- Same header/hero/search pattern as Home, but hero title pulls from the featured post.
- Below: a right-aligned Grid View / List View segmented toggle (active state: `#1B2A56` bg, white icon/text; inactive: `#FBF8F1` bg, navy icon/text).
- Cards (grid: `repeat(2, 1fr)` in Grid view, `1fr` in List view or on small screens): author row (avatar-initials circle + name + url) with category pill top-right, then image (170px), then slug tag + "Read →" pill button, then title (serif 19px) + excerpt.

### 3. Blog Article (`FAQ2U Article.dc.html`)
**Purpose:** Single article/FAQ detail page.

**Layout:**
- Header (same nav).
- Full-bleed splash image directly below header (420px tall desktop, rounded 20px, shadow).
- Below: a bordered card (`#FBF8F1`, 1px `#E4DDC9`, radius 20px) containing a 2-column grid (`2fr 1fr`, gap 16px):
  - Left (article): category pill → "Question:"/"Answer:" heading pair → 3-paragraph article body → divider → company block (logo, name, email, address) → tag pills → description paragraph.
  - Right (sidebar, sticky on desktop only): "Explore More" heading + 3 CTA buttons (View company FAQs / Visit website / Back to all FAQs) → divider → "Other FAQs from {company}" list (4 items).
- Footer: same as Home/Blog.

## Interactions & Behavior
- Blog listing Grid/List toggle: click switches `layoutTemplate` between `repeat(2, 1fr)` and `1fr`; on small screens (<640px) it's forced to single column regardless of toggle state.
- All `<a>` cards/rows are click-through links (to article detail, FAQ detail, etc. — wire up real routes).
- No modals, no client-side validation; search inputs are presentational placeholders — wire to real search on implementation.

## Responsive Behavior
Three breakpoints, driven by viewport width (not just CSS media queries in the prototype — recreate with standard CSS media queries in the real app):
- **lg** (≥1024px): full desktop layout as described above.
- **md** (640–1023px): Home/Article 2-column grids collapse to 1 column (FAQs/sidebar drop below articles/body); sidebar in Article is no longer sticky; hero title 28px, splash 260px (Home/Blog) / 320px (Article); reduced section padding (~20-28px); nav gap tightens to 20px.
- **sm** (<640px): everything stacks to 1 column including blog card grids; hero title 24px, splash ~200-220px; header/section padding drops to 16px; footer switches to `flex-direction: column`, left-aligned; nav gap 14px.

Exact padding/size values per breakpoint are in each file's logic class (`renderVals()` — see `bp === 'sm' | 'md' | 'lg'` branches).

## Design Tokens
- **Colors:** background `#F6F1E7` (subtle grid pattern overlay via faint navy lines), card surface `#FBF8F1`, borders `#E4DDC9`, primary/navy `#1B2A56`, primary hover `#3B4E85`, muted text `#736c5a` / `#9a9484`, body text `#232323` / `#4b4636`, tag/pill fill `#EFE8D6`.
- **Typography:** Headings — `Lora` serif, weight 600–700. Body/UI — `Helvetica Neue`/system sans, 13–16px. Serif title sizes: 44/32/28/24px across contexts; body copy 13–15px.
- **Radius:** cards 16–20px, pills 999px, small tags 6–12px.
- **Shadow:** `0 20px 50px -20px rgba(27,42,86,0.25)` (hero/cards), `0 8px 24px -18px rgba(27,42,86,0.35)` (list cards).
- **Spacing:** section gaps standardized to 16px (1rem); card/grid gaps 16px; generous internal card padding (20–36px depending on breakpoint).

## Assets
All images are placeholders (drag-and-drop slots in the prototype) — no real assets supplied. Logo mark is an inline SVG roofline/house icon; replace with the app's real FAQ2U logo asset if one exists.

## Screenshots
- `screenshots/home.png`
- `screenshots/blog.png`
- `screenshots/article.png`

## Files
- `FAQ2U Home.dc.html`
- `FAQ2U Blog.dc.html`
- `FAQ2U Article.dc.html`

Open any file in a browser to see it live; view source for exact markup/inline styles (all styling is inline, no external stylesheet, so every value needed is visible directly on each element).
