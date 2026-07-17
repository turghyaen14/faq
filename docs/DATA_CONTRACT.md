# FAQ2U — Data Contract (Step 0)

**Purpose:** This is the single source of truth for the Home / Blog / Article layout work.
It defines (A) the **dummy-data key schemas**, (B) the **data-access method signatures**
the backend developer will fill in, and (C) the **template placeholder tags** each view uses.

**Roles:**
- **Frontend (you):** build views + controllers + CSS. Fill dummy values into the schemas in Section A.
- **Backend (other dev):** replace the *body* of each method in Section B with real SQL. Return the
  **exact same keys** listed here. Never change method names, params, or return keys.

**Golden rule:** The frontend never reads a raw DB row directly. It only ever reads the keys defined
in this file. If a key is not in this file, it does not exist yet — add it here first, then use it.

---

## The dummy-data toggle

A single global switch decides whether the app serves dummy data or real queries.

- Location: `config/config.php`
- Variable: `$USE_DUMMY_DATA = true;`  *(true = dummy, false = live)*
- Dummy values live in ONE file: `classes/DummyData.class.php` (autoloaded like every other class).
- Each data-access method (Section B) does: **if `$USE_DUMMY_DATA` is true, return the matching
  `DummyData::x()` array; otherwise run the real query.**

Backend flips `$USE_DUMMY_DATA` to `false` (or removes the dummy branch) method-by-method when the
real query is ready. Frontend never has to change.

---

# Section A — Dummy-data key schemas

> For each schema below: copy the JSON template, then generate as many rows as noted using a lower model.
> Keep the **keys exactly as written**. Values are free (fake but realistic).
> Where a value should be empty for now (images we don't have), use an empty string `""`.

## A1. ~~`faqItem`~~ — REMOVED, not stubbed
**Home → FAQs column** uses **real backend data**, not a dummy schema — `Faq::getLimitFaqList()` +
`Company::getCompanyDetails()` already exist and work today, so there's nothing to stub here. See
Section B "Existing methods" and Section C1 for the actual (real) tag names this column uses.

## A2. `articleCard` — blog/article card
Used by: **Home → Articles grid** (4 rows) and **Blog listing** (6–8 rows).

```json
{
  "article_id": 11040,
  "title": "What is Paint Protection Film (PPF)?",
  "slug": "everything-you-need-to-know",
  "category": "Guides",
  "date": "2026-06-12",
  "excerpt": "PPF is a protective film that shields car paint from scratches, chips, stains, and minor damage.",
  "image": "",
  "url": "id/11040",
  "company_id": 28587,
  "company_name": "M8 Car Accessories",
  "company_url": "m8tint.com.my",
  "company_logo": "",
  "company_initials": "M8",
  "tags": ["Services", "Specialist"]
}
```
Generate: **8 rows** → `DummyData::articleCards()`
(Home uses the first 4; Blog uses all.)

| key | type | notes |
|---|---|---|
| `article_id` | int | same as the FAQ id it maps to; link target |
| `title` | string | article headline (may differ from the raw question) |
| `slug` | string | kebab-case, e.g. `"lcd-screen-faqs"` |
| `category` | string | label pill, e.g. `"Guides"`, `"Case Study"` |
| `date` | string | `"YYYY-MM-DD"` |
| `excerpt` | string | 1–2 sentence summary |
| `image` | string | full image URL, or `""` if none yet |
| `url` | string | always `"id/{article_id}"` |
| `company_id` | int | owning company |
| `company_name` | string | author/company display name |
| `company_url` | string | website domain shown under the name |
| `company_logo` | string | full logo URL, or `""` |
| `company_initials` | string | 2 chars for the avatar circle, e.g. `"BX"` |
| `tags` | string[] | category/keyword pills |

## A3. `featured` — hero featured item
Used by: **Home hero** and **Blog hero** (1 object).

```json
{
  "title": "5 Signs Your Business Needs an FAQ Page",
  "image": "",
  "url": "id/11040"
}
```
Generate: **1 object** → `DummyData::featured()`

| key | type | notes |
|---|---|---|
| `title` | string | featured headline shown in the hero card |
| `image` | string | hero/splash image URL, or `""` |
| `url` | string | link target `"id/{id}"` |

## A4. `articleDetail` — full article / individual FAQ page
Used by: **Article detail page** (1 object).

```json
{
  "faq_id": 11040,
  "category": "Everything You Need to Know",
  "question": "What is Paint Protection Film (PPF)?",
  "answer": "PPF is a protective film that shields car paint from scratches, chips, stains, and minor damage.",
  "body": [
    "First paragraph of the long-form article body.",
    "Second paragraph.",
    "Third paragraph."
  ],
  "splash_image": "",
  "company": {
    "company_id": 28587,
    "name": "M 8 CAR ACCESSORIES AND TINTED (M) SDN BHD",
    "emails": ["info@m8car.com.my"],
    "address": "15, Jalan Keruing 1, Taman Rinting, 81750 Masai, Johor, Malaysia.",
    "website": "https://www.m8tint.com.my",
    "map_url": "https://www.google.com/maps/search/?api=1&query=1.49,103.85",
    "logo": "",
    "description": "We provided high-quality & affordable tinted window films...",
    "tags": ["Services", "Specialist"]
  },
  "related_faqs": [
    { "faq_id": 11041, "question": "How long does PPF installation take?", "url": "id/11041" },
    { "faq_id": 11042, "question": "Does PPF affect the factory paint warranty?", "url": "id/11042" }
  ]
}
```
Generate: **1 object** → `DummyData::articleDetail()`

| key | type | notes |
|---|---|---|
| `faq_id` | int | the FAQ this page is for |
| `category` | string | label pill above the question |
| `question` | string | shown as "Question: {question}" |
| `answer` | string | shown as "Answer: {answer}" |
| `body` | string[] | long-form paragraphs (generate 3) |
| `splash_image` | string | hero image URL, or `""` |
| `company.company_id` | int | owning company |
| `company.name` | string | uppercase company legal name |
| `company.emails` | string[] | one or more emails (loop renders each) |
| `company.address` | string | full address |
| `company.website` | string | full URL |
| `company.map_url` | string | google maps link |
| `company.logo` | string | full logo URL, or `""` |
| `company.description` | string | company short-services paragraph |
| `company.tags` | string[] | pill tags |
| `related_faqs[]` | array | other FAQs from same company (generate 4) |
| `related_faqs[].faq_id` | int | link target |
| `related_faqs[].question` | string | shown in sidebar list |
| `related_faqs[].url` | string | always `"id/{faq_id}"` |

---

# Section B — Data-access method contract (backend fills these)

All methods live in `classes/`, follow the existing conventions in
`classes/Faq.class.php` and `classes/Company.class.php`:
`global $conn; global $db_8_np2u;`, escape every input with
`mysqli_real_escape_string($this->conn, htmlspecialchars($x))`, return arrays of associative rows.

Each method's dummy branch returns the matching `DummyData::x()` when `$USE_DUMMY_DATA` is true.

### Existing methods — REUSE (do not rewrite)
| Method | File | Returns | Used by |
|---|---|---|---|
| `Faq::getLimitFaqList($options)` | Faq.class.php:50 | raw ex_faq rows | Home FAQs, Blog list, Search |
| `Faq::getFaqDetailsList($company_id)` | Faq.class.php:12 | raw ex_faq rows | Article → related_faqs |
| `Faq::getFaqDetailsByID($faq_id)` | Faq.class.php:27 | one ex_faq row (+category_name) | Article detail |
| `Faq::getFaqCategoryNameByID($id)` | Faq.class.php:146 | category row | category labels |
| `Faq::getTotalFaqResult($search)` | Faq.class.php:108 | int total | Search pagination |
| `Company::getCompanyDetails($company_id)` | Company.class.php:12 | one company_profile row | all pages |

`getLimitFaqList($options)` accepts these `$options` keys today: `page, start, limit, search,
order_column, order_dir, group_by`. Backend MAY add optional keys **without removing existing ones**:
`category` (filter by category slug/id), `company_id` (filter by company).

### New methods — CREATE as stubs now, backend fills SQL later
> Frontend creates these returning `DummyData::x()`. Return keys MUST match Section A schemas.

| Method | Params | Returns (Section A shape) |
|---|---|---|
| `Article::getCards($options)` | `['limit'=>int,'page'=>int,'search'=>string,'category'=>string,'company_id'=>int]` | array of `articleCard` (A2) |
| `Article::getFeatured()` | none | one `featured` (A3) |
| `Article::getDetailByFaqId($faq_id)` | `int $faq_id` | one `articleDetail` (A4) |

Notes for backend:
- The **source** of "article" fields (`title, slug, category, date, excerpt, image, body`) is a backend
  decision (AI generator `OpenAiArticleGenerator`, a new table, or derived from the FAQ). The frontend
  does not care — it only needs the keys in Section A returned.
- `Article::getDetailByFaqId` should internally reuse `Faq::getFaqDetailsByID`,
  `Company::getCompanyDetails`, and `Faq::getFaqDetailsList` for the company + related_faqs parts, so
  those existing queries are not duplicated.

---

# Section C — Template placeholder tags per view

The controller maps Section A keys → these `{TAG}` names in the view HTML.
Repeatable rows use the existing block convention `{START_X:00} ... {END_X:00}`.

## C1. `view/index.html` (Home)
Hero (from `featured`): `{FEATURED_TITLE}`, `{FEATURED_IMAGE}`, `{FEATURED_URL}`
Articles grid block `{START_ARTICLE_CARD:00}...{END_ARTICLE_CARD:00}` (from `articleCard`):
`{ARTICLE_URL}`, `{ARTICLE_TITLE}`, `{ARTICLE_CATEGORY}`, `{ARTICLE_DATE}`, `{ARTICLE_IMAGE}`
FAQs list block — **real data**, reuses the site's existing full FAQ card component
(`.faqContentListContainer.resultCard`, same markup as `view/searchedQuery.html`), sourced from
`Faq::getLimitFaqList()` + `Company::getCompanyDetails()` + `Faq::getFaqCategoryNameByID()`:
`{START_FOR_FAQ_LIST:00}...{END_FOR_FAQ_LIST:00}`, `{FAQ_ID}`, `{FAQ_QUES}`, `{FAQ_ANS}`, `{FAQ_URL}`,
`{FAQ_COMPANY_PAGE}`, `{COMPANY_NAME}`, `{COMPANY_URL}`, `{COMPANY_LOGO}`, `{CATEGORY_NAME}`, tags
sub-block `{START_TAG_LIST:00}...{END_TAG_LIST:00}` → `{COMPANY_TAG}`.

## C2. `view/blog.html` (Blog listing — NEW)
Grid/List toggle: reuse existing `.tabWrapper` markup from `view/index.html`.
Cards block `{START_BLOG_CARD:00}...{END_BLOG_CARD:00}` (from `articleCard`):
`{BLOG_URL}`, `{BLOG_TITLE}`, `{BLOG_EXCERPT}`, `{BLOG_CATEGORY}`, `{BLOG_SLUG}`,
`{BLOG_IMAGE}`, `{BLOG_COMPANY_NAME}`, `{BLOG_COMPANY_URL}`, `{BLOG_COMPANY_INITIALS}`
Tags sub-block `{START_BLOG_TAG:00}...{END_BLOG_TAG:00}`: `{BLOG_TAG}`

## C3. `view/individualFaq.html` (Article detail — REDESIGN existing)
Splash: `{SPLASH_IMAGE}`
Left column (from `articleDetail`): `{ARTICLE_CATEGORY}`, `{ARTICLE_QUESTION}`, `{ARTICLE_ANSWER}`,
body block `{START_BODY_PARA:00}...{END_BODY_PARA:00}` → `{BODY_PARAGRAPH}`
Company block: `{COMPANY_NAME}`, `{COMPANY_ADDRESS}`, `{COMPANY_WEBSITE}`, `{COMPANY_MAP}`,
`{COMPANY_LOGO_IMAGE}`, `{COMPANY_DESC}`,
emails block `{START_IF_MULTIPLE_EMAIL}...{END_IF_MULTIPLE_EMAIL}` → `{COMPANY_EMAIL}`,
tags block `{START_COMPANY_TAG:00}...{END_COMPANY_TAG:00}` → `{COMPANY_TAG}`
Sidebar CTAs: `{CTA_COMPANY_FAQS_URL}`, `{CTA_WEBSITE_URL}`, `{CTA_BACK_URL}`
Related list block `{START_RELATED_FAQ:00}...{END_RELATED_FAQ:00}`: `{RELATED_FAQ_URL}`, `{RELATED_FAQ_QUESTION}`

---

# Section D — New user-facing copy strings (confirm wording before use)

These labels are new. Do NOT invent wording — use exactly this list (edit here if you want changes):

- Home: `Articles`, `FAQs`, `View all →`
- Blog toggle: `Grid View`, `List View`
- Blog card button: `Read`
- Article sidebar: `Explore More`, `View this company's FAQs`, `Visit Official Website`,
  `Back to All FAQs`, `Other FAQs from {company}`
- Article headings: `Question:`, `Answer:`

If any of these need to change, change them **here first**, then in the views.
