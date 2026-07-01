Last session: refactored HIMLAYAN admin UI from dark navy to white-based theme.

## Done
1. **`tailwind.config.js`** — repurposed `surface.*` tokens for light theme (`base: #f3f4f6`, `card: #ffffff`, `border: #e5e7eb`)
2. **`app.blade.php`** — `bg-gray-50` body, fixed blue top bar + white sidebar layout, toast notifications, sidebar mobile overlay, `lg:pl-64 pt-16` main area
3. **`navigation.blade.php`** — split into:
   - Fixed blue top bar (`bg-brand-blue h-16`) with logo + user dropdown
   - Fixed white sidebar (`w-64 bg-white border-r border-gray-200`) with nav links and section dividers
   - Mobile toggle with overlay
4. **`nav-link.blade.php`** / **`responsive-nav-link.blade.php`** — sidebar-style: `flex items-center gap-3 px-3 py-2 rounded-lg`, active state: `text-brand-blue bg-brand-blue/10 border-l-4 border-brand-blue`
5. **`dropdown.blade.php`** — light theme (`bg-white` content)
6. **`dropdown-link.blade.php`** — `text-gray-700 hover:bg-blue-50 hover:text-brand-blue`
7. **`primary-button.blade.php`** — `bg-brand-blue`, `focus:ring-brand-blue`
8. **`secondary-button.blade.php`** — `bg-white border border-gray-300`, `focus:ring-brand-blue`
9. **`danger-button.blade.php`** — `rounded-lg` consistency
10. **`modal.blade.php`** — `bg-white rounded-xl`, `bg-gray-500/75` backdrop
11. **`text-input.blade.php`** — `focus:border-brand-blue focus:ring-brand-blue`
12. **`input-label.blade.php`** — `text-gray-700`
13. **`input-error.blade.php`** — `text-red-600`
14. **`guest.blade.php`** — `bg-gray-50` background, white card
15. **`dashboard.blade.php`** — page title with yellow divider (`border-b-2 border-brand-yellow w-12`)
16. **`dashboard/super-admin.blade.php`** — all cards white with blue numbers, icon badges in `bg-brand-blue/10` circle, one yellow-accent card (`border-t-4 border-brand-yellow`), semantic badges using inline colors, no gradients
17. **`dashboard/rcc-staff.blade.php`** — same pattern
18. **`dashboard/engr.blade.php`** — same pattern
19. **All 42 CRUD views** (`index`, `create`, `edit`, `show` across 14 directories) — bulk-updated: `bg-surface-card` → `bg-white rounded-xl shadow-sm border border-gray-100`, `text-gray-100` → `text-gray-900`, `text-gray-300` → `text-gray-700`, `text-gray-400` → `text-gray-500`, `hover:text-brand-blue-light` → `hover:text-brand-blue-dark`, inline badges updated to `bg-green-100 text-green-700` etc.

## Remaining
- `cemetery/admin.blade.php` is a Leaflet GIS tool with its own inline styles — left as-is (not part of admin CRUD theming)
- `layouts/public.blade.php` is the public-facing layout (`bg-stone-50`) — left as-is (separate from admin)

## Verified
- `npm run build` passes clean (53KB CSS, 45KB JS)
