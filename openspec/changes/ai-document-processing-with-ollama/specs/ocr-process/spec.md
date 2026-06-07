## ADDED Requirements

### Requirement: OCR process execution
The system SHALL transcribe PDF documents using the glm-ocr:q8_0 model.

#### Scenario: Execute OCR on document
- **WHEN** user requests OCR processing for an uploaded document
- **THEN** the system SHALL use glm-ocr:q8_0 model
- **AND** extract text content from the PDF
- **AND** store the transcribed text

#### Scenario: OCR with custom model
- **WHEN** OCR process is configured with a different model
- **THEN** the system SHALL use the configured model instead of default

### Requirement: OCR status tracking
The system SHALL track and report OCR process status.

#### Scenario: Track OCR states
- **WHEN** OCR process starts
- **THEN** status SHALL be set to "processing"
- **WHEN** OCR completes successfully
- **THEN** status SHALL be set to "completed" with transcribed text
- **WHEN** OCR fails
- **THEN** status SHALL be set to "failed" with error message

### Requirement: OCR configuration
The system SHALL use ia_configuration table to get model and prompt settings.

#### Scenario: Load OCR configuration
- **WHEN** OCR process initializes
- **THEN** the system SHALL read model name and prompt from ia_configuration
- **WHERE** process_name = 'ocr'

### Requirement: OCR result storage
The system SHALL persist OCR results.

#### Scenario: Store OCR result
- **WHEN** OCR processing completes
- **THEN** the transcribed text SHALL be stored
- **AND** associated with the original document ID
- **AND** timestamp SHALL be recorded