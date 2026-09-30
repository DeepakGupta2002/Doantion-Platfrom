🏠 No Broker Room Finder Platform

(Functional Requirements & System Logic)

🎯 1. Platform Goal

Platform ka main goal hai:

Broker-free room discovery system banana

Tenants (jo room chhod rahe hain) directly listing kare

Users bina brokerage ke room find kare

Trustworthy, real aur updated listings hi show ho

📍 2. Launch Scope (Phase 1)

Initial launch: Indore city only

Specific areas:

Vijay Nagar

Bhawarkua

Palasia

etc.

👉 Future me multi-city expansion

👤 3. User System

✔ Single User Type:

Koi alag roles nahi honge

Har user:

Listing bhi kar sakta hai

Rooms search bhi kar sakta hai

🔐 Registration Rule:

Registration compulsory hoga sirf tab jab user contact dekhna chahe

Login via:

Mobile number

OTP verification

🏠 4. Room Listing System

✔ Kaun listing karega:

Sirf tenant (jo currently reh raha hai)

✔ Listing fields:

Title

Rent

Location (map-based)

Area (e.g. Vijay Nagar)

Room type (1RK / 1BHK / PG)

Leaving date

Available from

Description (real experience)

Images (minimum 2)

✔ Listing Status:

Active

Filled

Expired

✔ Auto Expiry:

Leaving date ke baad listing automatically expire ho jayegi

🔍 5. Filtering System

✔ Filters:

Location (Indore areas)

Budget range

Room type

Available date

“Leaving Soon” (within 3 days)

✔ Sorting:

Nearby first

High trust score

Latest listing

📍 6. Auto Location Detection

✔ Flow:

Website open hote hi:

User se location permission li jayegi

Latitude/Longitude fetch hoga

Nearby listings show honge

✔ Fallback:

Agar user location allow nahi karta:

Default: Indore

Area select option

🔐 7. Validation System

✔ Listing Validation Rules:

Title minimum 10 characters

Description minimum 30 characters

Minimum 2 images required

Location mandatory (map-based)

Leaving date future me hona chahiye

User phone verified hona chahiye

✔ Duplicate Prevention:

Same user same location + rent duplicate post nahi kar sakta

✔ Spam Control:

Per user limit: 2 listings per day

🧠 8. Trust System

✔ Trust Score Calculation:

Phone verified → +20

Images ≥ 3 → +20

Location verified → +20

Recent update → +20

No reports → +20

✔ Listing Visibility:

Sirf wahi listing show hogi jo:

Active ho

Flagged na ho

Leaving date valid ho

🚫 9. Report System

✔ Users report kar sakte hai:

Fake listing

Duplicate

Already filled

✔ Rule:

3+ reports → listing hide ho jayegi

❤️ 10. Donation System

✔ Purpose:

Platform ko support karne ke liye optional donation

✔ Flow:

User “View Contact” click kare

Donation popup show ho:

₹20 / ₹50 / Skip

✔ Important:

Donation optional hoga

Skip karne par bhi contact show hoga

🔐 11. Contact Unlock Flow

✔ Steps:

User “View Contact” click kare

Donation popup show

Agar user login nahi hai:

Register (mobile OTP)

Contact unlock

✔ Rule:

Ek baar unlock hone ke baad dubara popup nahi

🎨 12. User Experience (UX)

✔ Focus:

Simple

Fast

Clean

✔ UX Flow:

User website open kare

Nearby rooms show

Filter apply kare

Room detail open kare

Contact click kare

Donation popup

Register (OTP)

Contact unlock

🔥 13. SEO System (Most Important)

✔ Auto SEO Generation:

Har listing ke liye system automatically generate kare:

🔑 SEO Title:

Example:
“1RK Room in Vijay Nagar Indore | Rent ₹5000 | No Broker”

🔑 SEO Description:

“Find 1RK room in Vijay Nagar, Indore. Direct from tenant. No brokerage.”

🔑 SEO Keywords:

room in indore

pg in vijay nagar

no broker room

✔ SEO URL:

/room/1rk-room-vijay-nagar-indore-5000

⚙️ 14. Permissions

✔ User kar sakta hai:

Apni listing create kare

Edit kare

Delete kare

Mark as filled

❌ User nahi kar sakta:

Dusre ki listing edit

Fake data submit

Unlimited spam

🚀 15. Final System Output

Platform ensure karega:

Sirf valid listings show ho

Fake listings filter ho

User trust high ho

Smooth experience mile

🏁 Conclusion

Ye platform ek simple but powerful no-broker ecosystem create karega jisme:

Real tenants → listing karenge

Real users → directly connect karenge

Platform → trust + validation + SEO se grow karega


