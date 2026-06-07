# Capability Spec: AI Configuration

## Overview
AI Configuration allows users to create, update, and manage AI service settings, including the process name associated with each configuration.

## Requirements

### Functional
- Users must be able to create a new AI configuration via a form.
- Users must be able to edit an existing AI configuration.
- The form must include a field for the process/service name.

## ADDED Requirements

### Requirement: Field name alignment
The system SHALL ensure the frontend form input and JavaScript payload use the same field name that the backend expects.

#### Scenario: Creating a configuration with correct field name
- **WHEN** user submits the AI configuration form
- **THEN** the JavaScript payload sends `process_name` matching the backend validation

#### Scenario: Editing a configuration with correct field name
- **WHEN** user opens the edit modal for an existing configuration
- **THEN** the modal pre-fills the `process_name` field from the backend response

#### Scenario: Displaying configuration cards
- **WHEN** the AI configuration list is rendered
- **THEN** each card displays the `process_name` value from the backend response

## API / Backend Contract
- The controller validates `process_name` as a required string.
- The `IaConfiguration` model has `process_name` in its `$fillable` array.
- The database column is named `process_name`.

## Affected Components
- View: `resources/views/ai-configuration.blade.php`
- Controller: `app/Http/Controllers/IaConfigurationController.php`
- Model: `app/Models/IaConfiguration.php`
