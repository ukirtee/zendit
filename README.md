# Backend Technical Exercise: Task Manager Enhancement for Wind Tower Project Management

## Overview
This project implements backend REST APIs using the Laravel framework to manage tasks, milestones, and timesheets for Wind Tower Generator (WTG) projects. The solution includes database design, caching, background jobs, and testing.

## GitHub Repository
**Link:** [https://github.com/ukirtee/zendit](https://github.com/ukirtee/zendit)

## Technology Stack
- **Framework:** Laravel (version 11)
- **Database:** MySQL
- **Languages:** PHP

## Setup Instructions
1. Clone the repository:
   ```bash
   git clone https://github.com/ukirtee/zendit.git
   ```
2. Navigate to the project directory:
   ```bash
   cd zendit
   ```
3. Configure the `.env` file for your environment. Use `env.example` as a reference.
4. Install dependencies:
   ```bash
   composer install
   ```
5. Run database migrations:
   ```bash
   php artisan migrate
   ```
6. Start the development server:
   ```bash
   php artisan serve
   ```
   APIs can be accessed at `http://127.0.0.1:8000/api/v1`.

## Database Design
The database consists of the following key tables:
- **wtgs:** Stores WTG data.
- **milestones:** Stores milestone data.
- **tasks:** Stores task details.
- **users:** Stores technician data.
- **timesheets:** Logs technician hours for tasks.
- **task_statistics:** Stores task-specific statistics, including actual hours and variance.

### Relationships
- Each WTG has multiple milestones.
- Each milestone has multiple tasks.
- Each task has multiple timesheets and one task statistic.

## Seed Dummy Data
To populate the database with dummy data:
```bash
php artisan db:seed
```
This will create:
- 6 users
- 5 WTGs with 2 milestones each
- 3 tasks per milestone (30 tasks total)
- 5 timesheets per task (150 timesheets total)
- Rows in `task_statistics` for all tasks

## APIs
### API Response Format
- **Success:**
  ```json
  { "success": true, "data": {}, "message": "" }
  ```
- **Error:**
  ```json
  { "success": false, "errors": {}, "message": "" }
  ```

### Implemented APIs
1. **Update Task Forecast**
   - **Endpoint:** `PUT /api/v1/tasks/{taskId}/forecast`
   - **Request Body:**
     ```json
     { "forecast_date": "YYYY-MM-DD", "planned_hours": 24.5 }
     ```
   - **Details:** Updates `forecast_date` and `planned_hours` for a task.

2. **Get All Tasks with Variance**
   - **Endpoint:** `GET /api/v1/wtg/{wtgId}/tasks`
   - **Details:** Fetches all tasks for a WTG, including variance and actual hours.

3. **Get WTG Summary**
   - **Endpoint:** `GET /api/v1/wtg/{wtgId}/summary`
   - **Details:** Calculates and returns the summary of tasks under a WTG.

## Background Job
- **Job Name:** `TaskStatisticJob`
- **Purpose:** Updates `task_statistics` table with `actual_hours` and `variance` whenever `planned_hours` or timesheets change.
- **Run the job:**
  ```bash
  php artisan queue:work
  ```

## Caching
- Implemented for the WTG summary API.
- Cache duration: 60 seconds.
- Data is fetched from the cache if available; otherwise, fresh data is stored in the cache.

## Testing
### PHPUnit Tests
- Tests are located in `tests/Feature`.
- Run tests:
  ```bash
  php artisan test
  ```
- Ensure `.env.testing` is configured for testing.
- **Test Coverage:**
  - Successful responses
  - Validation errors
  - Database updates



