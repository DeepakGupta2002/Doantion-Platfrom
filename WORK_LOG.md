# Donation Platform Work Log

Date: 2026-09-29

## Project Setup

- Created local `.env` from `.env.example`.
- Connected the app to XAMPP MariaDB database `donation_platform`.
- Ran Laravel migrations and seeders.
- Added `storage/installed` so the app boots as installed.
- Verified local app runs at `http://127.0.0.1:8000`.
- Fixed local URL protocol detection in `app/Helpers/Common/Functions/laravel.php` so local HTTP does not get treated as HTTPS.

## Database

- Created and connected database: `donation_platform`.
- Ran all base migrations.
- Seeded admin/site info.
- Admin test login created by seeder:
  - Email: `admin@example.com`
  - Password: `admin123456`

## Google Login

- Wired Google OAuth config to `.env` variables:
  - `GOOGLE_CLIENT_ID`
  - `GOOGLE_CLIENT_SECRET`
  - `GOOGLE_REDIRECT_URI`
- Updated Google Social Auth config so env values can enable Google login.
- Added social-login phone completion flow:
  - New controller: `app/Http/Controllers/Web/Auth/SocialPhoneController.php`
  - New view: `resources/views/auth/social-phone.blade.php`
  - New routes:
    - `GET auth/social/phone`
    - `POST auth/social/phone`
- Updated social login so Google users without verified phone are redirected to phone completion.
- Changed social-user creation so phone is not auto-verified without a phone number.

## Google Maps And Location

- Added Google Maps key to `.env` aliases:
  - `GOOGLE_MAPS_API_KEY`
  - `GOOGLE_MAPS_JAVASCRIPT_API_KEY`
  - `GOOGLE_MAPS_EMBED_API_KEY`
  - `GOOGLE_GEOCODING_API_KEY`
- Added post location confirmation fields:
  - `area`
  - `location_source`
  - `location_confirmed`
  - `location_verified_at`
- New migration:
  - `database/migrations/2026_09_29_000001_add_location_confirmation_fields_to_posts_table.php`
- New helper trait:
  - `app/Services/Post/LocationConfirmationTrait.php`
- Updated post create/update save logic to prefer confirmed GPS/map `lat/lon`, with city coordinates as fallback.
- Added listing form UI:
  - Area/locality input
  - `Use current location` button
  - Google map with draggable/clickable pin
  - Hidden fields for exact coordinates and confirmation status
- Added reusable partial:
  - `resources/views/front/post/createOrEdit/partials/location-confirmation.blade.php`
- Included location confirmation UI in:
  - Single-step create
  - Single-step edit
  - Multi-step create
  - Multi-step edit

## Contact Unlock And Donation Intent

- Added `contact_unlocks` table for tracking contact reveal.
- New migration:
  - `database/migrations/2026_09_29_000002_create_contact_unlocks_table.php`
- New model:
  - `app/Models/ContactUnlock.php`
- Updated phone reveal endpoint:
  - `app/Http/Controllers/Web/Front/Post/Show/ShowController.php`
- New behavior:
  - Guests must login before seeing phone.
  - Logged-in non-owner users must unlock contact first.
  - Optional donation amount is saved as a pledged/skipped unlock record.
  - Same user does not need to unlock the same listing again.
- Added sidebar trust/unlock copy on listing detail page.
- Added page-level JS override on listing detail page to handle unlock prompt and phone reveal.

## Homepage Update

- Converted homepage hero/search copy from generic classifieds to room-focused flow.
- Updated headline:
  - `Room dhoondo ya apna room list karo`
- Updated search placeholders:
  - Room/PG/1RK/1BHK/shared room
  - City/area/college/landmark
- Added homepage CTAs:
  - `Mere paas ke rooms`
  - `Apna room list karein`
- Added popular search chips:
  - PG near me
  - 1RK
  - 1BHK
  - Shared room
  - Under budget
- New partial:
  - `resources/views/front/sections/home/search-form/room-cta.blade.php`
- Updated homepage CSS in:
  - `resources/views/front/common/css/homepage.blade.php`

## Search Empty State

- Replaced generic empty search message with room-focused empty state.
- New empty-state partial:
  - `resources/views/front/search/partials/empty-room-results.blade.php`
- Applied empty state to:
  - Grid results
  - List results
  - Compact results
- New empty state includes:
  - Area/search-specific no-room message
  - `Apna room list karein` CTA
  - `Dusra area search karein` CTA
  - Quick search chips
- Updated bottom search CTA copy from generic selling to room listing.

## Categories

- Added room-focused category tree:
  - `Rooms & PG`
  - `PG`
  - `1RK Rooms`
  - `1BHK Flats`
  - `Shared Rooms`
  - `Single Rooms`
  - `Budget Rooms`
- Rebuilt category nested-set indexes (`lft`, `rgt`, `depth`) so the UI tree renders correctly.
- Made `Rooms & PG` a root category.
- Mapped demo room posts to the new room categories.

## Demo Test Posts

Created/updated demo owner:

- `room-owner-demo@example.test`

Created 6 verified, reviewed, location-confirmed demo listings:

- `1RK room near Vijay Nagar for students`
  - City: Indore
  - Area: Vijay Nagar
  - Category: 1RK Rooms
- `Shared room near Bhawarkua`
  - City: Indore
  - Area: Bhawarkua
  - Category: Shared Rooms
- `Furnished 1BHK near Palasia`
  - City: Indore
  - Area: Palasia
  - Category: 1BHK Flats
- `PG room near MP Nagar`
  - City: Bhopal
  - Area: MP Nagar
  - Category: PG
- `Single room near Freeganj`
  - City: Ujjain
  - Area: Freeganj
  - Category: Single Rooms
- `Budget room near AB Road Dewas`
  - City: Dewas
  - Area: AB Road
  - Category: Budget Rooms

## Verification Done

- PHP syntax checks passed for edited PHP files.
- Migrations ran successfully.
- `php artisan view:cache` passed.
- `php artisan optimize:clear` ran after changes.
- Homepage verified with `200 OK`.
- Login page verified with `200 OK`.
- Search verified:
  - `/search?q=1RK` shows Vijay Nagar test post.
  - `/search?q=shared` shows Bhawarkua test post.
  - `/search?q=PG` returns `200 OK`.
  - `/search?q=NoRoomKeywordXYZ` shows new empty-state CTA.
- Contact unlock controller flow tested with temporary records:
  - First request returns unlock required.
  - Confirmed unlock saves record and reveals phone.
- Category UI verified:
  - Homepage renders `Rooms & PG`, `1RK Rooms`, `PG`.
  - Search renders `Rooms & PG` and matching subcategory.

## Known Existing Notes

- `php artisan route:cache` fails because the app already has duplicate route name `auth.login`. This existed outside the new room/location/contact work and does not block normal local testing.
- Windows sometimes prints `Cannot create a file when that file already exists.` or `locale is not recognized...` during Artisan/PHP runs. The relevant commands still completed successfully.

## Good Next Modules

- Trust score display on listing cards/detail pages.
- Report fake listing/wrong location/broker/scam flow.
- Admin moderation dashboard for reported rooms.
- Search result support for raw unknown areas without 404.
- Real payment gateway integration for donation/contact unlock.

## Rule Files Added

- `PROJECT_RULES.md`
- `IMPLEMENTATION_CHECKLIST.md`
