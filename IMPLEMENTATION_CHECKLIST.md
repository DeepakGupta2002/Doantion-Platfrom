# Implementation Checklist

Use this file before starting and before finishing every module.

## Before Starting

- Read `PROJECT_RULES.md`.
- Identify which module is being changed:
  - homepage
  - search
  - listing create/edit
  - listing detail
  - auth/login
  - contact unlock/donation
  - categories
  - admin/moderation
- Check existing code pattern before editing.
- Prefer current Laravel services, models, Blade partials and routes.
- Decide expected test URL or command before implementing.

## While Implementing

- Keep changes small and module-specific.
- Add database migrations instead of manually changing schema only.
- Use reusable partials for repeated UI.
- Do not hardcode only Indore; support any city/area.
- Keep user-facing copy room/rental focused.
- For empty states, always provide a next action.
- For contact details, enforce login/unlock.
- For location, keep city fallback but prefer confirmed GPS/map location.

## Before Final Response

- Run PHP syntax check for changed PHP files.
- Run migrations if migration added.
- Run `php artisan view:cache` after Blade edits.
- Run `php artisan optimize:clear`.
- Smoke test key pages:
  - `/`
  - `/search?q=PG`
  - `/search?q=NoRoomKeywordXYZ`
  - `/auth/login`
- If test posts are expected, verify them in DB and search result.
- Delete temporary helper scripts.
- Mention any known existing issue separately.

## Standard Verification Commands

```powershell
php artisan migrate --force
php artisan view:cache
php artisan optimize:clear
curl.exe -I http://127.0.0.1:8000/
curl.exe -I "http://127.0.0.1:8000/search?q=PG"
curl.exe -s "http://127.0.0.1:8000/search?q=NoRoomKeywordXYZ" | findstr /C:"Apna room list"
```
