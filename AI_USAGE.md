# AI_USAGE.md

## AI Usage Disclosure — AcademyQuiz

This document transparently describes how AI tools were used during the development of AcademyQuiz, in line with academic and professional integrity standards.

---

## Overview

AI tools were used as a **development assistant** — to accelerate implementation, validate architectural decisions, and improve code quality. All final design choices, integration, debugging, and testing were performed manually.

---

## Table of Contents

- [Where AI Was Used](#where-ai-was-used)
- [Where AI Was Not Used](#where-ai-was-not-used)
- [Sample Prompts Used](#sample-prompts-used)
- [How AI Output Was Handled](#how-ai-output-was-handled)
- [Limitations Encountered](#limitations-encountered)
- [Conclusion](#conclusion)

---

## Where AI Was Used

### 1. Requirement Analysis
AI helped break down the assignment into concrete implementation steps and identify the core design challenge: supporting multiple question types without hardcoding logic per type.

### 2. Architecture Guidance
AI suggested the **Strategy Pattern** as the appropriate design solution and explained how it satisfies the Open/Closed Principle. The final architecture — including class structure, factory design, and interface definition — was implemented and adapted manually.

### 3. Boilerplate Code Generation
AI assisted with generating initial scaffolding for:
- Eloquent model skeletons
- Controller method stubs
- Question type class templates
- Factory pattern structure

All generated code was reviewed, tested, and modified before use.

### 4. Debugging Support
AI was consulted to help identify and resolve specific issues:

| Issue | Resolution |
|---|---|
| `Target class does not exist` in Laravel | Identified missing service provider binding |
| Incorrect multiple-choice evaluation logic | Rewrote comparison to handle array diffing correctly |
| Number/Text type edge cases | Improved trimming and type-casting in evaluation |

### 5. Documentation
AI assisted in structuring and drafting the README, ARCHITECTURE.md, and this file. All content was reviewed and rewritten to accurately reflect the actual system built.

---

## Where AI Was Not Used

The following were completed independently, without AI assistance:

| Area | Details |
|---|---|
| Database schema design | Table structure, column choices, and relationships defined manually |
| Model relationships | Eloquent `hasMany`, `belongsTo` definitions written and verified manually |
| Component integration | Wiring controllers, models, strategies, and views together |
| Blade UI development | All templates designed and built manually |
| Full quiz flow testing | End-to-end testing (create → attempt → evaluate → result) done manually |
| Evaluation logic debugging | Logical errors in scoring identified and fixed through manual debugging |
| Ensuring all 5 types work | Each question type tested individually with real data |

---

## Sample Prompts Used

Representative examples of prompts used during development:

```
"Design a scalable architecture for a Laravel quiz system with multiple question types"
"Implement Strategy Pattern in Laravel for dynamic question evaluation"
"Fix error: Target class does not exist in Laravel service container"
"How to correctly evaluate multiple choice answers where multiple options can be correct"
"Generate a clean README structure for a Laravel project"
```

---

## How AI Output Was Handled

AI-generated output was never used verbatim. The process followed was:

1. **Review** — Read and understand the suggestion before applying it
2. **Evaluate** — Assess whether it fits the actual project structure
3. **Modify** — Adapt the code or explanation to match the real implementation
4. **Test** — Verify it works correctly in context before committing

AI acted as a **sounding board and accelerator**, not a code generator that was copy-pasted into the project.

---

## Limitations Encountered

- Some AI suggestions assumed different Laravel versions or packages not used in this project and required adjustment
- Generated code occasionally had incorrect namespace assumptions that needed manual correction
- AI could not account for project-specific design decisions made early in development — those required human judgment to navigate

---

## Conclusion

AI tools supported this project in the same way a senior developer or documentation resource might — by offering suggestions, explaining patterns, and helping resolve blockers. The architecture, implementation, integration, and testing of AcademyQuiz represent original work, built with a clear understanding of every component involved.