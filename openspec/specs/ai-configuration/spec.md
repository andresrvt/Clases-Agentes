# ai-configuration Specification

## Purpose
TBD - created by archiving change fix-ai-config-process-name-error. Update Purpose after archive.
## Requirements
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

