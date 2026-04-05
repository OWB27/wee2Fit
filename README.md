# wee2Fit

wee2Fit is a bilingual fitness and nutrition planning web app built with Laravel. It helps users:

- manage their profile and body metrics
- generate a calorie and macro plan
- browse a food library
- build a weekly meal plan
- review progress trends
- manage foods and users through an admin area

The UI supports both English and Simplified Chinese.

## Tech Stack

- Laravel 12
- Laravel Breeze
- PHP 8.2+
- SQLite
- Blade
- Tailwind CSS
- DaisyUI
- Alpine.js
- Vite

## Main Features

### User Workspace

- `Dashboard`: overview of current plan, latest weekly plan preview, and progress charts
- `My Profile`: profile editing, BMR/TDEE preview, goal and intensity settings
- `Plan`: generate and review the current calorie and macro plan
- `Progress & Metrics`: add body-metric records and view weight/body-fat trends
- `Weekly Meal Plans`: create, edit, finalize, and manage weekly meal plans

### Public Pages

- `Home`
- `Methodology`
- `Food Library`
- `Food Detail`

### Admin Area

- `Admin Dashboard`
- `Food Management`: full CRUD including image upload
- `User Management`: edit user info, activate/deactivate users, manage user tags

## Database Overview

Key application tables:

- `users`: authentication, roles, activation state
- `profiles`: user profile data used for plan generation
- `plans`: generated calorie and macro plans
- `body_metrics`: progress tracking records
- `foods`: food library entries
- `weekly_plans`: weekly planner headers
- `weekly_plan_foods`: foods assigned to weekly plan days/meals
- `user_tags`: admin-managed user labels
- `user_tag_user`: pivot table for user tags

Important relationships:

- `User -> Profile`: one-to-one
- `User -> Plans`: one-to-many
- `User -> BodyMetrics`: one-to-many
- `User -> WeeklyPlans`: one-to-many
- `WeeklyPlan -> WeeklyPlanFoods`: one-to-many
- `Food -> WeeklyPlanFoods`: one-to-many
- `User <-> UserTags`: many-to-many through `user_tag_user`

For a code-level map, see [docs/project-map.md](docs/project-map.md).

## Local Setup

### 1. Install dependencies

```bash
composer install
npm install
```

### 2. Configure environment

```bash
cp .env.example .env
php artisan key:generate
```

Use SQLite in `.env`, for example:

```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

Then create the database file if needed:

```bash
type nul > database/database.sqlite
```

### 3. Run migrations and seed demo data

```bash
php artisan migrate
php artisan db:seed
```

### 4. Start the app

In one terminal:

```bash
php artisan serve
```

In another terminal:

```bash
npm run dev
```

## Demo Accounts

The demo seeder creates:

- Admin
  - Email: `admin@wee2fit.test`
  - Password: `password`
- User
  - Email: `user@wee2fit.test`
  - Password: `password`

## Useful Commands

```bash
php artisan migrate
php artisan db:seed
php artisan test
npm run build
npm run dev
```

## Project Structure

High-level app structure:

- `app/Http/Controllers`: page and action controllers
- `app/Models`: Eloquent models
- `app/Services`: domain logic such as plan generation
- `database/migrations`: schema history
- `database/seeders`: demo data
- `resources/views`: Blade templates
- `resources/css`: shared frontend styles
- `routes/web.php`: web routes
- `tests/Feature`: feature and integration tests

For a learning-oriented map, see:

- [docs/project-map.md](docs/project-map.md)
- [docs/test-map.md](docs/test-map.md)

## Testing

Run the test suite with:

```bash
php artisan test
```

Feature tests are organized around the main user flows, admin flows, auth flows, and page access rules. See [docs/test-map.md](docs/test-map.md) for a guided map.

