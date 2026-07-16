# FAQ2U — Pre-Deployment Checklist

**Refresh this before every deployment.** These are things that are intentionally NOT in the repo
(secrets, runtime config) or must be toggled before going live.

## 1. Secrets / environment variables
- [ ] **`OPENAI_API_KEY`** — set as a server environment variable. It is NOT stored in the repo.
      `config/config.php` reads it via `getenv('OPENAI_API_KEY')` with an empty fallback.
- [ ] **ROTATE the old key.** A previous OpenAI key (`sk-proj-…`) was once hardcoded in
      `config/config.php` and committed history/local files may retain it. Revoke it in the OpenAI
      dashboard (platform.openai.com → API keys) and issue a fresh one. Never paste it back into a file.
- [ ] **`config/db_connection.php`** — this file is gitignored (holds DB credentials). Create it on the
      server. It must define `$conn` (a `mysqli_connect(...)`) and `$db_8_np2u` (the database name),
      matching how `classes/Faq.class.php` and `classes/Company.class.php` use them.
- [ ] **`ARTICLE_PREVIEW_TOKEN`** (optional) — env var that gates `article_preview.php`. Set it in prod.

## 2. Dummy-data toggle
- [ ] **`$USE_DUMMY_DATA`** in `config/config.php` must be **`false`** in production once the backend
      queries are wired. While it is `true`, the app serves placeholder data (see docs/DATA_CONTRACT.md).

## 3. Runtime folders (must exist + be writable, but are NOT tracked)
- [ ] `cache_object/` — writable (object cache). Only its `.htaccess` is in the repo.
- [ ] `visitor_log/` — writable (visitor logging). Only its `.htaccess` is in the repo.
- [ ] `sitemaps/` — writable (generated sitemaps). Only its `.htaccess` is in the repo.

## 4. Host path check
- `config/config.php` / controllers switch a `/faq` path prefix when
  `HTTP_HOST === 'ryantest.newpages.com.my'` (staging). Confirm the production host does not need this.
