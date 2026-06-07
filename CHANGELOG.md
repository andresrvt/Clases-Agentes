# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Fixed

- **AI Configuration – Process Name Field Alignment**  
  Fixed a frontend-backend field name mismatch in `resources/views/ai-configuration.blade.php` where the Blade template and JavaScript payload used `job` instead of `process_name`. Aligning the frontend to the backend expectation (`process_name`) resolves validation errors when creating or updating AI configurations. No database schema or backend changes were required.  
  *Change:* `fix-ai-config-process-name-error`  
  *Reviewed & approved via QA Report on 2026-06-07.*
