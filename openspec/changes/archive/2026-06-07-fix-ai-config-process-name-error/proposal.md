# Proposal: Fix AI Configuration Field Name Mismatch

## Why
When creating or updating an AI configuration, the frontend sends the field `job`, but the backend expects `process_name`. This mismatch causes validation errors and prevents saving configurations, blocking users from creating new AI configurations.

## What Changes
- Align the frontend with the backend by renaming the form input and JavaScript payload key from `job` to `process_name` in `resources/views/ai-configuration.blade.php`.
- Update card display and edit-modal references to use `process_name`.
- No backend or database changes are required.

## Root Cause
- The Blade template uses `id="job"` on the form input.
- The JavaScript payload sends `job: ...` to the backend.
- The controller validates `process_name`.
- The model's `fillable` array and migration use `process_name`.

## Impact
- Fixes the validation error on AI configuration creation.
- No database schema changes required.
- Minimal, low-risk change confined to the AI configuration view and its JavaScript.
