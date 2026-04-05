# Test Map

This document explains how the automated tests are organized, what each test file protects, and in what order they are most useful to read.

## Test Structure

The project currently uses two test layers:

- `tests/Feature`
  Covers browser-facing behavior, request flows, permissions, CRUD, and page access.
- `tests/Unit`
  Covers isolated logic that does not need a full HTTP flow.

## Feature Tests By User Journey

### 1. Authentication Entry

Folder:

- `tests/Feature/Auth`

Files:

- `AuthenticationTest.php`
- `RegistrationTest.php`
- `EmailVerificationTest.php`
- `PasswordConfirmationTest.php`
- `PasswordResetTest.php`
- `PasswordUpdateTest.php`

What this group verifies:

- login screen rendering
- login and logout
- registration flow
- password reset and password update
- email verification flow
- password confirmation for protected areas

Why this matters:

- it protects the Laravel Breeze authentication layer that everything else depends on

### 2. Access And Middleware Protection

Files:

- `tests/Feature/ActiveUserMiddlewareTest.php`

What it verifies:

- inactive users are signed out and redirected away from protected pages

Why this matters:

- it protects the custom `active` middleware rule used across the app

### 3. Account And Profile Management

Files:

- `tests/Feature/ProfileTest.php`
- `tests/Feature/MyProfileTest.php`

What this group verifies:

- Breeze account profile editing and account deletion
- business profile creation and update
- the custom `my-profile` flow that powers plan generation

Why there are two profile areas:

- `/profile` is the Breeze account area
- `/my-profile` is the fitness/nutrition profile used by the app domain

### 4. Plan Generation Flow

Files:

- `tests/Feature/PlanFlowTest.php`
- `tests/Feature/CurrentPlanPageTest.php`

What this group verifies:

- users must complete their business profile before generating a plan
- generating a plan creates a new current plan
- old current plans are replaced correctly
- the unified plan page still works when there is or is not a current plan

Related backend logic:

- `app/Services/PlanGeneratorService.php`

### 5. Food Library

Files:

- `tests/Feature/FoodLibraryTest.php`

What this group verifies:

- public food list access
- food detail page access
- category filtering
- pagination behavior

Why this matters:

- it protects the public-facing library and its browsing rules

### 6. Progress Tracking

Files:

- `tests/Feature/ProgressTrackingTest.php`

What this group verifies:

- storing body metric records
- deleting a body metric
- ownership protection for delete actions
- future-date validation

Why this matters:

- it protects one of the most user-generated parts of the app

### 7. Weekly Meal Plan Flow

Files:

- `tests/Feature/WeeklyPlanFlowTest.php`
- `tests/Feature/WeeklyPlanFoodAuthorizationTest.php`

What this group verifies:

- creating a weekly meal plan
- viewing only your own weekly plans
- deleting a weekly meal plan
- adding foods to weekly plan slots
- deleting foods from weekly plan slots
- ownership protection for nested weekly plan food actions

Why there are two files:

- `WeeklyPlanFlowTest.php` focuses on the weekly plan resource itself
- `WeeklyPlanFoodAuthorizationTest.php` focuses on slot food actions and permissions

### 8. Admin Area

Files:

- `tests/Feature/AdminFoodManagementTest.php`
- `tests/Feature/AdminUserManagementTest.php`

What this group verifies:

- admin-only food CRUD
- non-admin access protection
- admin user state toggling
- admin user tag management

Why this matters:

- it protects the role-based part of the app and the required admin CRUD area

### 9. General Sanity

Files:

- `tests/Feature/ExampleTest.php`

What it verifies:

- the application still responds successfully at a basic level

## Unit Tests

Files:

- `tests/Unit/ExampleTest.php`
- `tests/Unit/PlanGeneratorServiceTest.php`

What this group verifies:

- baseline test environment sanity
- core nutrition-plan calculation behavior in isolation

Why `PlanGeneratorServiceTest` matters:

- it protects the most important pure business logic in the project
- it is the fastest place to debug formula-related regressions

## Test Files By App Module

### Public / Guest Area

- `tests/Feature/Auth/*`
- `tests/Feature/FoodLibraryTest.php`
- `tests/Feature/ExampleTest.php`

### Workspace Area

- `tests/Feature/MyProfileTest.php`
- `tests/Feature/PlanFlowTest.php`
- `tests/Feature/CurrentPlanPageTest.php`
- `tests/Feature/ProgressTrackingTest.php`
- `tests/Feature/WeeklyPlanFlowTest.php`
- `tests/Feature/WeeklyPlanFoodAuthorizationTest.php`

### Admin Area

- `tests/Feature/AdminFoodManagementTest.php`
- `tests/Feature/AdminUserManagementTest.php`

### Shared Account Layer

- `tests/Feature/ProfileTest.php`
- `tests/Feature/ActiveUserMiddlewareTest.php`

## Suggested Reading Order

If you want to learn the project through tests, this order mirrors the main user journey:

1. `tests/Feature/Auth/AuthenticationTest.php`
2. `tests/Feature/Auth/RegistrationTest.php`
3. `tests/Feature/MyProfileTest.php`
4. `tests/Unit/PlanGeneratorServiceTest.php`
5. `tests/Feature/PlanFlowTest.php`
6. `tests/Feature/CurrentPlanPageTest.php`
7. `tests/Feature/FoodLibraryTest.php`
8. `tests/Feature/ProgressTrackingTest.php`
9. `tests/Feature/WeeklyPlanFlowTest.php`
10. `tests/Feature/WeeklyPlanFoodAuthorizationTest.php`
11. `tests/Feature/AdminFoodManagementTest.php`
12. `tests/Feature/AdminUserManagementTest.php`

If you want to learn the security rules first, read this shorter order:

1. `tests/Feature/ActiveUserMiddlewareTest.php`
2. `tests/Feature/ProfileTest.php`
3. `tests/Feature/WeeklyPlanFoodAuthorizationTest.php`
4. `tests/Feature/AdminFoodManagementTest.php`
5. `tests/Feature/AdminUserManagementTest.php`

## Fast Test Commands

Run everything:

```powershell
php artisan test
```

Run only unit tests:

```powershell
php artisan test tests/Unit
```

Run only feature tests:

```powershell
php artisan test tests/Feature
```

Run only plan-related tests:

```powershell
php artisan test tests/Unit/PlanGeneratorServiceTest.php tests/Feature/PlanFlowTest.php tests/Feature/CurrentPlanPageTest.php
```

Run only weekly plan tests:

```powershell
php artisan test tests/Feature/WeeklyPlanFlowTest.php tests/Feature/WeeklyPlanFoodAuthorizationTest.php
```

Run only admin tests:

```powershell
php artisan test tests/Feature/AdminFoodManagementTest.php tests/Feature/AdminUserManagementTest.php
```

## Coverage Summary

The current suite gives strong coverage for:

- authentication
- active-user access control
- user-owned data protection
- plan generation
- food browsing
- progress tracking
- weekly meal plan creation and item management
- admin CRUD and admin-only actions

The suite is most valuable as:

- regression protection before UI cleanup and CI work
- a learning map for understanding how the app is structured
- a quick reference for which tests to run after changing a module
