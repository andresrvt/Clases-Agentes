---
name: code-review-scope-fence
description: Differentiated review instructions: strict for new code, observe-only for existing code. Prevents blocking progress on technical debt.
license: MIT
compatibility: opencode
metadata:
  audience: developers, reviewers
  workflow: code-review
---

# Code Review Scope Fence

Differentiated review instructions: strict for new code, observe-only for existing code.

## Core Principle

**Process dogmatism, not codebase purity.**

We enforce strict quality standards for NEW code because that's the process we control. We do NOT block progress because existing code has issues — that would prevent any forward movement in projects with technical debt.

## When to Use

Apply this skill when:
- Reviewing code during QA phase
- Reviewing implementation during development
- Evaluating code quality in validation phase
- Any code review activity that could affect task/phase completion

## Instructions

### Step 1: Identify Scope Boundary

Before reviewing, determine which code is in scope:

1. **Read the change context**:
   - tasks.md defines what should be implemented
   - specs/ defines requirements for new functionality
   - design.md defines technical approach

2. **Identify new/modified code**:
   - Files created in this change
   - Files modified in this change (check git diff if available)
   - Functions/classes added or significantly changed

3. **Identify existing code**:
   - Files that existed before this change
   - Code that is read for context but not modified
   - Dependencies and imports from existing modules

### Step 2: Apply Strict Review to New Code

For code created or modified in the current change:

**Check these standards (blocking if violated):**

1. **Naming conventions**
   - Consistent with project style
   - Meaningful, descriptive names
   - No abbreviations unless project-standard

2. **Error handling**
   - Appropriate try/catch for operations that can fail
   - Clear error messages
   - Graceful degradation where applicable

3. **Pattern compliance**
   - Follows existing project patterns
   - Uses established conventions (no introducing new patterns)
   - Consistent with architecture in design.md

4. **TDD coverage** (for new functionality)
   - Tests exist for new functions/classes
   - Tests cover happy path and edge cases
   - All tests pass

5. **Code quality**
   - No obvious bugs or logic errors
   - No dead code or unused imports
   - Readable and maintainable

**Report violations as ISSUES:**
```
1. **[critical/major]** Missing error handling in processPayment()
   - Location: src/payment.js:45
   - Problem: No try/catch for API call that can fail
   - Suggestion: Add error handling with retry logic
```

### Step 3: Apply Observation Mode to Existing Code

For pre-existing code not modified in the current change:

**You MAY note issues, but they are NON-BLOCKING:**

1. **Record as observations, not issues**
2. **Clearly label as "observation"**
3. **Do NOT require fixes before task completion**
4. **Do NOT block phase progression**

**Report observations separately:**
```
### Observations on Existing Code

1. **[observation]** Missing tests in legacy auth module
   - Location: src/auth/legacy.js
   - Note: This module lacks unit tests. Consider adding in future work.
   - Action: None required for current change

2. **[observation]** Inconsistent naming in utils.js
   - Location: src/utils.js:12-50
   - Note: Some functions use camelCase, others use snake_case
   - Action: None required for current change
```

### Step 4: Separate Reporting

In your review output, maintain clear separation:

**Issues section** (blocking):
- Only problems in new/modified code
- Must be fixed before approval
- Severity: critical, major, minor

**Observations section** (non-blocking):
- Notes about existing code quality
- Do not affect approval status
- Label clearly as "observation"

## Decision Matrix

| Code Type | Standard Violation | Report As | Blocks Progress? |
|-----------|-------------------|-----------|------------------|
| New code | Naming convention | Issue | Yes (minor) |
| New code | Missing error handling | Issue | Yes (major) |
| New code | No tests | Issue | Yes (major) |
| New code | Pattern violation | Issue | Yes (major) |
| Existing code | Any quality issue | Observation | No |
| Existing code | Missing tests | Observation | No |
| Existing code | Bad naming | Observation | No |

## Example Application

### Scenario: Adding new export feature

**New code (strict review):**
- `src/export/csv.js` — created in this change
- `src/export/formatter.js` — created in this change
- Tests in `tests/export/` — created in this change

**Existing code (observation mode):**
- `src/utils/file-helpers.js` — imported but not modified
- `src/config/settings.js` — read for config values
- `src/auth/user.js` — used for permission check

**Review output:**

```
### Issues Found (New Code)

1. **[major]** Missing null check in csv.js:formatRow()
   - Location: src/export/csv.js:23
   - Problem: row.data accessed without null check
   - Suggestion: Add guard: if (!row.data) return emptyRow

### Observations on Existing Code

1. **[observation]** file-helpers.js lacks error handling
   - Location: src/utils/file-helpers.js:15
   - Note: readFile() has no error handling for missing files
   - Action: Consider improving in future work (not blocking)

2. **[observation]** settings.js uses inconsistent casing
   - Location: src/config/settings.js
   - Note: Mix of camelCase and snake_case in property names
   - Action: None required for current change
```

## Anti-Patterns to Avoid

- Treating existing code issues as blocking (scope creep)
- Ignoring quality issues in new code (quality degradation)
- Mixing issues and observations in same section (confusion)
- Refactoring existing code "while you're there" (scope creep)
- Adding tests for existing code outside scope (scope creep)
