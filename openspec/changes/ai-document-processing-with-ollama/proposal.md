## Why

Document processing is a manual, time-consuming task. Users need to extract text from PDFs (OCR) and analyze document content (e.g., detect if a document is a CV and rate its quality). Integrating Ollama for local AI inference enables private, cost-effective document processing without relying on external APIs.

## What Changes

- Add Ollama model management to download AI models from the Ollama library
- Add PDF document upload functionality with file storage
- Implement OCR process using `glm-ocr:q8_0` model for text transcription
- Implement CV Analysis process to detect CVs and rate quality 0-100
- Add `ia_configuration` database table with model selection, prompts, process name, and status field
- Create web template for document upload and viewing AI process states

## Capabilities

### New Capabilities
- `ollama-model-management`: Download and manage AI models from Ollama library
- `document-upload`: Upload and store PDF documents
- `ocr-process`: Transcribe documents using glm-ocr:q8_0 model
- `cv-analysis`: Detect CVs and rate quality 0-100
- `ia-configuration`: Database table for AI process configuration with status field
- `web-template`: Web interface for uploads and process monitoring

### Modified Capabilities
<!-- No existing capabilities being modified -->

## Impact

- New database migration for `ia_configuration` table with status field and seed data
- New API endpoints or service methods for Ollama integration
- New web routes/templates for document upload UI
- Dependencies: Ollama API client, PDF processing library, file storage