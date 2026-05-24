---
name: systematic-debugging
description: Root-cause-first debugging methodology. Reproduce, trace execution path, identify root cause, design fix, apply and verify.
license: MIT
compatibility: opencode
metadata:
  audience: developers
  workflow: debugging
---

# Systematic Debugging

Root-cause-first debugging methodology for diagnosing and fixing issues.

## When to Use

Apply this skill when:
- A test is failing unexpectedly
- A bug or error is reported
- Behavior does not match the spec requirements
- An exception or error message needs investigation

## Instructions

### Step 1: Reproduce the Issue

Before any diagnosis:

1. **Reproduce the issue reliably** — you must be able to trigger the problem
2. **Document the reproduction steps** — exact inputs, conditions, environment
3. **Isolate the failure** — narrow down to the smallest case that triggers the issue

If you cannot reproduce the issue:
- Document what you tried
- Note that diagnosis cannot proceed without reproduction
- This is a blocking condition — do NOT proceed to fixing

### Step 2: Trace the Execution Path

1. **Start from the failure point** (error message, test failure, unexpected output)
2. **Trace backwards** through the execution path:
   - What function was called?
   - What inputs did it receive?
   - What state was the system in?
3. **Identify decision points** where the wrong path was taken
4. **Use debugging tools**:
   - Read error messages and stack traces
   - Add logging or print statements at key points
   - Use debugger breakpoints if available
   - Check variable values at each step

### Step 3: Identify the Root Cause

1. **Ask "why" at each level** until you reach the fundamental cause:
   - Why did this function return wrong value? → Because input was wrong
   - Why was input wrong? → Because upstream function computed it incorrectly
   - Why did upstream compute incorrectly? → Because of missing null check (ROOT CAUSE)
2. **Document the root cause** clearly:
   - What is the fundamental issue?
   - Where is it located (file, function, line)?
   - Why does it cause the observed symptom?

### Step 4: Design the Fix

1. **Fix the root cause, not the symptom**
2. **Minimal change principle**: Fix only what's necessary
3. **Consider side effects**: Will this fix affect other functionality?
4. **Plan verification**: How will you confirm the fix works?

### Step 5: Apply and Verify

1. **Apply the fix** to the root cause location
2. **Run the reproduction case** — confirm the symptom is resolved
3. **Run related tests** — confirm no regressions introduced
4. **Document**:
   - Root cause identified: [description]
   - Fix applied: [what was changed]
   - Verification: [tests run, results]

## Anti-Patterns to Avoid

### Band-Aid Fixes

**Wrong approach:**
```
Error: "NullPointerException in processOrder()"
Fix: Add try/catch to suppress the exception
Result: Error hidden, but root cause persists
```

**Correct approach:**
```
Error: "NullPointerException in processOrder()"
Trace: processOrder() → validateOrder() → order.customer is null
Root cause: Customer not loaded before order processing
Fix: Ensure customer is loaded in order creation flow
Verification: Test order creation with customer, test edge cases
```

### Symptom-Based Fixes

**Wrong approach:**
```
Test fails: "Expected 100, got 0"
Fix: Hardcode return value to 100
Result: Test passes, but function broken for other inputs
```

**Correct approach:**
```
Test fails: "Expected 100, got 0"
Trace: calculateTotal() → sumItems() → items array is empty
Root cause: Items not initialized before sum calculation
Fix: Initialize items array in constructor
Verification: Run test, run other calculateTotal tests
```

## Documentation Template

When debugging, document your findings:

```
## Debugging Report

### Issue
[Description of the symptom]

### Reproduction
1. [Step 1]
2. [Step 2]
3. [Trigger condition]

### Execution Trace
- [Function A] called with [inputs]
- [Function B] returned [value]
- [Decision point] chose [wrong path]

### Root Cause
[Fundamental issue at location X]

### Fix Applied
[What was changed and why]

### Verification
- Reproduction case: PASS
- Related tests: [list results]
- No regressions confirmed
```
