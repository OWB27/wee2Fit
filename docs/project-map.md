# Project Map

This file is a quick guide to where the important parts of wee2Fit live.

## 1. Routing

Main route file:

- `routes/web.php`

The route groups are roughly:

- public pages
- authenticated user workspace
- admin-only area

## 2. Public Pages

Controllers:

- `app/Http/Controllers/HomeController.php`
- `app/Http/Controllers/FoodController.php`

Views:

- `resources/views/home.blade.php`
- `resources/views/methodology.blade.php`
- `resources/views/foods/index.blade.php`
- `resources/views/foods/show.blade.php`

Layout:

- `resources/views/layouts/app.blade.php`

## 3. User Workspace

Controllers:

- `app/Http/Controllers/DashboardController.php`
- `app/Http/Controllers/MyProfileController.php`
- `app/Http/Controllers/PlanController.php`
- `app/Http/Controllers/BodyMetricController.php`
- `app/Http/Controllers/WeeklyPlanController.php`
- `app/Http/Controllers/WeeklyPlanFoodController.php`

Views:

- `resources/views/dashboard.blade.php`
- `resources/views/my-profile/edit.blade.php`
- `resources/views/plans/show.blade.php`
- `resources/views/progress/index.blade.php`
- `resources/views/weekly-plans/index.blade.php`
- `resources/views/weekly-plans/create.blade.php`
- `resources/views/weekly-plans/show.blade.php`

Layout:

- `resources/views/layouts/workspace.blade.php`

## 4. Admin Area

Controllers:

- `app/Http/Controllers/AdminDashboardController.php`
- `app/Http/Controllers/AdminFoodController.php`
- `app/Http/Controllers/AdminUserController.php`

Views:

- `resources/views/admin/dashboard.blade.php`
- `resources/views/admin/foods/*`
- `resources/views/admin/users/*`

## 5. Core Domain Models

Models:

- `User`
- `Profile`
- `Plan`
- `BodyMetric`
- `Food`
- `WeeklyPlan`
- `WeeklyPlanFood`
- `UserTag`

Relationships worth learning first:

- `User` with `Profile`, `Plan`, `BodyMetric`, `WeeklyPlan`
- `WeeklyPlan` with `WeeklyPlanFood`
- `Food` with `WeeklyPlanFood`
- `User` with `UserTag`

## 6. Plan Generation Logic

Main service:

- `app/Services/PlanGeneratorService.php`

This service is the best place to study if you want to understand:

- BMR calculation
- activity factor / TDEE calculation
- calorie target adjustment
- macro distribution

## 7. Database

Schema history:

- `database/migrations`

Demo data:

- `database/seeders/DemoDataSeeder.php`

The demo seeder creates:

- an admin user
- a normal demo user
- food library seed data
- profile data
- current plan data
- body metric history
- one weekly meal plan

## 8. Frontend Structure

Main frontend folders:

- `resources/views`
- `resources/css/app.css`
- `resources/js/app.js`

Current frontend approach:

- Blade for page structure
- Tailwind + DaisyUI + custom utility classes in `app.css`
- lightweight page-specific JS only where needed

## 9. Language Files

Language files:

- `lang/en/messages.php`
- `lang/zh_CN/messages.php`

These contain the app-specific UI strings and are kept aligned by key.

## 10. Good Files To Learn First

If you want a fast understanding of the project, read in this order:

1. `routes/web.php`
2. `app/Services/PlanGeneratorService.php`
3. `app/Http/Controllers/DashboardController.php`
4. `app/Http/Controllers/WeeklyPlanController.php`
5. `resources/views/layouts/app.blade.php`
6. `resources/views/layouts/workspace.blade.php`
7. `resources/views/plans/show.blade.php`
8. `resources/views/weekly-plans/show.blade.php`

