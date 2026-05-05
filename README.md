# AcademyQuiz

> A dynamic, extensible quiz platform built with Laravel — designed for clean evaluation, flexible question types, and seamless user experience.

---

## Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Tech Stack](#tech-stack)
- [Project Structure](#project-structure)
- [Core Architecture](#core-architecture)
- [Database Schema](#database-schema)
- [Getting Started](#getting-started)
- [Usage Guide](#usage-guide)
- [Author](#author)

---

## Overview

**AcademyQuiz** is a full-featured quiz management system built on Laravel. It empowers admins to create rich, multi-type quizzes and enables users to attempt them with instant, automatic evaluation and scoring.

The system is architected around the **Strategy Pattern**, making it clean, testable, and easy to extend with new question types.

---

## Features

### Quiz Management
- Create, edit, and manage quizzes with title, description, and status (`draft` / `published`)

### Question Types
| Type | Description |
|---|---|
| Binary | Yes / No questions |
| Single Choice | MCQ with one correct answer |
| Multiple Choice | MCQ with multiple correct answers |
| Number Input | Numeric answer evaluation |
| Text Input | Free-text answer evaluation |

### Question Editor
- Rich text support
- Optional image attachments
- Optional YouTube video URL embedding

### Quiz Attempt
- Dynamic rendering for all 5 question types
- Smooth single-page attempt flow

### Evaluation System
- Automatic scoring on submission
- Per-question correctness tracking
- Total score calculation with result breakdown

---

## Tech Stack

| Layer | Technology |
|---|---|
| Framework | Laravel (PHP) |
| Database | MySQL |
| Templating | Blade |
| Architecture | Strategy Pattern |

---

## Project Structure

```
AcademyQuiz/
├── app/
│   ├── Models/                  # Eloquent models
│   ├── Http/Controllers/        # Request handling
│   └── QuestionTypes/           # Strategy pattern — core evaluation logic
│       ├── BinaryType.php
│       ├── SingleChoiceType.php
│       ├── MultipleChoiceType.php
│       ├── NumberType.php
│       ├── TextType.php
│       └── QuestionTypeFactory.php
├── database/
│   └── migrations/              # Database schema definitions
└── resources/
    └── views/                   # Blade templates
```

---

## Core Architecture

AcademyQuiz uses the **Strategy Pattern** to handle evaluation logic for each question type independently.

```
QuestionTypeFactory
       │
       ├── BinaryType
       ├── SingleChoiceType
       ├── MultipleChoiceType
       ├── NumberType
       └── TextType
```

Each question type implements its own evaluation strategy. The factory resolves the correct class at runtime — no hardcoding, no sprawling conditionals. Adding a new question type requires only creating a new class and registering it with the factory.

---

## Database Schema

| Table | Purpose |
|---|---|
| `quizzes` | Stores quiz metadata and status |
| `questions` | Stores questions linked to quizzes |
| `options` | Stores answer options per question |
| `attempts` | Records each user attempt |
| `answers` | Stores user answers per attempt |

---

## Getting Started

### Prerequisites
- PHP >= 8.x
- Composer
- MySQL

### Installation

```bash
# 1. Clone the repository
git clone <your-repo-url>
cd AcademyQuiz

# 2. Install PHP dependencies
composer install

# 3. Set up environment
cp .env.example .env
php artisan key:generate
```

### Database Configuration

Update your `.env` file:

```env
DB_DATABASE=quiz_system
DB_USERNAME=root
DB_PASSWORD=
```

### Run Migrations & Start Server

```bash
php artisan migrate
php artisan serve
```

Visit: [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## Usage Guide

| Step | Action | Route |
|---|---|---|
| 1 | Create a quiz | `/quizzes/create` |
| 2 | Add questions and set marks | Quiz edit page |
| 3 | Attempt a quiz | Quiz attempt page |
| 4 | View result | Auto-evaluated after submission |

Results display per-question correctness and total marks earned.

---

## Author

**Guna Priya**  
Built with Laravel · Strategy Pattern · Clean Architecture