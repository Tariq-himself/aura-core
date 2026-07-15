# Aura Core — Backend API

Laravel backend API for Aura Workspace. This repository handles employee data, attendance tracking, biometric integrations, authentication, and HR governance logic.

The frontend employee portal lives in a separate repository: [`aura-workspace`](https://github.com/Tariq-himself/aura-workspace).

---

## What This Project Solves

Aura Core provides the secure, centralized data layer for the Aura Workspace HR Hub. It exposes a clean REST API that the Next.js frontend consumes, while handling sensitive employee data in compliance with Saudi data protection requirements.

---

## Tech Stack

| Layer | Choice |
|---|---|
| Framework | Laravel 11 |
| Language | PHP 8.2+ |
| Database | PostgreSQL |
| API Auth | Laravel Sanctum |
| Admin Auth | Laravel Breeze |
| Deployment | VPS with Laravel Forge (Saudi region preferred) |

---

## API Structure

```
/api/v1/
  auth/
    login
    logout
  user
  attendance/today
```

---

## Development

### Requirements

- PHP 8.2+
- Composer
- PostgreSQL
- Docker (optional, recommended for local development)

### Setup

```bash
# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Run migrations
php artisan migrate

# Start local server
php artisan serve
```

---

## Related Repositories

- [`aura-workspace`](https://github.com/Tariq-himself/aura-workspace) — Next.js frontend

---

## Project Plan

See `AURA-PLAN.md` in the frontend repository for the full project plan, architecture decisions, and phase breakdown.
