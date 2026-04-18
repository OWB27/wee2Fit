# wee2Fit · [简体中文](#简体中文版)

## Overview · [中文](#概述)

wee2Fit is a bilingual fitness and nutrition planning web application built with Laravel. It helps users manage their profile, generate a calorie and macro plan, build weekly meal plans, browse a food library, and track body metrics over time. The project also includes an admin area for managing foods, users, and user tags.

简中：`wee2Fit` 是一个基于 Laravel 的中英双语健身营养规划网站，包含用户资料、计划生成、每周食谱、食物库、进度追踪和管理员后台等完整功能。

## Live Demo · [中文](#在线演示)

- Production URL: `https://wee2fit-production.up.railway.app`
- Deployment target: Railway
- Runtime setup: Laravel app + SQLite database file + Railway volume for persistent data and uploaded files

简中：项目已经部署到 Railway，当前线上版本使用 SQLite，并通过 Railway volume 持久化数据库文件和上传内容。

## Main Features · [中文](#主要功能)

### User Workspace

- Dashboard with current plan summary, weekly meal plan preview, and progress charts
- Profile editing with body information, goal, activity level, and intensity
- Nutrition plan generation with BMR, TDEE, target calories, and macro targets
- Weekly meal planner with per-day, per-meal food assignment
- Progress tracking with historical weight and body-fat records

### Public Pages

- Home page
- Methodology page
- Food library
- Food detail page

### Admin Area

- Admin dashboard
- Food CRUD with image upload
- User management with activation state and tag assignment

简中：主要模块包括用户工作台、公开页面和管理员后台。用户可以维护资料、生成计划、安排每周食谱、记录身体数据；管理员可以管理食物、用户和标签。

## Tech Stack · [中文](#技术栈)

- Laravel 12
- Laravel Breeze
- PHP 8.4 deployment runtime
- SQLite
- Blade
- Tailwind CSS
- DaisyUI
- Alpine.js
- Vite
- GitHub Actions for CI
- Railway for deployment

简中：项目使用 Laravel + Blade + Tailwind/DaisyUI + SQLite + Vite，CI 使用 GitHub Actions，部署平台为 Railway。

## Data Model · [中文](#数据模型)

Key tables:

- `users`
- `profiles`
- `plans`
- `body_metrics`
- `foods`
- `weekly_plans`
- `weekly_plan_foods`
- `user_tags`
- `user_tag_user`

Important relationships:

- `User -> Profile`: one-to-one
- `User -> Plans`: one-to-many
- `User -> BodyMetrics`: one-to-many
- `User -> WeeklyPlans`: one-to-many
- `WeeklyPlan -> WeeklyPlanFoods`: one-to-many
- `Food -> WeeklyPlanFoods`: one-to-many
- `User <-> UserTags`: many-to-many through `user_tag_user`

This structure supports the full workflow from profile setup to plan generation, weekly meal planning, progress tracking, and admin management.

简中：数据库包含用户、资料、计划、食物、每周食谱、进度记录和标签等核心实体，并覆盖了一对一、一对多和多对多关系。

## Deployment Notes · [中文](#部署说明)

The current production deployment uses Railway with a Dockerfile-based Laravel service. SQLite is stored as a file at a persistent mounted path, and uploaded files are also persisted through the same Railway volume.

Key deployment ideas:

- HTTPS is enforced for generated asset URLs in production
- Laravel storage is linked on container startup
- The SQLite file is created on startup if it does not exist
- Migrations are run automatically on container startup

简中：当前部署方式是 Railway + Dockerfile。数据库不是独立服务，而是存放在挂载卷中的 SQLite 文件；上传文件也通过同一 volume 持久化。

## Local Setup · [中文](#本地运行)

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

Create the database file if needed:

```bash
type nul > database/database.sqlite
```

### 3. Run migrations and seed demo data

```bash
php artisan migrate
php artisan db:seed --class=DemoDataSeeder
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

简中：本地运行流程是安装依赖、复制 `.env`、生成 key、创建 SQLite 文件、执行迁移和 seed，然后分别启动 Laravel 和 Vite。

## Demo Accounts · [中文](#演示账号)

The demo seeder creates:

- Admin
  - Email: `admin@wee2fit.test`
  - Password: `password`
- User
  - Email: `user@wee2fit.test`
  - Password: `password`

If you changed the seeded passwords in your deployed environment, use the updated values instead.

简中：默认 seed 会生成管理员和普通用户两个演示账号；如果你在线上手动改过密码，请以线上实际密码为准。

## Testing and CI · [中文](#测试与-ci)

Run tests locally with:

```bash
php artisan test
```

Build frontend assets with:

```bash
npm run build
```

The project also includes a basic GitHub Actions CI workflow that installs dependencies, runs tests, and verifies the frontend build.

简中：项目带有基础测试和 CI，能够自动执行 Laravel 测试与前端构建检查。

## Project Map · [中文](#项目文档)

Useful project documents:

- [docs/project-map.md](docs/project-map.md)
- [docs/test-map.md](docs/test-map.md)

Key directories:

- `app/Http/Controllers`
- `app/Models`
- `app/Services`
- `database/migrations`
- `database/seeders`
- `resources/views`
- `resources/css`
- `routes/web.php`
- `tests/Feature`

简中：项目还附带了结构说明和测试说明文档，便于理解整体架构与主要用户流程。

---

# 简体中文版

## 概述

`wee2Fit` 是一个中英双语的健身营养规划网站，基于 Laravel 构建。它支持用户维护身体资料、生成热量和宏量营养素计划、安排每周食谱、浏览食物库、记录进度数据，并提供管理员后台管理食物、用户和标签。

## 在线演示

- 线上地址：`https://wee2fit-production.up.railway.app`
- 部署平台：Railway
- 当前部署方式：Laravel + SQLite + Railway volume

## 主要功能

- Dashboard 展示当前计划、每周食谱预览和进度图表
- My Profile 维护身高、体重、活动水平、目标和强度
- Plan 生成并展示 BMR、TDEE、目标热量和宏量营养素
- Weekly Meal Plan 为一周三餐添加食物并汇总热量
- Progress 记录体重和体脂趋势
- Admin 后台管理食物、用户和用户标签

## 技术栈

- Laravel 12
- Laravel Breeze
- PHP 8.4
- SQLite
- Blade
- Tailwind CSS
- DaisyUI
- Alpine.js
- Vite
- GitHub Actions
- Railway

## 数据模型

核心表包括：

- `users`
- `profiles`
- `plans`
- `body_metrics`
- `foods`
- `weekly_plans`
- `weekly_plan_foods`
- `user_tags`
- `user_tag_user`

覆盖的一些主要关系：

- 用户与资料：一对一
- 用户与计划：一对多
- 用户与身体指标：一对多
- 用户与每周食谱：一对多
- 用户与标签：多对多

## 部署说明

当前线上版本使用 Railway 部署。数据库不是独立的 PostgreSQL/MySQL 服务，而是保存在挂载卷中的 SQLite 文件；图片等上传内容也通过同一个 volume 持久化。

## 本地运行

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed --class=DemoDataSeeder
php artisan serve
npm run dev
```

## 演示账号

- 管理员：`admin@wee2fit.test` / `password`
- 普通用户：`user@wee2fit.test` / `password`

如果线上环境已经手动修改过密码，请以线上实际账号为准。

## 测试与 CI

- 本地测试：`php artisan test`
- 前端构建：`npm run build`
- CI：GitHub Actions 自动执行测试和构建

## 项目文档

- [docs/project-map.md](docs/project-map.md)
- [docs/test-map.md](docs/test-map.md)
