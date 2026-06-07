## ADDED Requirements

### Requirement: ia_configuration table structure
The system SHALL have a database table ia_configuration to store AI process settings.

#### Scenario: Configuration table exists
- **WHEN** the system is initialized
- **THEN** there SHALL be an ia_configuration table with columns:
  - id (primary key)
  - process_name (unique, not null)
  - model_name (not null)
  - prompt_template (text)
  - status (not null, default 'active')
  - created_at
  - updated_at

### Requirement: Configuration entries for AI processes
The system SHALL store configuration for each AI process.

#### Scenario: Store OCR configuration
- **WHEN** OCR process is configured
- **THEN** a record SHALL be created/updated with:
  - process_name = 'ocr'
  - model_name = 'glm-ocr:q8_0'
  - status = 'active' or 'inactive'

#### Scenario: Store CV Analysis configuration
- **WHEN** CV Analysis process is configured
- **THEN** a record SHALL be created/updated with:
  - process_name = 'cv_analysis'
  - model_name (configurable)
  - prompt_template (configurable)
  - status = 'active' or 'inactive'

### Requirement: Status field for process control
The system SHALL support enabling/disabling processes via status field.

#### Scenario: Check process status
- **WHEN** a process is about to execute
- **THEN** the system SHALL check the status field
- **AND** only execute if status = 'active'

#### Scenario: Deactivate process
- **WHEN** administrator sets process status to 'inactive'
- **THEN** that process SHALL NOT execute new operations

### Requirement: Database migration
The system SHALL provide a migration to add the ia_configuration table.

#### Scenario: Run migration
- **WHEN** migration is executed
- **THEN** the ia_configuration table SHALL be created with all required columns

### Requirement: Seed data
The system SHALL provide seed data for default configuration.

#### Scenario: Seed default configuration
- **WHEN** seed data is loaded
- **THEN** there SHALL be entries for:
  - ocr process with glm-ocr:q8_0 model
  - cv_analysis process with default model
  - Both with status = 'active'