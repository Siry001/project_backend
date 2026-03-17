# 🏋️ Gym Backend API (Laravel)

A RESTful backend system for a fitness application that allows users to manage workouts, track progress, and generate AI-powered workout and diet plans.

⸻

## 📊 System Design

![System Design](Docs/screen_system.drawio.png)

👉 [View Full System Design Diagram](Docs/System-Design.drawio.pdf)

This diagram represents the main system interactions including user actions, AI integration, and backend processing.

⸻

🚀 Features

- Clean JSON structure optimized for mobile apps

⸻

🔐 Authentication
-	Register / Login using Laravel Sanctum
-	Token-based authentication

⸻

💪 Workouts
-	Create, update, delete workouts
-	Track workout progress
-	Group workouts by day

⸻

🧠 AI Workout Generator

Generate a full workout plan using AI based on:
-	Goal (bulking, cutting, etc.)
-	Level (beginner, intermediate, advanced)
-	Number of days

- ✅ Stored in database
- ✅ Returned grouped by day

⸻

🥗 AI Diet Generator

Generate a diet plan using AI based on:
-	Goal
-	Weight
-	Number of meals

- ✅ Stored in database
- ✅ Grouped by meals (Breakfast, Lunch…)
- ✅ Includes total calories per meal

📊 Example Diet Response
```
{
    "Breakfast": {
      "foods": [
        { "name": "Oats", "calories": 300 },
        { "name": "Banana", "calories": 100 }
      ],
      "total_calories": 400
    }
}
```
🛠️ Tech Stack
-	Laravel
-	SQLite (can be switched to MySQL)
-	Laravel Sanctum
-	OpenRouter AI API

  ⚙️ Installation
  ```
  git clone https://github.com/YOUR_USERNAME/gym-backend.git
cd gym-backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
```

🔑 Environment Variables

Add your OpenRouter API key:
```
OPENROUTER_API_KEY=your_api_key_here
```

▶️ Run Server
```
php artisan serve
```
📡 API Endpoints

Auth
-	POST /api/register
-	POST /api/login

⸻

Workout AI
-	POST /api/ai/workout

⸻

Diet AI
-	POST /api/ai/diet

⸻

Diet Plans
-	GET /api/diet-plans
-	GET /api/diet-plans/{id}

⸻

📱 Next Step

Frontend mobile app using Flutter.

⸻

## 👨‍💻 Author
Siry - Backend Developer