## ADDED Requirements

### Requirement: CV detection
The system SHALL determine if a transcribed document is a CV/resume.

#### Scenario: Detect CV document
- **WHEN** user requests CV analysis on transcribed text
- **THEN** the system SHALL analyze the content
- **AND** return is_cv (boolean) indicating if document is a CV

#### Scenario: Non-CV document
- **WHEN** CV analysis is performed on a non-CV document
- **THEN** the system SHALL return is_cv = false

### Requirement: CV quality rating
The system SHALL rate CV quality on a scale of 0-100.

#### Scenario: Rate CV quality
- **WHEN** CV analysis is performed on a document identified as CV
- **THEN** the system SHALL provide a quality score from 0 to 100
- **AND** higher scores indicate better quality

#### Scenario: Quality rating for non-CV
- **WHEN** CV analysis is performed on a non-CV document
- **THEN** quality rating SHALL be null or not applicable

### Requirement: CV analysis using Ollama
The system SHALL use Ollama models to interpret transcribed documents.

#### Scenario: Analyze with configured model
- **WHEN** CV analysis is requested
- **THEN** the system SHALL use the model configured in ia_configuration
- **WHERE** process_name = 'cv_analysis'

### Requirement: CV analysis status tracking
The system SHALL track CV analysis process status.

#### Scenario: Track CV analysis states
- **WHEN** CV analysis starts
- **THEN** status SHALL be set to "processing"
- **WHEN** analysis completes successfully
- **THEN** status SHALL be set to "completed" with results
- **WHEN** analysis fails
- **THEN** status SHALL be set to "failed" with error message

### Requirement: CV analysis results
The system SHALL return structured analysis results.

#### Scenario: Return analysis results
- **WHEN** CV analysis completes
- **THEN** results SHALL include: is_cv (boolean), quality_score (0-100), cv_analysis_timestamp