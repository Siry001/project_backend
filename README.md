# Gym Backend API

A RESTful backend API for a fitness tracking application built with **Laravel**.

This project was developed as part of a **System Analysis course** and demonstrates how a backend system can manage workouts, workout plans, diet plans, and user progress tracking.

---

# Project Overview

The Gym Backend API provides a backend system that allows fitness applications (mobile or web) to manage user training data efficiently.

The system allows users to:

- Register and login securely
- Manage workouts
- Log workout sessions
- Track workout progress
- Create workout plans
- Create diet plans

The API follows **RESTful architecture** and returns **JSON responses** for easy integration with frontend applications.

---

# Tech Stack

### Framework
- Laravel

### Authentication
- Laravel Sanctum

### Database
- SQLite

### Development Tools
- Git
- GitHub
- Postman

---

# System Architecture

The system follows a layered backend architecture.

Client Application  
↓  
API Routes  
↓  
Controllers  
↓  
Models  
↓  
Database

This structure keeps the system maintainable and scalable.

---

# Database Structure

Main tables:

- users
- workouts
- workout_logs
- workout_plans
- diet_plans
- personal_access_tokens

Relationships:

User  
├── Workouts  
│   └── Workout Logs  
├── Workout Plans  
└── Diet Plans  

Workout Plan  
└── Workouts  

Workout  
└── Workout Logs  

---

# Authentication

Authentication is implemented using **Laravel Sanctum**.

Users receive an authentication token after login.

This token must be included in protected requests.

Example header:

```
Authorization: Bearer YOUR_ACCESS_TOKEN
```
---

# API Endpoints

## Authentication

POST /api/register  
POST /api/login  
POST /api/logout  

---

## Workouts

GET /api/workouts  
POST /api/workouts  
GET /api/workouts/{id}  
PUT /api/workouts/{id}  
DELETE /api/workouts/{id}

---

## Workout Logs

POST /api/logs  
GET /api/logs  

Stored data includes:

- weight
- reps
- sets
- performed_at

---

## Workout Plans

GET /api/plans  
POST /api/plans  
GET /api/plans/{id}  
DELETE /api/plans/{id}

---

## Diet Plans

GET /api/diet-plans  
POST /api/diet-plans  
PUT /api/diet-plans/{id}  
DELETE /api/diet-plans/{id}

---

## Progress Tracking

GET /api/workouts/{id}/progress


Example response:
```json
{
  "workout_id": 1,
  "total_sessions": 3,
  "best_weight": 90,
  "last_session": {
    "weight": 90,
    "reps": 8,
    "sets": 4,
    "performed_at": "2026-03-09"
  }
}
```

# Security Improvements

The following improvements were implemented to enhance API security:
-	Added authorization checks to prevent users from accessing other users’ data
-	Secured show, update, and delete endpoints
-	Ensured workouts, plans, and diet plans are scoped to the authenticated user
-	Protected the progress endpoint from unauthorized access


# Recent Backend Improvements

Recent backend changes include:
-	Fixed authorization logic in controllers
-	Added proper Eloquent relationships between models
-	Improved progress tracking logic
-	Cleaned controller validation
-	Refactored queries to use Eloquent relationships
-	Ensured API endpoints only return data belonging to the authenticated user

# Running the Project

Clone the repository:
```
git clone <repository_url>
```
Install dependencies:
```
composer install
```
Run migrations:
```
php artisan migrate
```
Start the development server:
```
php artisan serve
```
The API will run on:
```
http://127.0.0.1:8000
```

# Testing the API

You can test the API using Postman.

Example login request: POST /api/login

The response will include an authentication token.

Use the token in protected requests: 
```
Authorization: Bearer YOUR_ACCESS_TOKEN
```
# Project Purpose

This project demonstrates:
-	REST API design
-	Backend architecture
-	Authentication using Laravel Sanctum
-	Database relationships using Eloquent
-	Secure API design

It was developed as part of a System Analysis course project.
>>>>>>> bebce09 (Improve README formatting)