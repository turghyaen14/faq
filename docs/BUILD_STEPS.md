# FAQ2U — Build Steps (Home / Blog / Article layout)

**Read `docs/DATA_CONTRACT.md` first.** This file tells you the ORDER to build in and exactly what
to do in each step. Do the steps in order. Do not skip. After each step, run its **CHECK** before moving on.

---

## GROUND RULES (apply to every step — never break these)

1. **This is an enhancement, not a reskin.** Keep the existing colors, fonts, and CSS classes from
   `css/style.css`. Do NOT introduce new colors/fonts (no Lora, no `#1B2A56` navy). Reuse existing
   classes: `.faqContentListContainer`, `.resultCard`, `.shadowSm`, `.tagContainer`,
   `.customCategoryBadge`, `.tabWrapper`, `.searchContainer`, `.viewBtn`, `.faqSidebar`, `.sidebarItem`.
2. **Never write SQL in a controller.** Controllers call methods on `Faq`, `Company`, `Article`.
   All queries live in `classes/`.
3. **Never put data or text directly in a `view/*.html` file.** Views only contain `{TAG}` placeholders.
   The controller fills them. Copy strings come from Section D of the contract.
4. **Match the existing controller shape** (copy the pattern from
   `page_controller/IndexPageController.class.php`): build a `TEMPLATE`, loop repeatable
   `{START_X:00}...{END_X:00}` blocks with a second `TEMPLATE` using `->renew()` then `->replace()`,
   accumulate into a string, do ONE final `->replace([...])`, then `return ->content(false, true)`.
5. **Every new folder gets a `.htaccess`** (copy the deny-all one from `classes/.htaccess`). Not expected here.
6. **Do not change any existing method name, parameter, or return key.** Only ADD.
7. After finishing, **update the CHANGELOG at the bottom of this file** with what you did.

---

## STEP 1 — Dummy data + toggle + stub methods (the seam)

**Goal:** create the data layer everything else reads from. No pages yet.

1. Open `config/config.php`. Add near the other globals:
   ```php
   $USE_DUMMY_DATA = true;
   ```
2. Create `classes/DummyData.class.php`. It is a class with static methods that return arrays.
   Fill each method with the dummy rows for its schema in `docs/DATA_CONTRACT.md` Section A:
   - `public static function articleCards()` → array of 8 `articleCard` (A2)
   - `public static function featured()` → one `featured` object (A3)
   - `public static function articleDetail()` → one `articleDetail` object (A4)
   *(If a lower model is generating the values, it only fills the arrays — keep the keys exactly.)*
3. Create `classes/Article.class.php`. Copy the constructor pattern from `classes/Faq.class.php`
   (the `global $conn; ... global $db_8_np2u;` block). Add three methods, each with a dummy branch:
   ```php
   function getCards($options = []) {
       global $USE_DUMMY_DATA;
       if ($USE_DUMMY_DATA) { return DummyData::articleCards(); }
       // BACKEND: real query here, must return the articleCard (A2) shape
       return [];
   }
   function getFeatured() {
       global $USE_DUMMY_DATA;
       if ($USE_DUMMY_DATA) { return DummyData::featured(); }
       // BACKEND: real query here, must return the featured (A3) shape
       return [];
   }
   function getDetailByFaqId($faq_id) {
       global $USE_DUMMY_DATA;
       if ($USE_DUMMY_DATA) { return DummyData::articleDetail(); }
       // BACKEND: real query here, must return the articleDetail (A4) shape
       return [];
   }
   ```
   Both classes are autoloaded automatically (no `require` needed) because they end in `.class.php`
   and live in `classes/` — see `required.php`.

**CHECK:** Create a throwaway `test_dummy.php` at repo root:
```php
<?php require_once("required.php");
$a = new Article();
var_dump($a->getCards());
var_dump($a->getFeatured());
var_dump($a->getDetailByFaqId(1));
```
Load it in the browser (or `php test_dummy.php` if DB is configured). You must see the dummy arrays
printed with the exact keys from Section A. Then DELETE `test_dummy.php`.

---

## STEP 2 — Home page (`view/index.html` + `IndexPageController`)

**Goal:** restructure the homepage into: hero card → search → 2 columns (Articles grid + FAQs list).
Reference layout: `.claude/design_handoff_faq_blog_layout/screenshots/home.png`
(**local only — not in the repo**; structure only, keep the current skin).

1. Edit `view/index.html`:
   - Keep the existing header/search markup already produced by `view/header.html`.
   - Build the hero card using existing card styling (`.shadowSm`, rounded container). Put
     `{FEATURED_TITLE}`, an image using `{FEATURED_IMAGE}`, wrapped in a link to `{FEATURED_URL}`.
   - Two-column section: left `Articles`, right `FAQs`. Use CSS grid `2fr 1fr` on desktop,
     `1fr` under 992px (add the rule to `css/style.css`, follow the existing media-query style there).
   - Articles grid: repeatable block `{START_ARTICLE_CARD:00} ... {END_ARTICLE_CARD:00}` with tags
     from Section C1. Style each card with the existing `.resultCard`/`.faqContentListContainer` look.
   - FAQs list: **real data, not stubbed** — reuse the full existing FAQ card component verbatim
     (`.faqContentListContainer.resultCard`, same markup as `view/searchedQuery.html`), wrapped in
     `.faqContentListWrapper.list-view`. Repeatable block `{START_FOR_FAQ_LIST:00} ...
     {END_FOR_FAQ_LIST:00}` with a `{START_TAG_LIST:00}...{END_TAG_LIST:00}` tags sub-block. See
     Section C1 for the full tag list.
2. Edit `page_controller/IndexPageController.class.php`:
   - `$Article = new Article();` → `$featured = $Article->getFeatured();` and
     `$article_cards = $Article->getCards(['limit' => 4]);`
   - `$Faq = new Faq(); $Company = new Company();` → real data, same pattern as the original
     `IndexPageController`/`SearchPageController`: `Faq::getLimitFaqList(['group_by' =>
     'company_id', 'limit' => 5])`, then per row `Company::getCompanyDetails()` +
     `Faq::getFaqCategoryNameByID()` + a tags sub-loop. No dummy branch needed here — this data
     already exists live.
   - Loop `$article_cards` into the `{START_ARTICLE_CARD:00}` block; loop the FAQ rows into the
     `{START_FOR_FAQ_LIST:00}` block — copy the loop mechanics from the existing foreach in this
     same file (and from `SearchPageController` for the tags sub-loop).
   - One final `->replace([...])` mapping all tags. `return ->content(false, true)`.

**CHECK:** Load the site root `/`. You must see: hero card with the featured title + image slot,
the search bar, an Articles grid of 4 cards, and a FAQs list of 5 real (live-DB) FAQ cards — all in the current FAQ2U
skin (cream bg, blue accents, Inter/Gloock). No `{TAGS}` visible on screen.

---

## STEP 3 — Article detail (redesign `view/individualFaq.html` + `IndividualPageController`)

**Goal:** turn the individual FAQ page into the article layout: splash image → 2-column card
(left: article; right: sticky sidebar).
Reference: `.claude/design_handoff_faq_blog_layout/screenshots/article.png` (local only — not in the repo).

1. Edit `page_controller/IndividualPageController.class.php`:
   - Keep the existing 404 guard (`redirectTo404()` when the FAQ is empty).
   - Add `$Article = new Article();` and `$detail = $Article->getDetailByFaqId($faq_id);`
   - Map `$detail` (A4 shape) into the tags in Section C3. Reuse the EXISTING email-loop and tag-loop
     blocks already in this controller (`{START_IF_MULTIPLE_EMAIL}`, `{START_COMPANY_TAG:00}`).
   - Add loops for `body` → `{START_BODY_PARA:00}` and `related_faqs` → `{START_RELATED_FAQ:00}`.
   - Sidebar CTA links:
     `{CTA_COMPANY_FAQS_URL}` = `"../company/{company_id}/{slug}"` (build slug with `Helper::slugifyCompanyName`),
     `{CTA_WEBSITE_URL}` = company website, `{CTA_BACK_URL}` = home (`/..{RYANTEST_FAQ_PATH}`).
   - Keep the existing meta/OG/schema calls at the end of the method.
2. Edit `view/individualFaq.html`:
   - Add splash `{SPLASH_IMAGE}` at top.
   - Two-column card grid `2fr 1fr` (desktop) / `1fr` (mobile). Left = article + company block.
     Right = sidebar using existing `.faqSidebar` / `.sidebarItem` classes, `position:sticky; top:24px`
     on desktop only.
   - **Sticky note:** if the sidebar won't stick, the ancestor must use `overflow: clip` (NOT
     `overflow: hidden` — hidden traps sticky). This is a known rule.

**CHECK:** Load `/id/{a real faq id}`. You must see the splash, the Question/Answer, 3 body
paragraphs, the company block (logo/name/email/address/tags/description), and a sidebar with the 3
CTA buttons + the "Other FAQs from {company}" list. Sidebar sticks on desktop. Current skin intact.

---

## STEP 4 — Blog listing (NEW `blog` route + `BlogPageController` + `view/blog.html`)

**Goal:** a new `/blog` index page with a Grid/List toggle.
Reference: `.claude/design_handoff_faq_blog_layout/screenshots/blog.png` (local only — not in the repo).

1. Add the route in `index.php` `$routes` array (copy the shape of the other entries):
   ```php
   'blog' => [
       'controller' => 'BlogPageController',
       'method' => 'displayBlogPage'
   ],
   ```
2. Create `page_controller/BlogPageController.class.php` — `extends BaseTemplateController`.
   Copy the whole structure from `SearchPageController.class.php` (it already loops article-like cards
   with tags and pagination). Replace its data source with `(new Article())->getCards([...])`.
   Also get `(new Article())->getFeatured()` for the hero.
3. Create `view/blog.html`:
   - Header/hero/search same pattern as `view/index.html`.
   - Grid/List toggle: copy the `.tabWrapper` markup from `view/index.html` (ids `gridViewTab`,
     `listViewTab`) so the existing `initViewTabs()` in `js/script.js` works with no JS changes.
   - Card block `{START_BLOG_CARD:00} ... {END_BLOG_CARD:00}` with the tags in Section C2, including
     the author row (initials circle + `{BLOG_COMPANY_NAME}` + `{BLOG_COMPANY_URL}`), category pill,
     image slot, slug tag + `Read` button, title, excerpt. Reuse existing card classes.
   - Tags sub-block `{START_BLOG_TAG:00} ... {END_BLOG_TAG:00}` → `{BLOG_TAG}`.
4. No new folder is created, so no `.htaccess` needed.

**CHECK:** Load `/blog`. You must see the hero, search, the Grid/List toggle (clicking it switches
columns via the existing JS), and 6–8 blog cards in the current skin. Toggle works. No `{TAGS}` visible.

---

## STEP 5 — Freeze & hand off to backend

1. Re-read `docs/DATA_CONTRACT.md`. Confirm every method in Section B returns the exact Section A keys.
2. Confirm `$USE_DUMMY_DATA = true;` is still set (backend will flip it to false).
3. Confirm no SQL was added to any controller and no data/text is hardcoded in any `view/*.html`.
4. Tell the backend developer: "Fill the real queries inside `Article::getCards`,
   `Article::getFeatured`, `Article::getDetailByFaqId` (and extend `Faq::getLimitFaqList` options if
   needed). Return the keys in `docs/DATA_CONTRACT.md` Section A. Then set `$USE_DUMMY_DATA = false`."

---

## CHANGELOG (append one line per completed step)
- (step 0) Data contract + build steps written.
