# ARCHITECTURE.md

## System Architecture — AcademyQuiz

AcademyQuiz is built on a **layered, pattern-driven architecture** that prioritizes clean separation of concerns, extensibility, and maintainability. The core design challenge — handling multiple question types without conditional sprawl — is solved using the **Strategy Pattern**.

---

## Table of Contents

- [High-Level Design](#high-level-design)
- [Core Components](#core-components)
- [Strategy Pattern — Key Design Decision](#strategy-pattern--key-design-decision)
- [Dynamic Evaluation Flow](#dynamic-evaluation-flow)
- [Separation of Concerns](#separation-of-concerns)
- [Extensibility](#extensibility)
- [Evaluation Logic](#evaluation-logic)
- [Scalability Considerations](#scalability-considerations)
- [Design Trade-offs](#design-trade-offs)
- [Future Improvements](#future-improvements)

---

## High-Level Design

The system follows a classic Laravel layered architecture:

```
Client (Blade Views)
        ↓
Controllers (Request Handling)
        ↓
Models (Eloquent ORM)
        ↓
Database (MySQL)
```

A dedicated **Strategy Pattern layer** sits alongside the Models layer to handle all question evaluation logic independently from the rest of the application.

---

## Core Components

### 1. Models (Data Layer)

| Model | Relationships | Notes |
|---|---|---|
| `Quiz` | Has many Questions, Has many Attempts | Top-level entity |
| `Question` | Belongs to Quiz, Has many Options, Has many Answers | `type` field drives dynamic behavior |
| `Option` | Belongs to Question | Stores answer choices |
| `Attempt` | Belongs to Quiz, Has many Answers | Stores total score |
| `Answer` | Belongs to Attempt, Belongs to Question | Stores user response and evaluation result |

### 2. Database Structure

```
quizzes
   └── questions
         └── options

attempts
   └── answers
```

The schema is fully normalized — quiz structure and user attempt data are cleanly separated, ensuring scalability and query efficiency.

---

## Strategy Pattern — Key Design Decision

### The Problem

Supporting 5 distinct question types (binary, single choice, multiple choice, number, text) without duplicating logic or building unmaintainable `if-else` chains.

### The Solution

A **Strategy Pattern** implementation with:

- A shared interface: `QuestionTypeInterface`
- Five concrete strategy classes:

```
App\QuestionTypes\
   ├── BinaryType.php
   ├── SingleChoiceType.php
   ├── MultipleChoiceType.php
   ├── NumberType.php
   └── TextType.php
```

- A factory to resolve the correct strategy at runtime:

```
App\QuestionTypes\QuestionTypeFactory
```

### Why Not a Switch Statement?

| Approach | Problem |
|---|---|
| `if-else` / `switch` | Violates Open/Closed Principle, grows unmanageably with new types |
| Strategy Pattern | Each type is isolated, testable, and replaceable — no existing code changes needed |

---

## Dynamic Evaluation Flow

When a user submits a quiz, the system evaluates each answer dynamically:

```
1. User submits quiz
2. System iterates through each question
3. For each question, resolves the strategy:

   $handler = QuestionTypeFactory::make($question->type);

4. Strategy evaluates the submitted answer:

   $isCorrect = $handler->evaluate($answer, $question);

5. Results are stored:
   - answers.is_correct
   - answers.marks_awarded
   - attempts.total_score
```

No controller or model contains question-type-specific logic. All evaluation is delegated to the strategy layer.

---

## Separation of Concerns

| Layer | Responsibility |
|---|---|
| Controllers | HTTP request handling, routing to services |
| Models | Data relationships and persistence |
| Strategy Classes | Business logic — question evaluation |
| Views (Blade) | UI rendering only |

Controllers are intentionally thin — they do not contain evaluation logic or question-type conditions.

---

## Extensibility

Adding a new question type requires **only three steps**, with zero changes to existing controllers, models, or database:

**Step 1** — Create the class:
```php
// App\QuestionTypes\TrueFalseExplanationType.php
class TrueFalseExplanationType implements QuestionTypeInterface
{
    public function evaluate($answer, $question): bool
    {
        // custom logic
    }
}
```

**Step 2** — Implement `QuestionTypeInterface`

**Step 3** — Register in the factory:
```php
'true_false_explanation' => new TrueFalseExplanationType()
```

No other files need to change. This fulfills the **Open/Closed Principle** — open for extension, closed for modification.

---

## Evaluation Logic

Each strategy class:

- Receives the user's `$answer` and the `$question` object
- Fetches the correct option(s) from the database
- Compares user input against correct answer(s)
- Returns a boolean result

Marks are then calculated:

```
Correct  →  full marks awarded
Incorrect → zero marks awarded
```

Results stored per-answer (`is_correct`, `marks_awarded`) and aggregated per-attempt (`total_score`).

---

## Scalability Considerations

- Normalized database prevents data redundancy
- Strategy pattern avoids performance-heavy conditionals at evaluation time
- Architecture is API-ready — controllers can be adapted to return JSON for REST or GraphQL endpoints
- Frontend framework integration (React/Vue) is straightforward given the clean separation

---

## Design Trade-offs

| Trade-off | Decision |
|---|---|
| More files (one class per type) | Accepted — clarity and isolation outweigh file count |
| Requires pattern knowledge to contribute | Documented here to lower the barrier |
| Slight factory lookup overhead | Negligible compared to maintainability gains |

---

## Future Improvements

- Partial marking for multiple choice questions
- Negative marking support
- Timed quizzes with countdown
- Pagination for large question sets
- REST API layer (Laravel Sanctum + API Resources)
- User authentication and attempt history
- Question randomization per attempt

---

## Conclusion

AcademyQuiz is architected to be **modular, extensible, and maintainable**. By isolating evaluation logic in strategy classes and resolving them through a factory, the system cleanly handles all current question types and is designed to accommodate new ones with minimal effort and zero regression risk.