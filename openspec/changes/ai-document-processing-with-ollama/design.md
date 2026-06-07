## Context

This change introduces an AI document processing service that leverages Ollama for local LLM inference. The system processes PDF documents through two AI-powered stages: OCR (text transcription) and CV analysis. The service is designed for privacy-sensitive environments where documents should not be sent to external APIs.

**Current State:** No existing AI document processing capabilities.
**Constraints:** Must use Ollama for local inference, must integrate with existing web framework.
**Stakeholders:** End users uploading documents, administrators configuring AI processes.

## Goals / Non-Goals

**Goals:**
- Enable downloading AI models from Ollama library
- Support PDF document upload and storage
- Provide OCR transcription using glm-ocr:q8_0 model
- Detect CVs and rate quality 0-100
- Configure AI processes via database table
- Provide web interface for upload and monitoring

**Non-Goals:**
- Real-time streaming of AI responses (batch processing only)
- Multiple file formats beyond PDF
- Cloud storage integration (local storage only)
- User authentication/authorization (handled by existing system)

## Decisions

### Decision 1: Ollama Integration Architecture

**Choice:** Direct HTTP API calls to Ollama REST endpoint.

**Rationale:** Ollama exposes a well-documented REST API. Using direct HTTP calls avoids additional library dependencies and provides full control over model management.

**Alternative:** Use official Ollama SDK/libraries.
- **Rejected because:** SDKs may lag behind API features, add complexity, or not exist for our stack.

### Decision 2: Document Storage

**Choice:** Local filesystem storage with database metadata tracking.

**Rationale:** Simple, sufficient for the use case, avoids external storage dependencies.

**Alternative:** Cloud object storage (S3-compatible).
- **Rejected because:** Adds infrastructure complexity and cost for what can be handled locally.

### Decision 3: OCR Model Selection

**Choice:** glm-ocr:q8_0 model for OCR.

**Rationale:** Quantized model (Q8) provides good quality-to-speed tradeoff. Ollama library model simplifies deployment.

**Alternative:** Use general LLM for OCR.
- **Rejected because:** Specialized OCR models outperform general models for text extraction tasks.

### Decision 4: Database Schema Design

**Choice:** Single `ia_configuration` table with process_name, model_name, prompt_template, status.

**Rationale:** Simple key-value configuration per process. Status field enables enable/disable without deletion.

**Alternative:** Separate tables per process.
- **Rejected because:** Overly complex for simple configuration needs.

### Decision 5: Async Processing

**Choice:** Synchronous processing with status tracking.

**Rationale:** Simplifies implementation. For initial version, requests can wait for completion.

**Alternative:** Background job queue (Redis, RabbitMQ, etc.).
- **Deferred:** Can be added later if response times become problematic.

### Decision 6: Real-time Status Updates

**Choice:** Polling with 3-second interval.

**Rationale:** Simple to implement, sufficient for the use case. Status pages refresh every 3 seconds to check for updates.

**Alternative:** WebSockets or SSE.
- **Deferred:** Can be replaced later if real-time requirements increase.

## Data Flow

```
[Web UI] --> [Document Upload] --> [File Storage + DB Record]
                                              |
                                              v
                                    [OCR Process Request]
                                              |
                                              v
                              [Ollama API: glm-ocr:q8_0]
                                              |
                                              v
                                    [Store Transcribed Text]
                                              |
                                              v
                                  [CV Analysis Process Request]
                                              |
                                              v
                              [Ollama API: configured model]
                                              |
                                              v
                              [Store: is_cv, quality_score]
                                              |
                                              v
                                    [Web UI: Display Results]
```

## Database Schema

### Table: ia_configuration

| Column | Type | Constraints |
|--------|------|-------------|
| id | SERIAL | PRIMARY KEY |
| process_name | VARCHAR(100) | UNIQUE, NOT NULL |
| model_name | VARCHAR(255) | NOT NULL |
| prompt_template | TEXT | NULLABLE |
| status | VARCHAR(20) | NOT NULL, DEFAULT 'active' |
| created_at | TIMESTAMP | DEFAULT NOW() |
| updated_at | TIMESTAMP | DEFAULT NOW() |

**Status Values:** 'active', 'inactive'

### Table: documents

| Column | Type | Constraints |
|--------|------|-------------|
| id | SERIAL | PRIMARY KEY |
| original_filename | VARCHAR(255) | NOT NULL |
| storage_path | VARCHAR(500) | NOT NULL, UNIQUE |
| file_size | INTEGER | NOT NULL |
| upload_timestamp | TIMESTAMP | DEFAULT NOW() |
| ocr_status | VARCHAR(20) | DEFAULT 'pending' |
| ocr_result | TEXT | NULLABLE |
| cv_analysis_status | VARCHAR(20) | DEFAULT 'pending' |
| cv_is_cv | BOOLEAN | NULLABLE |
| cv_quality_score | INTEGER | NULLABLE |
| cv_analysis_timestamp | TIMESTAMP | NULLABLE |

**Process Status Values:** 'pending', 'processing', 'completed', 'failed'

## API Design

### Ollama Endpoints Used

- `GET /api/tags` - List locally available models
- `POST /api/pull` - Pull model from library
- `DELETE /api/delete` - Delete local model
- `POST /api/generate` - Run inference

### Internal Service Layer

- `OllamaService` - Model management (list, pull, delete)
- `DocumentService` - Document CRUD operations
- `OcrService` - OCR processing logic
- `CvAnalysisService` - CV detection and rating

## Migration

1. Create `ia_configuration` table with migration
2. Seed default configurations for 'ocr' and 'cv_analysis'
3. Create `documents` table for document tracking
4. No rollback needed for initial setup (forward-only migration)

## Risks / Trade-offs

| Risk | Mitigation |
|------|------------|
| Ollama not installed on system | Document installation requirements; check connectivity before operations |
| Large PDFs cause timeouts | Set reasonable timeout limits; consider async processing in future |
| Model download is slow | Show progress feedback; use smaller quantized models |
| OCR quality varies by PDF quality | Document expected input quality;glm-ocr is generally robust |
| Database growth with many documents | Implement document retention policy; allow deletion |

## Open Questions

1. What is the maximum PDF file size limit? (Proposed: 10MB)
2. Should OCR be automatic on upload or manual trigger? (Proposed: Manual trigger)
3. What should be the default model for CV analysis? (Proposed: llama3.2, deferred for config)
4. Should we cache Ollama model listings or refresh every time? (Proposed: Cache for 5 minutes)