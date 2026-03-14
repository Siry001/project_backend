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
