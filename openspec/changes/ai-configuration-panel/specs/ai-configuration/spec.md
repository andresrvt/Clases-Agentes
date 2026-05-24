## ADDED Requirements

### Requirement: AI configuration panel UI
The system SHALL provide a configuration panel that allows users to select a local AI model, modify the prompt text, and specify a job identifier.

#### Scenario: User views AI configuration panel
- **WHEN** user navigates to the AI configuration panel
- **THEN** system displays current model, prompt, and job values

#### Scenario: User updates AI configuration
- **WHEN** user modifies model, prompt, or job fields and saves
- **THEN** system persists the changes to the `ia_configuration` table

#### Scenario: User cancels configuration changes
- **WHEN** user clicks cancel after modifying fields
- **THEN** system discards changes and restores previous values

### Requirement: AI configuration database table
The system SHALL store AI configuration in a database table named `ia_configuration` with fields: `prompt` (TEXT), `model` (VARCHAR), `job` (VARCHAR).

#### Scenario: Configuration table stores all fields
- **WHEN** system saves AI configuration
- **THEN** all three fields (prompt, model, job) are persisted to the database

#### Scenario: Configuration table supports upsert
- **WHEN** system saves configuration
- **THEN** existing record is updated if present, or created if absent

### Requirement: AI configuration retrieval
The system SHALL provide an API endpoint to retrieve the current AI configuration.

#### Scenario: Retrieve existing configuration
- **WHEN** client requests current AI configuration
- **THEN** system returns prompt, model, and job values from database

#### Scenario: No configuration exists
- **WHEN** client requests AI configuration and no record exists
- **THEN** system returns empty values with default null fields