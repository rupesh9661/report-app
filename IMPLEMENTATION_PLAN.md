# Transaction Report System - Summary

## Technology Used

### Backend
- **Laravel 12**
- **MySQL** - tables: transactions, users, games, and providers
- **Query Builder**

### Frontend
- **Bootstrap 5**
- **jQuery**
- **DataTables** - for pagination, sorting, and server-side processing
- **Select2** - for AJAX search dropdowns

---

## User Guide

### Viewing Transactions
1. Open your browser and go to `/reports`
2. You'll see a table with all transactions

### Table Features

**Pagination:**
- Use page numbers at the bottom to navigate
- Use "Previous" and "Next" buttons
- Change rows per page using dropdown (10, 20, 50, 100)

**Sorting:**
- Click any column header to sort
- Click again to reverse sort order

**Filtering with Search:**

**By User:**
1. Click "User" dropdown
2. Type at least 2 letters of the user's name
3. Select user from the search results
4. Table updates automatically

**By Provider:**
1. Click "Provider" dropdown
2. Type at least 2 letters of the provider's name
3. Select provider from the search results
4. Table updates automatically

**By Game:**
1. Click "Game" dropdown
2. Type at least 2 letters of the game's name
3. Select game from the search results
4. Table updates automatically

**Reset Filters:**
- Click "Reset" button to clear all filters and show all transactions

---

## Developer Guide

### Seed Test Data
```bash
php artisan db:seed --class=ReportDataSeeder
```

### Access Report
Open browser: `http://localhost:8000/reports`

### Important Files

**Backend:**
- `app/Http/Controllers/ReportController.php` - Main controller
  - `index()` - Display report page
  - `getReportData()` - Return data for DataTables
- `app/Http/Controllers/FilterController.php` - AJAX search endpoints
  - `searchUsers()` - Search users
  - `searchGames()` - Search games
  - `searchProviders()` - Search providers
- `app/Services/ReportService.php` - Database queries with filters
- `routes/web.php` - URL routes

**Frontend:**
- `resources/views/reports/index.blade.php` - Main page with DataTables

**Database:**
- `database/migrations/` - Database structure
- `database/seeders/ReportDataSeeder.php` - Test data

### Routes (URLs)

- `/reports` - View report page
- `/reports/data` - Get table data (DataTables AJAX endpoint)
- `/filters/search-users` - Search users (Select2 AJAX)
- `/filters/search-games` - Search games (Select2 AJAX)
- `/filters/search-providers` - Search providers (Select2 AJAX)

### Available Filters

Only 3 filters with AJAX search:
1. **User** - Search by user name (minimum 2 characters)
2. **Provider** - Search by provider name (minimum 2 characters)
3. **Game** - Search by game name (minimum 2 characters)

All filters use Select2 with AJAX to search and load results dynamically without page refresh.
