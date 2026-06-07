# Feedback: ai-document-processing-with-ollama

## Status: NEEDS_REVISION

## Coherence: PASS
All 6 proposal capabilities have corresponding specs. Specs are well-aligned with proposal.

## Technical Feasibility: PASS
Ollama direct HTTP API integration is sound. Local storage approach is appropriate.

## Completeness: PASS
All requirements have WHEN/THEN scenarios. Tasks are actionable.

---

## Issues Requiring Resolution

### 1. Missing Timestamps in CV Analysis Results
**File:** `specs/cv-analysis/spec.md:50`
**Issue:** Scenario requires `analysis_timestamp` in results, but database schema has no field to store it.
**Fix:** Add `cv_analysis_timestamp` column to `documents` table in design.md, or remove timestamp from scenario output.

### 2. Misleading Scenario - List Available Models
**File:** `specs/ollama-model-management/spec.md:17-19`
**Issue:** Scenario states "fetch and return list from https://ollama.com/library" but actual behavior is querying Ollama API for locally available models, not the library website.
**Fix:** Clarify that listing returns locally downloaded models via `/api/tags`.

### 3. Missing Storage Path in Document Upload Scenarios
**File:** `specs/document-upload/spec.md:22-26`
**Issue:** Scenarios reference "storage path" but don't specify that the path must be unique. Proposal mentions unique filename but scenarios don't capture this constraint.
**Fix:** Add uniqueness constraint mention to storage scenario.

### 4. Web Template Status Display - Missing Mechanism
**File:** `specs/web-template/spec.md:47-62`
**Issue:** "Real-time status display" (task 6.6) has no specified mechanism (polling, WebSockets, SSE).
**Fix:** Add a Design Decision noting the mechanism (proposed: polling with 3-second interval) or scope the requirement to simple refresh-on-status-change.

---

## Minor Observations

- Design.md Open Question #3 (default model for CV analysis) remains unanswered. Consider resolving or marking as deferred.
- Tasks section 7 (Configuration Management) references admin interface but no UI spec exists for this.

---

## Summary
Core specs are coherent and complete. Address the 4 issues above for full approval.