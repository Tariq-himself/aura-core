# API Documentation

Base URL: `http://localhost:8000/api/v1`

## Public Endpoints

### `GET /api/v1/health`

Health check.

**Response:**

```json
{
  "success": true,
  "data": {
    "status": "ok",
    "service": "aura-core",
    "version": "v1"
  }
}
```

## Authentication

Laravel Sanctum token-based authentication.

### `POST /login`

Handled by Laravel Breeze API routes.

### `POST /logout`

Handled by Laravel Breeze API routes.

### `GET /api/v1/user`

Returns the authenticated user.

## Planned Endpoints

### `GET /api/v1/attendance/today`

Returns the current employee's attendance status for today.

## Response Envelope

All API responses use the following envelope:

```json
{
  "success": true,
  "data": { ... },
  "message": null
}
```
