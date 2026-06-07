## ADDED Requirements

### Requirement: Ollama server connection
The system SHALL connect to a configurable Ollama server endpoint.

#### Scenario: Connect to Ollama server
- **WHEN** the system needs to interact with Ollama
- **THEN** it SHALL use the server URL from configuration (default: http://localhost:11434)

#### Scenario: Handle connection failure
- **WHEN** Ollama server is unreachable
- **THEN** the system SHALL return an appropriate error message

### Requirement: List available models
The system SHALL list all models available locally in Ollama.

#### Scenario: List models successfully
- **WHEN** user requests available models
- **THEN** the system SHALL query Ollama API at /api/tags
- **AND** return list of locally downloaded models

### Requirement: Download model from library
The system SHALL download AI models from the Ollama library.

#### Scenario: Download model successfully
- **WHEN** user requests to download a model (e.g., glm-ocr:q8_0)
- **THEN** the system SHALL pull the model from Ollama library
- **AND** the model SHALL be available locally for inference

#### Scenario: Download already exists
- **WHEN** user requests to download a model that is already downloaded
- **THEN** the system SHALL indicate the model is already available

### Requirement: List locally available models
The system SHALL list models that are already downloaded locally.

#### Scenario: List local models
- **WHEN** user requests to see locally available models
- **THEN** the system SHALL query Ollama API and return list of downloaded models

### Requirement: Delete local model
The system SHALL delete a locally downloaded model.

#### Scenario: Delete model successfully
- **WHEN** user requests to delete a local model
- **THEN** the system SHALL remove the model from local storage
- **AND** return success confirmation

### Requirement: Model selection for processes
The system SHALL allow configuration of which model to use for each AI process.

#### Scenario: Configure model for OCR
- **WHEN** administrator configures the OCR process
- **THEN** the system SHALL store the model name (default: glm-ocr:q8_0) in ia_configuration table

#### Scenario: Configure model for CV Analysis
- **WHEN** administrator configures the CV Analysis process
- **THEN** the system SHALL store the model name in ia_configuration table