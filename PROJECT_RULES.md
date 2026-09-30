# Project Rules

## Kya Nahi Karna Hai

- Generic classified marketplace direction me wapas nahi jana. Product focus rooms, PGs, flats and rentals par rahega.
- User ko blank/no-result page nahi dikhana. Empty result me listing CTA, nearby search, ya alert option dena hai.
- Contact details guest ko direct reveal nahi karne. Login/contact unlock flow follow karna hai.
- Social login user ka phone automatically verified mark nahi karna jab phone available na ho.
- Listing location ko sirf city center par silently save nahi karna. User ko current location/map pin confirmation ka option dena hai.
- Random copyrighted production images use nahi karni. Testing ke liye dummy/royalty-free images allowed hain; production me owner-uploaded images honi chahiye.
- Google Maps/API keys ko public docs ya UI me expose nahi karna. `.env` me rakho aur Google Cloud restrictions lagao.
- User ke existing changes revert nahi karne.
- Large unrelated refactors nahi karne. Module-wise small, testable changes karo.
- DB destructive actions (`truncate`, `drop`, mass delete) bina explicit approval ke nahi karne.
- Route/cache build failure ko ignore karke final nahi bolna. Agar existing issue hai to note karna.
- Feature add karne ke baad verification ke bina “done” nahi bolna.

## Product Direction

- Search-first homepage.
- Any-city/any-area support.
- If area has no listings, prompt users to list their room.
- Trust signals important hain:
  - phone verified
  - location confirmed
  - contact unlock history
  - reports/moderation
- Donation/contact unlock is optional-support first, forced payment later only after proper payment gateway integration.
- Categories should remain room-focused:
  - Rooms & PG
  - PG
  - 1RK Rooms
  - 1BHK Flats
  - Shared Rooms
  - Single Rooms
  - Budget Rooms

## Engineering Rules

- Existing Laravel patterns follow karo.
- New modules ke liye migration + model + UI + verification complete karo.
- Reusable Blade partials banao jab same UI multiple views me use ho.
- `.env` secrets final response me full repeat mat karo.
- Temporary scripts allowed hain, but kaam ke baad delete karo.
- After DB/UI changes:
  - run migrations when needed
  - run PHP lint for changed PHP files
  - run `php artisan view:cache`
  - run `php artisan optimize:clear`
  - smoke test local pages with `curl`
