# Design: Fix Field Name Mismatch in AI Configuration

## Change Summary
Rename the frontend field `job` to `process_name` in the AI configuration Blade template and its associated JavaScript payload to match backend validation and the database schema.

## Detailed Design

### 1. Blade Template (`resources/views/ai-configuration.blade.php`)
- **Lines 316–319:** Update the form input for the process name.
  - Change `id="job"` to `id="process_name"`.
  - Update the corresponding `<label for="...">` attribute to `for="process_name"`.
  - Note: the input does not have a `name` attribute (the form is JavaScript-driven, so `name` is not required).
- **Lines 369, 376:** Update the card rendering code that reads `config.job`.
  - Change `${escapeHtml(config.job)}` to `${escapeHtml(config.process_name)}` in both the card badge (line 369) and the card body (line 376).
- **Line 402:** Update the edit-modal population code.
  - Change `document.getElementById('job').value = config.job || '';` to `document.getElementById('process_name').value = config.process_name || '';`.

### 2. JavaScript Payload
- **Lines 434–438:** Update the object sent via `fetch`.
  - Change the selector from `#job` to `#process_name` when reading the input value.
  - Change the payload key from `job` to `process_name`.

### 3. Controller (`app/Http/Controllers/IaConfigurationController.php`)
- No changes required; validation already expects `process_name` (lines 40–45).

### 4. Model (`app/Models/IaConfiguration.php`)
- No changes required; `$fillable` already includes `process_name`.

## Rollback Plan
Revert the attribute changes in the Blade template and the JavaScript payload key.

## Testing Approach
1. Open the AI configuration page.
2. Verify the card list displays the correct `process_name` for each existing configuration.
3. Fill in the process name field.
4. Submit the form.
5. Verify the request payload contains `process_name`.
6. Verify the controller responds with success (no validation error).
7. Verify the database record stores the value under `process_name`.
8. Open the edit modal for an existing configuration and verify the `process_name` field is pre-filled correctly.
9. Save the edited configuration and confirm the updated value persists.
