# Backend application structure

The seller/admin backend is kept separate from storefront code while sharing the
same CodeIgniter application, database, domain, and existing public URLs.

## Code layout

| Area | Location | Responsibility |
| --- | --- | --- |
| Backend routes | `app/Config/BackendRoutes.php` | Admin/login route declarations; loaded by `app/Config/Routes.php` before storefront catch-all routes |
| Backend controllers | `app/Controllers/Backend/` | Admin HTTP handlers, grouped under `App\Controllers\Backend` |
| Backend models | `app/Models/Backend/` | Admin persistence and query logic, grouped under `App\Models\Backend` |
| Backend views | `legacy-views/backend/` | Existing seller/admin templates rendered through the legacy view adapter |
| Shared storefront | `app/Controllers/`, `app/Models/`, `legacy-views/frontend/` | Customer-facing behavior and models shared with the storefront |

`AdminBaseController` provides the shared backend layout, legacy view services,
and `adminAuth`-protected page rendering. `ProductCatalog` owns the admin product
listing and filtering endpoints so storefront `Search` remains frontend-only.

## Adding a backend feature

1. Add its route to `app/Config/BackendRoutes.php` and apply the `adminAuth` filter
   unless it is an authentication endpoint.
2. Implement the handler under `app/Controllers/Backend/`.
3. Keep backend-only queries and writes under `app/Models/Backend/`.
4. Put admin templates in `legacy-views/backend/` and render them through
   `AdminBaseController::renderAdminPage()`.
5. Keep frontend routes and templates in their existing frontend locations.

Do not change the route paths when reorganizing these components; existing
bookmarks and admin navigation depend on them.
