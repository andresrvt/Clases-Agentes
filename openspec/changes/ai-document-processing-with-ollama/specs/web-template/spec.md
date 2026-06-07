## ADDED Requirements

### Requirement: Document upload web page
The system SHALL provide a web page for uploading PDF documents.

#### Scenario: Access upload page
- **WHEN** user navigates to /documents/upload
- **THEN** the system SHALL display an upload form with file selection

#### Scenario: Upload PDF via web form
- **WHEN** user selects a PDF file and submits the upload form
- **THEN** the system SHALL upload and store the document
- **AND** display success message with document ID

### Requirement: Document list web page
The system SHALL provide a web page listing all uploaded documents.

#### Scenario: Access documents list
- **WHEN** user navigates to /documents
- **THEN** the system SHALL display a list of all documents
- **AND** show filename, upload date, and processing status for each

### Requirement: Document detail web page
The system SHALL provide a web page showing document details and AI processing states.

#### Scenario: Access document detail
- **WHEN** user navigates to /documents/{id}
- **THEN** the system SHALL display:
  - Document metadata (filename, size, upload date)
  - AI process states (OCR status, CV Analysis status)
  - Transcribed text (if OCR completed)
  - CV analysis results (if analysis completed)

### Requirement: AI process triggers
The system SHALL allow triggering AI processes from the web interface.

#### Scenario: Trigger OCR from web
- **WHEN** user clicks "Run OCR" on a document
- **THEN** the system SHALL initiate OCR processing
- **AND** update the UI with processing status

#### Scenario: Trigger CV Analysis from web
- **WHEN** user clicks "Analyze CV" on a document
- **THEN** the system SHALL initiate CV analysis
- **AND** update the UI with results when complete

### Requirement: AI process state display
The system SHALL display real-time status of AI processes.

#### Scenario: Show processing state
- **WHEN** document is being processed
- **THEN** the UI SHALL show "Processing..." status

#### Scenario: Show completed state
- **WHEN** OCR process completes
- **THEN** the UI SHALL show "Completed" status
- **AND** display the transcribed text

#### Scenario: Show failed state
- **WHEN** AI process fails
- **THEN** the UI SHALL show "Failed" status
- **AND** display error message