# Tasks: Fix AI Configuration Process Name Error

- [x] Update Blade template input attributes (`id`, `for`) from `job` to `process_name` in `resources/views/ai-configuration.blade.php` (lines 316–319).
- [x] Update card badge display from `config.job` to `config.process_name` in `resources/views/ai-configuration.blade.php` (line 369).
- [x] Update card body display from `config.job` to `config.process_name` in `resources/views/ai-configuration.blade.php` (line 376).
- [x] Update edit-modal population from `document.getElementById('job').value = config.job || '';` to `document.getElementById('process_name').value = config.process_name || '';` in `resources/views/ai-configuration.blade.php` (line 402).
- [x] Update JavaScript payload key from `job` to `process_name` and adjust the DOM selector in `resources/views/ai-configuration.blade.php` (lines 434–438).
- [x] Verify the controller validation rules in `app/Http/Controllers/IaConfigurationController.php` still reference `process_name` (lines 40–45).
- [x] Verify the model `$fillable` array in `app/Models/IaConfiguration.php` includes `process_name`.
- [x] Test creating a new AI configuration via the UI and confirm no validation errors.
- [x] Test editing an existing AI configuration and confirm the value persists correctly.
- [x] Run existing automated tests (if any) for the IA configuration controller.
