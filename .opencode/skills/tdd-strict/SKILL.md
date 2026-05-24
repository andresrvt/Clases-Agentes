---
name: tdd-strict
description: Test-driven development discipline for new code only. Enforces write-test-first, verify-fails, minimal-implementation, verify-passes cycle.
license: MIT
compatibility: opencode
metadata:
  audience: developers
  workflow: implementation
---

# TDD Strict

Test-driven development discipline for new code only.

## When to Use

Apply this skill when:
- Creating new functionality (new functions, classes, modules)
- Implementing new features defined in specs
- Adding new endpoints, handlers, or services

DO NOT apply this skill when:
- Modifying existing code that already has tests
- Fixing bugs in pre-existing code
- Refactoring existing code without changing behavior

## Instructions

### Step 1: Write Test Cases First

Before writing implementation code:

1. **Identify the behavior to implement** from the spec requirements
2. **Write test cases** that define the expected behavior:
   - At least one test for the happy path (normal successful case)
   - At least one test for an edge case (error handling, boundary conditions)
   - Tests should FAIL initially (no implementation exists yet)

### Step 2: Implement to Pass Tests

1. **Write minimal implementation** to make tests pass
2. **Do NOT add extra functionality** beyond what tests require (YAGNI)
3. **Run tests** and verify they pass

### Step 3: Verify Before Completion

Before marking a task as complete:

1. **Run all tests** for the new code
2. **Verify all tests pass** (no failures, no skipped tests)
3. **Document test status** in your task completion notes:
   - Which tests were written
   - Test pass/fail status
   - Any edge cases covered

### Step 4: No Tests for Existing Code

When working with existing code:

1. **DO NOT add tests** for pre-existing code that is not being modified
2. **DO NOT refactor** existing code to make it "testable"
3. **You MAY note** that existing code lacks tests, but this is an observation, not a blocking issue

## Example Workflow

```
Task: Implement user authentication

1. Write tests:
   - test_login_success(): Valid credentials return session token
   - test_login_invalid_password(): Invalid password returns error
   - test_login_missing_fields(): Missing fields return validation error

2. Implement:
   - Create authenticate_user() function
   - Add validation logic
   - Add error handling

3. Verify:
   - Run: pytest tests/auth/test_login.py
   - Result: 3 passed, 0 failed
   - Document: "Tests written: 3 (happy path + 2 edge cases). All pass."

4. Mark task complete
```

## Anti-Patterns to Avoid

- Writing implementation before tests (violates TDD)
- Skipping edge case tests (incomplete coverage)
- Adding tests for existing code outside scope (scope creep)
- Marking task complete with failing tests (quality violation)
- Writing tests that pass trivially without real assertions (fake coverage)
