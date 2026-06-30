# LibingGuide — UI View Files & Components

> **Project:** HIMLAYAN (Laravel + Blade + Tailwind CSS + Alpine.js)
> **Total view/template files:** 93

---

## 1. Layouts (`resources/views/layouts/`)

### `app.blade.php`
Main authenticated layout (admin panel shell).
- **Head:** Meta tags, CSRF, favicon, title, Google Fonts (Figtree), Vite CSS/JS, custom badge styles (`.badge-success`, `.badge-pending`, `.badge-danger`, `.badge-default`)
- **Alpine.js Toast Notification:** Fixed top-right toast with success/error icon, auto-dismiss (4s)
- **`@include('layouts.navigation')`** — Admin top nav bar
- **`{{ $slot }}`** — Main content area
- **Footer:** "HIMLAYAN — Solano, Nueva Vizcaya" centered
- **Stacks:** `@stack('head')`, `@stack('scripts')`
- **Modals/Dialogs:** Toast only (inline Alpine)
- **Components used:** `<x-application-logo />`, `<x-nav-link />`, `<x-dropdown />`, `<x-dropdown-link />`, `<x-responsive-nav-link />`

### `guest.blade.php`
Wrapper for auth pages (extends `layouts.public`).
- **Layout:** Centered card on public shell
- **Card:** `bg-white rounded-2xl shadow-xl p-8`
- **`{{ $slot }}`** — Auth form content
- **Background:** Full screen flex column centered

### `navigation.blade.php`
Admin top navigation bar with role-based menus.
- **Desktop Nav:** Logo + nav links (Dashboard, Clients, Lots & Burials, Permits, Contracts & Billing)
- **Services Dropdown (hover):** Pre-Need Plans, Columbary Niches, Legacy Map, Cemetery Map, Pathways (role-gated)
- **Map Dropdown (engr):** Cemetery Polygons, Burial Plotting & Blocks, Map Pathing
- **User Dropdown (right):** Profile, Log Out
- **Mobile Menu (hamburger):** Same links in vertical layout
- **Components used:** `<x-application-logo />`, `<x-nav-link />`, `<x-dropdown />`, `<x-dropdown-link />`, `<x-responsive-nav-link />`

### `public.blade.php`
Public-facing layout (used by welcome, lots, plans, etc.).
- **Head:** Meta, CSRF, favicon, Google Fonts (Figtree 400-800), Vite assets
- **`@include('partials.public-nav')`** — Public navigation bar
- **`@yield('content')`** — Page content
- **`@include('partials.public-footer')`** — Public footer
- **Scripts:** Alpine.js CDN (3.x) + `@stack('scripts')`
- **Note:** No custom badge styles (vs app layout)

---

## 2. Auth (`resources/views/auth/`)

### `login.blade.php`
Login form page.
- **`<x-guest-layout>`** — Centered card layout
- **`<x-auth-session-status />`** — Session status display
- **Form:** POST to `login`
- **Components:** `<x-input-label for="email" />`, `<x-text-input id="email" />`, `<x-input-error />`, `<x-primary-button />`
- **Remember me checkbox:** Inline styled checkbox with label
- **Forgot password link:** Underline text link
- **Visual:** Indigo accent (focus ring, checkbox color), shadow card

### `register.blade.php`
User registration form.
- **`<x-guest-layout>`** — Centered card layout
- **Form:** POST to `register`
- **Components:** `<x-input-label />` (name, email, password, confirm), `<x-text-input />`, `<x-input-error />`, `<x-primary-button />`
- **Already registered link:** Underline text link to login
- **Visual:** Indigo accent, shadow card

### `forgot-password.blade.php`
Password reset request form.
- **`<x-guest-layout>`** — Centered card layout
- **Info text:** "Forgot your password?..." paragraph
- **`<x-auth-session-status />`** — Session status
- **Form:** POST to `password.email`
- **Components:** `<x-input-label for="email" />`, `<x-text-input />`, `<x-input-error />`, `<x-primary-button />`
- **Visual:** Indigo accent

### `reset-password.blade.php`
New password submission form.
- **`<x-guest-layout>`** — Centered card layout
- **Hidden token field**
- **Form:** POST to `password.store`
- **Components:** `<x-input-label />` (email, password, confirm), `<x-text-input />`, `<x-input-error />`, `<x-primary-button />`
- **Visual:** Indigo accent

### `confirm-password.blade.php`
Confirm password for sensitive actions.
- **`<x-guest-layout>`** — Centered card layout
- **Info text:** "This is a secure area..." paragraph
- **Form:** POST to `password.confirm`
- **Components:** `<x-input-label for="password" />`, `<x-text-input />`, `<x-input-error />`, `<x-primary-button />`

### `verify-email.blade.php`
Email verification prompt.
- **`<x-guest-layout>`** — Centered card layout
- **Info text:** Verification instructions
- **Success message:** Conditional green notification
- **Forms:** Resend verification email + Log Out button
- **Components:** `<x-primary-button />`

---

## 3. Public Pages (`resources/views/public/`)

### `columbarium.blade.php`
Coming soon page for columbarium.
- **Full-screen dark section** (`bg-gray-900 text-white`)
- **Icon:** Clock SVG in emerald-tinted circle
- **Headline:** "Coming Soon"
- **Subhead:** "Heritage Columbarium"
- **Body text:** Development notice
- **Layout:** Centered content, max-w-2xl

### `confirmation.blade.php`
Post-reservation success page.
- **Success alert:** Green banner (conditional)
- **Checkmark card:** White card with green checkmark circle
- **Headline:** "Thank You!"
- **Body text:** Confirmation message (24hr contact)
- **Buttons:** "Return to Home" (emerald filled), "Browse More Lots" (emerald outlined)

### `find.blade.php`
Interactive cemetery map for public to find deceased.
- **Leaflet Map** (`#map`): Full-screen map with cemetery polygon overlay
- **Search Box** (`#searchBox`): Centered top search with dropdown results
- **Results Dropdown:** Shows matching deceased names with plot info
- **Detail Panel** (`#detailPanel`): Bottom slide-up panel showing:
  - Deceased name, section, plot number
  - "Show Path" button (directions from entrance)
  - Path distance & walk time
- **Highlighted Marker:** Green pulsing marker on selected grave
- **Path Rendering:** Orange dashed polyline from entrance to grave
- **Entrance Marker:** Green pill label at cemetery entrance
- **Libraries:** Leaflet, Turf.js
- **Data loading:** Fetches cemetery polygon + public markers

### `lots.blade.php`
Browse available memorial lots with map.
- **Header:** Title + description + info banner (amber) linking to plans
- **Sidebar (`lg:col-span-1`):**
  - "Available Lots" heading
  - Scrollable list of plot entries (number, price, section)
  - "Reserve a Lot" CTA button
- **Map (`lg:col-span-2`):**
  - Leaflet map (Google Satellite tiles)
  - Color-coded polygons/markers (green=available, yellow=reserved, red=occupied)
  - Clickable plots with popups (number, section, status, price)
  - Sync: clicking a lot in sidebar flies map to it
- **Libraries:** Leaflet

### `plan-detail.blade.php`
Single pre-need plan detail page.
- **Back link:** "Back to Plans" with arrow
- **White content card:**
  - Optional plan image (full width, 256px height)
  - Type badge (emerald) + "Pre-Need Plan" badge (blue)
  - Plan name (h1), description (text-lg)
  - "What's Included" section: 2-column grid of features with checkmarks
  - Price block: "Plan Price" label + price in emerald
  - "Apply for This Plan" button (emerald filled with arrow)

### `plans.blade.php`
Browse all pre-need plans.
- **Header:** Title + description + info banner (amber) linking to lots
- **Grouped by type:** Each type (burial, funeral, memorial) in its own section
- **Plan cards (grid md:2 lg:3):**
  - Image or gradient placeholder
  - Name, description, feature preview (up to 4, with "+N more")
  - Price + type badge
  - "View Details" link
  - Hover shadow effect, flex column layout
- **Empty state:** "No plans available"

### `reserve-form.blade.php`
Online reservation/inquiry form.
- **Dynamic heading** based on type (lot/columbary/plan)
- **Error alert** (conditional red banner)
- **Map section (for lots only):** Leaflet map with click-to-select markers
- **Form card:**
  - Full Name, Contact Number, Email, Address (text inputs)
  - Select dropdowns: Lot / Niche / Plan (dependent on type)
  - Additional Message (textarea)
  - Submit button (emerald, full width)
- **Map marker selection:** Clicking a marker selects the plot in the dropdown and flies to it
- **Libraries:** Leaflet, Google Satellite tiles

---

## 4. Dashboard (`resources/views/dashboard/`)

### `dashboard.blade.php`
Role-routing hub (switch-case).
- **Wrapper:** `<x-app-layout>`
- **Includes:** Delegates to role-specific dashboard partial
  - `super_admin` → `dashboard.super-admin`
  - `engr` → `dashboard.engr`
  - default → `dashboard.rcc-staff`

### `super-admin.blade.php`
Super admin dashboard with 4+ stat card groups.
- **Row 1 (4 cards):** Total Plots (with avail/reserved/occupied counts), Occupancy Rate (with progress bar), Total Revenue, Pending Physical Signatures (Treasurer + Mayor)
- **Row 2 (4 cards):** Upcoming Burials, Burial Permits Issued, New Inquiries, Pre-Need Plans (with "Manage" link)
- **Row 3 (4 cards):** Available Niches, Active Contracts, Unread Notifications, Activity Logs
- **Row 4 (2 cols):** Recent Burials (list with status badges), Recent Payments (list with amounts)
- **Row 5 (2 cols):** Notifications (with type icons, unread highlight), Recent Activity (with type icons)
- **Row 6 (conditional 2 cols):** Overdue Installments (red left border), Upcoming Installment Due Dates (amber left border)
- **Empty states:** "No burials/payments/notifications/activity recorded yet."
- **Status badges:** `bg-green-100` (completed/active), `bg-blue-100` (scheduled/issued), `bg-gray-100` (default)
- **Progress bar:** Inline h-2 rounded-full
- **Links:** "View all" / "Manage" links to related pages

### `rcc-staff.blade.php`
RCC Staff dashboard (subset of super admin).
- **Row 1 (4 cards):** Total Plots, Occupancy Rate, Total Revenue, Upcoming Burials
- **Row 2 (4 cards):** New Inquiries, Burial Permits Issued, Pending Signatures, Unread Notifications
- **Row 3 (3 cols):** Recent Burials, Recent Payments, Notifications
- **Row 4 (conditional):** Overdue/Upcoming Installments
- Same visual patterns as super-admin

### `engr.blade.php`
Engineer dashboard (focus on map/burials).
- **Row 1 (4 cards):** Total Plots, Occupancy Rate, Map Capacity (with Cemetery Map link), Upcoming Burials
- **Row 2 (4 cards):** Active Contracts, Burial Permits Issued, New Inquiries, Unread Notifications
- **Row 3 (2 cols):** Recent Burials, Recent Payments
- No installments section (engineers don't handle billing)

---

## 5. CRUD Resources

### Clients

#### `index.blade.php`
Client list with search.
- **Header:** "Clients" title + count + search input + "Add Client" button
- **Table columns:** Name (linked), Contact, ID Type, Contracts count, Actions (Edit, Delete)
- **Client-side search:** Filters by name or contact (JS)
- **Delete confirmation:** Confirm dialog with dynamic form submission
- **Empty state:** Person icon + "No clients yet" + call-to-action button

#### `create.blade.php`
Add client form.
- **Form fields:** Full Name, Contact Number, Email, Address, ID Number (text), ID Type (select: PhilSys/Passport/UMID/Driver's License/Others)
- **Actions:** Cancel link + Save button (indigo)

#### `edit.blade.php`
Edit client form.
- Same fields as create but pre-populated with `$client` data
- PUT method

#### `show.blade.php`
Client detail view.
- **Info grid (2-col):** Full Name, Contact, Email, ID Type+Number, Address
- **Action links:** Edit, Delete (with confirm)
- **Contracts list** (if any): Border cards with contract ID, plot, amount, status badge, date

### Burials

#### `index.blade.php`
Burial list with search.
- **Header:** "Burials" title + count + search input + "Deceased Registry" link + "Schedule Burial" button
- **Table columns:** Deceased Name (linked), Plot, Client, Date, Status (colored badge with dot), Actions (Approve, Edit, Delete)
- **Client-side search:** Filters by deceased name or plot
- **Approve action:** PATCH form for scheduled → completed
- **Empty state:** Cross icon + "No burials recorded"

#### `create.blade.php`
Schedule burial form.
- **Fields:** Deceased Name, Plot (select with occupant count), Contract (select), Date of Birth, Date of Death, Burial Date & Time, Status (scheduled/completed/cancelled), Notes
- **Select options:** Show plot numbers with occupant info

#### `edit.blade.php`
Edit burial form.
- Same fields as create, pre-populated

#### `show.blade.php`
Burial detail view.
- **Info grid (2-col):** Deceased Name, Plot (linked), DOB, DOD, Burial Date, Status badge, Scheduled By, Approved At, Notes
- **Action links:** Edit, Approve, Delete
- **Contract section:** Linked contract
- **Map:** Leaflet map with plot marker (300px height)
- **Libraries:** Leaflet

### Burial Permits (AF 58)

#### `index.blade.php`
Permit list with search.
- **Header:** "Burial Permits (AF 58)" + count + search + "Issue Burial Permit" button
- **Table columns:** Permit # (mono font), Deceased, Client, Date Issued, Fee, Status badge (issued/used/cancelled), Actions
- **Search:** Filters by deceased name or permit number

#### `create.blade.php`
Issue burial permit form.
- **Fields:** Contract (select populates client/plot), Deceased Name, DOB, DOD, Death Certificate #, Fee, Notes

#### `edit.blade.php`
Edit permit form.
- Same fields + Status select (issued/used/cancelled)

#### `show.blade.php`
Permit detail view.
- **Dashed-border card:** Permit # (large mono), Deceased, DOB/DOD, Death Cert #, Client, Plot, Fee, Status, Issued By, Issued At
- **Notes section** (conditional)
- **Actions:** Edit, View Contract, Delete

### Contracts

#### `index.blade.php`
Contracts list with search.
- **Header:** "Contracts & Billing" + count + search + "View Payments" link + "New Contract" button
- **Table columns:** Client (linked), Service (plot/niche/plan), Type (lot type + contract type), Date, Amount, Payment, Signatories (3-dot workflow), Status badge, Actions
- **Signatories workflow:** 3 dots (Prepared → Treasurer → Mayor) with green/gray fill
- **Search:** Filters by client name

#### `create.blade.php`
New contract form — complex with product type toggle.
- **Product Type selector:** Lot (default), Columbary Niche, Pre-Need Plan
- **Lot fields** (shown when "lot" selected):
  - Plot select + Lot Type (individual/family)
  - Lease Type (new/renewal) with toggle
  - Renewal fields: Ordinance Period select (pre-2002/2002-2013/2013-present), Lot Area
  - Dimension, Commencement Date, Expiration Date
  - **Rental Fee Computation:** Live AJAX calculator with "Apply to Total Amount" button
- **Columbary Niche fields:** Niche select with price
- **Pre-Need Plan fields:** Plan select with price
- **Common fields:** Contract Date, Total Amount, Payment Type (cash/credit/installment), Installment months
- **AF 51 section:** Official Receipt # + Date, Death Certificate #
- **Client-side JS:** Product type toggling, installment field toggle, lease type toggle, rental computation (fetch with CSRF)

#### `edit.blade.php`
Edit contract form.
- Same fields as create (simplified, no product type toggle)
- PUT method

#### `show.blade.php`
Contract detail view — the most complex CRUD view.
- **Info grid (2-col):** Client (linked), Plot (linked), Lot Type, Lot Area, Dimension, Lease Type, Commencement, Expiration, Rental Breakdown (if renewal), Niche, Plan, Date, Total Amount, Payment Type, Status badge
- **Signatory Workflow:** Step-by-step visual (Prepared → Treasurer → Mayor) with verification buttons
- **AF 51 / Documents:** Receipt #, Date, Death Certificate #
- **Action links:** Edit, Download PDF, Delete
- **Installment Schedule table** (if any): Due Date, Amount Due, Amount Paid, Status badge
- **Payments table** (if any): Date, Amount, Type, Reference, Receipt
- **Burial Permits list** (if any): Border cards with permit #, status badge
- **Send Notification form:** Subject + Message + Channel (In-App/Email) + Send button
- **Notification History list:** Via channel, timestamps
- **Burials list** (if any): Deceased name, status, date

#### `pdf.blade.php`
Printable contract PDF (not a UI view per se, but renders for download).
- **Print styles:** Figtree font, 14px body, centered headings
- **Sections:** Contract header "HIMLAYAN", Client Information table, Service Details table, Installment Schedule table (if any), Payment History table (if any)
- **Signature area:** Client + Representative signature lines
- **Footer:** Address + computed-generated notice
- **No Tailwind** — uses raw CSS for print

### Payments

#### `index.blade.php`
Payments list.
- **Table columns:** Receipt #, Client (linked), Plot, Amount, Type, Date, Delete action

#### `create.blade.php`
Record payment form.
- **Fields:** Contract (select), Amount Paid, Payment Type (cash/credit/installment), Reference #, Receipt #, Payment Date, Notes

#### `show.blade.php`
Payment detail view.
- **Info grid:** Client, Plot, Amount Paid, Type, Reference, Receipt, Date, Notes
- **Delete action**

### Plots

#### `index.blade.php`
Burial plotting & blocks map interface.
- **Sidebar (320px):**
  - Search input (plot number or section)
  - Legend badges (Available/Reserved/Occupied/Full)
  - Scrollable plot list with colored status badges, section, lot type, dimension, burial count
- **Main map:** Leaflet with 3 tile layers (Satellite, OSM, Custom cemetery tiles)
  - Cemetery boundary polygon
  - Editable shapes via Leaflet.Draw (draw, edit)
  - Color-coded by status
  - Click synced with sidebar list
- **Draw Form Modal:** Inline modal for creating new plots on the map
  - Fields: Plot Number, Section, Lot Type, Dimension, Capacity, Price, Status, Notes
  - Boundary validation (must be inside cemetery)
- **Libraries:** Leaflet, Leaflet.Draw, Turf.js

#### `create.blade.php`
Add plot form with map drawing.
- **Map side (lg:col-span-3):** Leaflet map with draw tools (rectangle/polygon), boundary validation, transform handles (rotate/scale)
- **Form side (lg:col-span-2):**
  - Hidden fields for lat/lng/shape (populated on draw confirm)
  - Fields: Plot Number, Section, Lot Type, Dimension, Capacity, Price, Status, Notes
  - Centroid display (lat/lng read-only)
  - Submit button (disabled until shape confirmed)
- **JavaScript:** PathTransform for rotation/scaling, Turf for centroid, boundary checking, confirm shape flow
- **Libraries:** Leaflet, Leaflet.Draw, Leaflet.PathTransform, Turf.js

#### `edit.blade.php`
Edit plot form.
- Same layout as create with existing shape pre-loaded
- Shape input populated from `$plot->shape`
- Fallback to circleMarker if no shape exists
- No boundary alert (just hides on invalid)

#### `show.blade.php`
Plot detail view.
- **Info grid (2-col):** Plot Number, Section, Lot Type, Dimension, Coordinates, Status, Capacity, Occupants, Price
- **Notes section** (conditional)
- **Actions:** Edit, Delete
- **Map:** Leaflet with shape/pin + cemetery boundary
- **Burials in this plot table** (if any): Name, Date, Status

### Pre-Need Plans

#### `index.blade.php`
Pre-need plans list.
- **Table columns:** Name (linked), Type badge, Price, Status (active/inactive with dot), Actions

#### `create.blade.php`
Create plan form.
- **Fields:** Name, Type (Burial/Funeral/Memorial), Price, Description, Features (one per line), Image URL, Active checkbox

#### `edit.blade.php`
Edit plan form.
- Same fields as create, pre-populated

#### `show.blade.php`
Plan detail view.
- **Header:** Type badge + Active/Inactive badge + Price
- **Description** + **Features list** (bullet)
- **Actions:** Edit, Delete
- **Contracts table** (if any): Client, Date, Amount, Status

### Columbary Niches

All 4 views are **"Coming Soon"** placeholders — identical amber "under development" cards.

### Inquiries

#### `index.blade.php`
Inquiries list.
- **Table columns:** Name (linked), Contact, Lot Interest, Status badge (new/contacted/closed), Date, Actions

#### `create.blade.php`
Create inquiry form (admin-side).
- **Fields:** Full Name, Contact Number, Email, Address, Lot Interest (select: Garden/Family Estate/Lawn/Columbarium), Message

#### `show.blade.php`
Inquiry detail view.
- **Info grid:** Name, Contact, Email, Lot Interest, Status badge, Date
- **Address + Message** sections (conditional, message in gray card)
- **Status update form:** Select + button to update (new/contacted/closed)
- **Delete action**

---

## 6. Misc Entity Views

### `activity_logs/index.blade.php`
Activity log list.
- **Timeline list:** Colored dots (red=burial, green=payment, blue=contract, yellow=plot, gray=other)
- **Each item:** Description, timestamp, user, type badge
- **Pagination:** `$logs->links()`

### `burial/index.blade.php` (Legacy)
Legacy burial spots with SVG map.
- **Sidebar (300px):** Search, scrollable spot list with colored status badges
- **SVG Map Canvas** (`#map-svg`): ViewBox 520x380, markers layer for positions
- **Modal:** `@include('burial._modal')`
- **JS map.js:** External script for SVG marker rendering + position saving

### `burial/_modal.blade.php`
Legacy modal for adding burial spots.
- **Modal overlay (fixed):** White card, 400px max
- **Form fields:** Name, Plot Number, Section, Birth Year, Death Year, Status, Notes
- **Buttons:** Cancel + Save (blue)

### `cemetery/admin.blade.php`
Cemetery administration — polygon editing.
- **Cemetery Selector:** Dropdown + create new field + current label
- **Leaflet Map** (full height): Polygon drawing by clicking vertices
- **Control bar:** Point count, area display, Finish Polygon, Clear All
- **Side panel (280px):**
  - Coordinates list (ordered, removable)
  - Save/Load buttons with spinners
  - Export/Import (GeoJSON)
  - Quick Actions: Seed Graves, Manage Graves
- **Grave Manager Modal:** Search + list of graves with name, plot, coordinates
- **Libraries:** Leaflet, Turf.js

### `client-notifications/index.blade.php`
Sent client notifications log.
- **Table columns:** Client, Type badge, Subject (truncated), Channel badge, Status badge, Sent At
- **Pagination**

### `deceased/index.blade.php`
Deceased registry.
- **Table columns:** Deceased Name, DOB, DOD, Plot (+ section), Client, Source badge (Burial Record/Death Certificate)
- **Search by name**

### `notifications/index.blade.php`
Internal system notifications.
- **Header:** Count + "Mark all as read" button
- **Timeline list:** Colored dots (blue=burial, yellow=due, red=overdue, gray=other) with unread ring highlight
- **Each item:** Title, body, timestamp, "View details" link (if any), "Mark read" button (if unread)
- **Pagination**

### `paths/index.blade.php`
Map pathing (roads/walkways) — graph editor.
- **Sidebar (300px):** `@include('paths._sidebar')`
- **Leaflet Map:** Google Satellite tiles
- **Graph rendering:** Edges (gray lines) + Nodes (colored circles: green=entrance, blue=waypoint, purple=facility, orange=section)
- **4 Modes:** View, Add Node, Add Edge, Draw Path
  - Add Node: Click on map, prompt for name/type
  - Add Edge: Click two nodes to connect
  - Find Path: Select start/end nodes → orange dashed path rendered
- **Sidebar panels:** Node/Edge forms, Path finder, Stats, Export/Import, Reset
- **Keyboard shortcuts:** 1=View, 2=Node, 3=Edge, 4=Draw, Enter=Find Path
- **Libraries:** Leaflet

### `welcome.blade.php`
Public landing/home page — full marketing page.
- **Hero Section:** Full-screen background image, overlay gradient, HIMLAYAN badge, headline, CTA buttons (Browse Lots, Learn More, Inquire Now), bounce-down arrow
- **About Section:** Two-column (text + image with floating stat card). 3 stat counters (50+ years, 500+ families, 100% care)
- **Memorial Lots Section:** 3 card grid (Garden, Family Estates, Lawn Lots) with images, descriptions, "Browse" CTAs
- **Columbarium Section:** Dark background, image overlay, "Coming Soon" badge, description, disabled button
- **Inquire/Reserve Section:** Two-column (contact info + inquiry form). Form with Alpine.js toggle for lot picker, inquiry type radio, full fields
- **Careers Section:** Image + "We're Hiring" floating badge, Sales Counselor callout, "Apply Now" CTA

---

## 7. Profile (`resources/views/profile/`)

### `edit.blade.php`
Profile page.
- **3 sections in white cards:**
  1. `partials.update-profile-information-form`
  2. `partials.update-password-form`
  3. `partials.delete-user-form`

### `partials/update-profile-information-form.blade.php`
- **Section header:** Title + description
- **Form:** Name, Email (with unverified email resend link)
- **Auto-disappear "Saved." confirmation** (Alpine.js, 2s)
- **Components:** `<x-input-label />`, `<x-text-input />`, `<x-input-error />`, `<x-primary-button />`

### `partials/update-password-form.blade.php`
- **Section header:** Title + description
- **Form:** Current Password, New Password, Confirm Password
- **Auto-disappear "Saved." confirmation**
- **Components:** `<x-input-label />`, `<x-text-input />`, `<x-input-error />`, `<x-primary-button />`

### `partials/delete-user-form.blade.php`
- **Section header:** Title + warning description
- **`<x-danger-button />`** Triggers modal
- **`<x-modal name="confirm-user-deletion">`**: Confirmation dialog with password input
- **Components:** `<x-danger-button />`, `<x-modal />`, `<x-input-label />`, `<x-text-input />`, `<x-input-error />`, `<x-secondary-button />`

---

## 8. Partials (`resources/views/partials/`)

### `public-nav.blade.php`
Public navigation bar (fixed, glass effect).
- **Desktop Nav:** Logo + About, Services dropdown (Lots, Plans, Columbarium), Find a Loved One, Contact, Login/Dashboard button
- **Services Dropdown:** Icons + links, 3 items, columbarium disabled "Coming Soon"
- **Mobile menu:** Hamburger toggle, vertical layout with accordion services
- **Alpine.js:** Scroll-aware background (transparent on hero, white when scrolled)

### `public-footer.blade.php`
Public footer.
- **4-column grid:**
  1. Logo + description + social media icons (FB, Instagram, TikTok, LinkedIn, YouTube)
  2. "Visit Us" with address + Google Maps link
  3. "Contact Us" with email, phone, Direct Message link
  4. (empty spacer)
- **Bottom bar:** Copyright + "Solano, Nueva Vizcaya"

---

## 9. Blade Components (`resources/views/components/`)

All components are styled Laravel Blade UI components.

| File | Visual Details |
|------|----------------|
| `application-logo.blade.php` | SVG logo, configurable class/w/h, `fill-current` |
| `auth-session-status.blade.php` | Green/success text block for auth status messages |
| `danger-button.blade.php` | Red button (`bg-red-700 hover:bg-red-500`), `danger-button` class |
| `dropdown.blade.php` | Wrapper with Alpine dropdown (align left/right, width configurable), transition |
| `dropdown-link.blade.php` | Block link inside dropdown (`hover:bg-gray-100`) |
| `input-error.blade.php` | Red validation error text list (`text-red-600`) |
| `input-label.blade.php` | Form label with optional `required` indicator |
| `modal.blade.php` | Alpine.js modal with backdrop, transition, `focusable` support |
| `nav-link.blade.php` | Admin nav link with active state (bottom border + indigo text) |
| `primary-button.blade.php` | Indigo button (`bg-gray-800 hover:bg-gray-700` hover, 3 states) |
| `responsive-nav-link.blade.php` | Mobile nav link with active state (left border + indigo bg) |
| `secondary-button.blade.php` | Outlined/gray button (`bg-white border border-gray-300`) |
| `text-input.blade.php` | Full-width text input with Tailwind styling |

---

## 10. PHP View Components (`app/View/Components/`)

| File | Description |
|------|-------------|
| `AppLayout.php` | Renders `layouts.app` with `$slot` for main content |
| `GuestLayout.php` | Renders `layouts.guest` with `$slot` for auth forms |

---

## 11. Frontend Assets

| File | Description |
|------|-------------|
| `resources/css/app.css` | Tailwind CSS directives (`@tailwind base/components/utilities`) |
| `resources/js/app.js` | Alpine.js bootstrap |
| `public/js/map.js` | Legacy SVG cemetery map (burial spots, markers, drag-and-drop) |
| `public/build/manifest.json` | Vite build manifest |
| `public/build/assets/app-*.js` | Compiled JS bundle |
| `public/build/assets/app-*.css` | Compiled CSS bundle |

---

## Design System Summary

### Color Palette
- **Primary (Admin):** Indigo (`indigo-600`) — buttons, links, focuses
- **Primary (Public):** Emerald (`emerald-600/700`) — CTAs, accents, badges
- **Status Colors:**
  - Available/Success: `green-100` bg + `green-700/800` text
  - Reserved/Warning: `yellow-100` / `amber-100` bg + `yellow-800` / `amber-800` text
  - Occupied/Error: `red-100` bg + `red-800` text
  - Full: `red-200` bg + `red-900` text
  - Scheduled/Info: `blue-100` bg + `blue-700/800` text
  - New/Unread: `yellow-100` bg + `yellow-800` text (inquiries)
  - Contacted: `blue-100` (inquiries)
- **Surfaces:** White cards with `shadow-sm` / `rounded-lg` / `rounded-2xl`
- **Public pages:** `bg-stone-50` page background
- **Admin pages:** `bg-gray-50` page background

### Typography
- **Font:** Figtree (Google Fonts) — weights 400, 500, 600 (admin), 400-800 (public)
- **Headings:** `font-bold text-gray-900`
- **Body:** `text-gray-600`

### Common UI Patterns
- **Index pages:** White card with header bar (count + search + action button), data table with hover rows
- **Show pages:** Definition list in 2-column grid, action links below
- **Create/Edit pages:** Centered form card (`max-w-2xl`) with stacked fields
- **Empty states:** SVG icon + message + call-to-action button
- **Status badges:** `px-2 py-1 text-xs font-semibold rounded-full`
- **Tables:** Full width, border-b rows, hover effect, consistent column spacing
- **Forms:** Label + input stacked, `rounded-lg border-gray-300 shadow-sm`, indigo/emerald focus ring
- **Delete actions:** Confirm dialog + dynamic form or inline form with `@method('DELETE')`
- **Maps:** Leaflet.js (5 views: public find, public lots, public reserve, admin plots, cemetery admin, path editor)
- **Notifications:** Timelines with colored dots, unread highlight (blue tint)
- **Search:** Client-side input filter on table rows

### Special/Complex Views (Most UI Elements)
1. **contracts.create** — Product type toggle, rental fee calculator (AJAX), dynamic fields
2. **plots.index** — Map with Leaflet.Draw, modal form, boundary validation
3. **plots.create** — Map with PathTransform (rotate/scale), Turf centroid, confirm shape flow
4. **cemetery.admin** — Polygon editor, GeoJSON import/export, grave seeder
5. **paths.index** — Graph editor (nodes/edges), 4 interaction modes, pathfinding
6. **public.find** — Full-screen map, search with dropdown, detail panel, path routing
7. **contracts.show** — Most tables/relations shown (installments, payments, permits, notifications, burials)
8. **welcome** — Full marketing page with hero, about, lots, columbarium, inquiry form, careers

---

## Directory Tree (blade files only)

```
resources/views/
├── layouts/
│   ├── app.blade.php
│   ├── guest.blade.php
│   ├── navigation.blade.php
│   └── public.blade.php
├── auth/
│   ├── login.blade.php
│   ├── register.blade.php
│   ├── forgot-password.blade.php
│   ├── reset-password.blade.php
│   ├── confirm-password.blade.php
│   └── verify-email.blade.php
├── public/
│   ├── columbarium.blade.php
│   ├── confirmation.blade.php
│   ├── find.blade.php
│   ├── lots.blade.php
│   ├── plan-detail.blade.php
│   ├── plans.blade.php
│   └── reserve-form.blade.php
├── dashboard/
│   ├── dashboard.blade.php
│   ├── super-admin.blade.php
│   ├── rcc-staff.blade.php
│   └── engr.blade.php
├── clients/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   └── show.blade.php
├── burials/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   └── show.blade.php
├── burial-permits/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   └── show.blade.php
├── contracts/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   ├── show.blade.php
│   └── pdf.blade.php
├── payments/
│   ├── index.blade.php
│   ├── create.blade.php
│   └── show.blade.php
├── plots/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   └── show.blade.php
├── pre-need-plans/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   └── show.blade.php
├── columbary-niches/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   └── show.blade.php
├── inquiries/
│   ├── index.blade.php
│   ├── create.blade.php
│   └── show.blade.php
├── activity_logs/
│   └── index.blade.php
├── burial/
│   ├── index.blade.php
│   └── _modal.blade.php
├── cemetery/
│   └── admin.blade.php
├── client-notifications/
│   └── index.blade.php
├── deceased/
│   └── index.blade.php
├── notifications/
│   └── index.blade.php
├── paths/
│   ├── index.blade.php
│   └── _sidebar.blade.php
├── profile/
│   ├── edit.blade.php
│   └── partials/
│       ├── update-profile-information-form.blade.php
│       ├── update-password-form.blade.php
│       └── delete-user-form.blade.php
├── partials/
│   ├── public-nav.blade.php
│   └── public-footer.blade.php
├── components/
│   ├── application-logo.blade.php
│   ├── auth-session-status.blade.php
│   ├── danger-button.blade.php
│   ├── dropdown.blade.php
│   ├── dropdown-link.blade.php
│   ├── input-error.blade.php
│   ├── input-label.blade.php
│   ├── modal.blade.php
│   ├── nav-link.blade.php
│   ├── primary-button.blade.php
│   ├── responsive-nav-link.blade.php
│   ├── secondary-button.blade.php
│   └── text-input.blade.php
└── welcome.blade.php
```
