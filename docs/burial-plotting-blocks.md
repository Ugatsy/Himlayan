# Burial Plotting & Blocks

## Overview

The burial plotting system manages cemetery plots digitally using interactive maps. Two systems coexist:

| System | Technology | Scope | Role |
|--------|-----------|-------|------|
| **Plots (Modern)** | Leaflet.js + GeoJSON | GPS-accurate lot mapping | All authenticated users |
| **Burial Spots (Legacy)** | SVG canvas | Simple 2D marker placement | Super admin only |

---

## Data Model

### `plots` (Primary)

| Column | Type | Description |
|--------|------|-------------|
| `id` | bigint PK | |
| `plot_number` | string(50) UNIQUE | e.g., "A-001" |
| `section` | string(100) | e.g., "Block A" |
| `lat`, `lng` | decimal(10,8)/(11,8) | Centroid GPS coordinate |
| `shape` | json | GeoJSON Polygon (lot boundary) |
| `lot_type` | string(20) | `individual` or `family` |
| `dimension` | string(100) | Human-readable size, e.g., "1.5m × 2.5m" |
| `capacity` | tinyint | Max occupants |
| `current_occupants` | tinyint | Current burials |
| `status` | enum | `available`, `reserved`, `occupied`, `full` |
| `price` | decimal(10,2) | PHP |

**Model:** `App\Models\Plot`
**Controller:** `App\Http\Controllers\PlotController`
**Routes:** `resource 'plots'` (+ `PATCH plots/{plot}/position`)

### `burial_spots` (Legacy)

| Column | Type | Description |
|--------|------|-------------|
| `id` | bigint PK | |
| `plot_number` | string UNIQUE | |
| `name` | string(255) | Deceased name |
| `section` | string(255) | |
| `birth_year`, `death_year` | year | |
| `status` | enum | `occupied`, `reserved`, `available` |
| `map_x`, `map_y` | decimal(8,2) | Position on SVG canvas (520×380) |

**Model:** `App\Models\BurialSpot`
**Controller:** `App\Http\Controllers\BurialSpotController`
**Routes:** `resource 'burial-spots'` (+ `PATCH burial-spots/{id}/position`) — super admin only

### `cemetery_polygons`

| Column | Type | Description |
|--------|------|-------------|
| `geojson` | json | Polygon boundary of the cemetery |
| `area_sqm` | decimal(12,2) | |
| `area_hectares` | decimal(10,4) | |

**Model:** `App\Models\CemeteryPolygon`
Boundary is linked 1:1 to a `Cemetery` record.

### `graves`

Public-facing grave markers (memorial records).

**Model:** `App\Models\Grave`
Stored as individual points. Can be seeded programmatically inside a cemetery boundary.

### `path_nodes` / `path_edges`

Walkway graph for Dijkstra shortest-path navigation from cemetery entrance to a grave.

**Services:**
- `App\Services\DijkstraService` — shortest-path algorithm
- `App\Services\PathManagerService` — graph CRUD orchestration

---

## Map Tools & Libraries

### Leaflet.js (v1.9.4)

- **Tile layers:** Google Satellite (`mt1.google.com/vt/lyrs=s`), OpenStreetMap, and a custom `/tiles/{z}/{x}/{y}.png` endpoint.
- **Map bounds clamped** to cemetery area (`maxBounds: L.latLngBounds(...)`) with `maxBoundsViscosity: 1.0` to prevent panning outside.
- **CDN:** `https://unpkg.com/leaflet@1.9.4/dist/leaflet.js`

### Leaflet.Draw (v1.0.4)

Enables rectangle/polygon drawing on the map.

- **Used in:** `plots/index.blade.php`, `plots/create.blade.php`, `plots/edit.blade.php`
- **Tools enabled:** Rectangle, Polygon
- **Tools disabled:** Circle, CircleMarker, Marker, Polyline
- **Edit mode:** Enabled to move/resize drawn shapes
- **Control position:** `topright`
- **CDN:** `https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js`

### Leaflet.PathTransform

Adds rotate, scale, and translate handles to drawn shapes.

- **Used in:** `plots/create.blade.php`, `plots/edit.blade.php`
- **Initialization:** `new L.Handler.PathTransform(layer)` then `.enable({ rotation: true, scaling: true, uniformScaling: true, translation: true })`
- **Event:** `transformed` fires after any transform action
- **CDN:** `https://cdn.jsdelivr.net/npm/leaflet-path-transform@1.9.0/dist/index.js`

### Turf.js (v6)

Geospatial analysis.

- **`turf.booleanPointInPolygon`** — validates every plot vertex is inside the cemetery boundary
- **`turf.centroid`** — computes plot center for storing `lat`/`lng`
- **`turf.polygon`** — normalizes GeoJSON for analysis
- **`turf.area`** — alternative area calculation
- **Used in:** All plot views (boundary enforcement), cemetery admin (area calculation)
- **CDN:** `https://unpkg.com/@turf/turf@6/turf.min.js`

### SVG (Legacy)

- **Used in:** `burial/index.blade.php` with `public/js/map.js`
- **Canvas:** 520×380 `viewBox`
- **Rendering:** Inline `<rect>` elements per burial spot, color-coded by status
- **Interaction:** Drag-and-drop via `mousedown`/`touchstart` handlers
- **Position save:** `PATCH /burial-spots/{id}/position` sends `{ x, y }`

---

## Plot Creation Workflow

1. **Draw shape** on map using Leaflet.Draw rectangle/polygon tool
2. **Boundary check** — Turf.js verifies all vertices are inside the cemetery boundary polygon. If any vertex is outside, the shape turns red and a warning is shown.
3. **Transform** — PathTransform handles appear for rotate/scale/translate
4. **Confirm Shape** — Click "Confirm Shape" button to lock the shape; this populates a hidden `shape-input` with the full GeoJSON
5. **Fill form** — Plot number, section/block, lot type, dimension, capacity, price, status
6. **Submit** — POST to `plots.store`; shape stored as JSON in the `shape` column

### Boundary Enforcement

```
Boundary GeoJSON → turf.polygon(coords)
Plot shape coords → turf.point(vertex) per vertex
turf.booleanPointInPolygon(point, boundaryPolygon)
→ ALL must be true; otherwise shape is rejected
```

### Centroid Calculation

After confirmation, `turf.centroid(geoJson)` computes the center, stored in `lat`/`lng` columns and shown in the sidebar centroid display.

---

## Cemetery Boundary Management

**View:** `cemetery/admin.blade.php` — `GET /cemetery/admin`

Boundaries are drawn by clicking vertices directly on the Leaflet map (no Leaflet.Draw — uses a custom click-to-add-vertex approach):

1. Click on map → adds a vertex (shown as a numbered circle marker)
2. Preview polyline drawn between vertices in sequence
3. Auto-closes when clicking back near the first vertex
4. Area computed via `turf.area()` in sqm and hectares
5. GeoJSON saved to `cemetery_polygons` via `POST /cemetery/polygon`

### Additional tools:
- **GeoJSON Import/Export** — upload or download cemetery boundary data
- **Grave Management** — add, edit, delete grave markers; seed random graves for testing
- **Cemetery Selector** — switch between multiple cemeteries, create new ones
- **Pathfinding** — click a grave to route from the cemetery entrance via Dijkstra

---

## Pathway Navigation System

**View:** `paths/index.blade.php` — `GET /paths`

A graph-based navigation system for visitors to find routes to graves:

- **Nodes** — waypoints/entrances/junctions with lat/lng positions
- **Edges** — walkways connecting nodes with weight (distance) and type
- **Dijkstra's algorithm** — calculates shortest path from cemetery entrance to nearest node of a grave
- **Four modes:** View, Node (add/delete), Edge (connect nodes), Draw (freehand path)
- **Export/Import** the entire graph as JSON

---

## Routes Summary

| Method | URI | Name | Auth |
|--------|-----|------|------|
| GET | `/plots` | `plots.index` | auth |
| GET | `/plots/create` | `plots.create` | auth |
| POST | `/plots` | `plots.store` | auth |
| GET | `/plots/{plot}` | `plots.show` | auth |
| GET | `/plots/{plot}/edit` | `plots.edit` | auth |
| PUT | `/plots/{plot}` | `plots.update` | auth |
| DELETE | `/plots/{plot}` | `plots.destroy` | auth |
| PATCH | `/api/plots/{plot}/position` | `plots.position` | auth:sanctum |
| GET | `/api/plots` | — | auth:sanctum |
| GET | `/cemetery/admin` | `cemetery.admin` | super_admin, engr |
| POST | `/cemetery/save` | `cemetery.save` | super_admin, engr |
| POST | `/cemetery/polygon` | `cemetery.polygon.save` | super_admin, engr |
| GET | `/cemetery/polygon` | `cemetery.polygon.get` | public |
| GET | `/cemetery/graves` | `cemetery.graves.list` | super_admin, engr |
| POST | `/cemetery/graves` | `cemetery.graves.save` | super_admin, engr |
| POST | `/cemetery/import` | `cemetery.import` | super_admin, engr |
| GET | `/cemetery/find-path` | `cemetery.find-path` | public |
| GET | `/paths` | `paths.index` | super_admin, engr |
| POST | `/paths/nodes` | `paths.nodes.store` | super_admin, engr |
| POST | `/paths/edges` | `paths.edges.store` | super_admin, engr |
| GET | `/paths/find` | `paths.find` | super_admin, engr |
| GET | `/paths/export` | `paths.export` | super_admin, engr |
| POST | `/paths/import` | `paths.import` | super_admin, engr |
| POST | `/paths/reset` | `paths.reset` | super_admin, engr |

---

## Status Color Legend

| Status | Badge | Map Shape |
|--------|-------|-----------|
| Available | `bg-green-100 text-green-700` | Green `#22c55e` |
| Reserved | `bg-amber-100 text-amber-700` | Amber `#f59e0b` |
| Occupied | `bg-red-100 text-red-700` | Red `#ef4444` |
| Full | `bg-red-100 text-red-700` | Red `#ef4444` |

---

## Key Files

| Path | Purpose |
|------|---------|
| `app/Models/Plot.php` | Plot model with GeoJSON shape cast |
| `app/Models/BurialSpot.php` | Legacy SVG spot model |
| `app/Models/Cemetery.php` | Cemetery boundary container |
| `app/Models/CemeteryPolygon.php` | GeoJSON polygon storage |
| `app/Models/Grave.php` | Grave marker records |
| `app/Models/PathNode.php` | Walkway graph vertex |
| `app/Models/PathEdge.php` | Walkway graph edge |
| `app/Http/Controllers/PlotController.php` | Plot CRUD |
| `app/Http/Controllers/CemeteryMapController.php` | Boundary + grave + pathfinding |
| `app/Http/Controllers/PathController.php` | Pathway graph editor |
| `app/Services/DijkstraService.php` | Shortest-path algorithm |
| `app/Services/PathManagerService.php` | Graph management |
| `resources/views/plots/index.blade.php` | Plots dashboard with map |
| `resources/views/plots/create.blade.php` | Draw + form to create a plot |
| `resources/views/plots/edit.blade.php` | Edit existing plot shape |
| `resources/views/plots/show.blade.php` | Plot detail with shape overlay |
| `resources/views/cemetery/admin.blade.php` | Full cemetery admin | 
| `resources/views/paths/index.blade.php` | Pathway graph editor |
| `public/js/map.js` | Legacy SVG drag-and-drop |
