# Database Schema

Planned schema for Phase 1 and beyond.

## Core Tables

### `departments`

| Column | Type | Notes |
|---|---|---|
| `id` | bigint unsigned | PK |
| `name` | string | Department name |
| `code` | string | Short code |
| `branch` | string | Branch/location |
| `manager_id` | foreign key → employees | Nullable |
| `timestamps` | datetime | Laravel defaults |

### `employees`

| Column | Type | Notes |
|---|---|---|
| `id` | bigint unsigned | PK |
| `user_id` | foreign key → users | One-to-one with auth user |
| `department_id` | foreign key → departments | |
| `employee_number` | string | Unique |
| `job_title` | string | |
| `hire_date` | date | |
| `branch` | string | |
| `is_active` | boolean | |
| `timestamps` | datetime | |

### `attendance_logs`

| Column | Type | Notes |
|---|---|---|
| `id` | bigint unsigned | PK |
| `employee_id` | foreign key → employees | |
| `recorded_at` | datetime | Actual biometric timestamp |
| `type` | enum | check_in / check_out |
| `source` | string | biometric / manual / import |
| `branch` | string | |
| `raw_payload` | json | Original biometric data for audit |
| `timestamps` | datetime | |

## Notes

- `attendance_logs` is designed to be source-agnostic. Phase 1 starts with CSV import or scheduled pull.
- All timestamp handling uses the application timezone; branch-specific timezone support is Phase 2.
- Soft deletes and audit logging will be added in the security/compliance phase.
