# Feedback: ai-document-processing-with-ollama (Iteration 2)

## Status: NEEDS_REVISION

## Summary
3 of 4 issues from feedback-v1.md are properly fixed. Issue #3 (storage path uniqueness) was not corrected.

---

## Approved Fixes

### Issue 1: Missing cv_analysis_timestamp field - FIXED
- `design.md:138` - Field added to documents table
- `cv-analysis/spec.md:50` - Scenario includes timestamp in results

### Issue 2: Misleading "list from library" scenario - FIXED
- `ollama-model-management/spec.md:17-21` - Correctly references `/api/tags` for locally available models

### Issue 4: Real-time status display mechanism - FIXED
- `design.md:72-79` - Decision 6 documents polling with 3-second interval

---

## Remaining Issue

### Issue 3: Storage Path Uniqueness - NOT FIXED
**File:** `design.md:130`
**Problem:** The `documents` table schema still shows `storage_path` without a UNIQUE constraint:
```
| storage_path | VARCHAR(500) | NOT NULL |
```
**Required Fix:** Add UNIQUE constraint:
```
| storage_path | VARCHAR(500) | NOT NULL, UNIQUE |
```

---

## Validation Summary

| Criteria | Status |
|----------|--------|
| Fixed issues actually resolved | 3/4 |
| No regressions introduced | PASS |
| All 6 capabilities have specs | PASS |
| Tasks remain actionable | PASS |
| WHEN/THEN scenarios present | PASS |

---

## Next Steps
Add UNIQUE constraint to `storage_path` in the documents table schema (design.md:130) to achieve full approval.