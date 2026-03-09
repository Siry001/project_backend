# Gym Backend API

A RESTful backend API for a fitness tracking application built with Laravel.

This project was developed as part of a System Analysis course and demonstrates how a backend system can manage workouts, training logs, progress tracking, and diet plans for a fitness application.

---

## Project Overview

The Gym Backend API provides a structured backend system that allows fitness applications (mobile or web) to manage user training data efficiently.

The system allows users to:

- Register and login securely
- Manage workouts
- Log workout sessions
- Track training progress
- Create workout plans
- Create diet plans

The API follows RESTful architecture and returns JSON responses for easy integration with frontend applications.

---

## Tech Stack

Framework  
- Laravel

Authentication  
- Laravel Sanctum

Database  
- SQLite

Architecture  
- RESTful API

Development Tools  
- Git  
- GitHub  
- Postman

---

## System Architecture

The system follows a layered backend architecture:

Client Application (Mobile / Web)  
↓  
API Routes  
↓  
Controllers  
↓  
Models  
↓  
Database

This structure separates responsibilities and keeps the code maintainable and scalable.

---

## Database Structure

The system includes the following main tables:

Users  
Workouts  
Workout Logs  
Workout Plans  
Diet Plans

Relationships:

User  
├── Workouts  
│   └── Workout Logs  
├── Workout Plans  
└── Diet Plans

---

## Authentication

Authentication is implemented using **Laravel Sanctum**.

The API uses token-based authentication to secure endpoints.

Endpoints:

POST /api/register  
POST /api/login  
POST /api/logout

After login, users receive an authentication token used to access protected routes.

---

## API Endpoints

### Workouts

GET /api/workouts  
Retrieve all workouts

POST /api/workouts  
Create a new workout

PUT /api/workouts/{id}  
Update a workout

DELETE /api/workouts/{id}  
Delete a workout

---

### Workout Logs

POST /api/logs  
Create a workout log

GET /api/logs  
Retrieve workout logs

Stored data includes:

- weight
- reps
- sets
- performed_at

---

### Progress Tracking

GET /api/workouts/{id}/progress

Returns:

- total_sessions
- best_weight
- last_session

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
