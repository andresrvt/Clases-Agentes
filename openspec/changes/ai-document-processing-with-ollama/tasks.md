## 1. Database Setup

- [x] 1.1 Create migration for `ia_configuration` table with columns: id, process_name, model_name, prompt_template, status, created_at, updated_at
- [x] 1.2 Create seed data for `ia_configuration` with 'ocr' (glm-ocr:q8_0) and 'cv_analysis' entries
- [x] 1.3 Create migration for `documents` table with columns: id, original_filename, storage_path, file_size, upload_timestamp, ocr_status, ocr_result, cv_analysis_status, cv_is_cv, cv_quality_score
- [x] 1.4 Verify migrations run successfully

## 2. Ollama Service Implementation

- [x] 2.1 Create OllamaService class/service
- [x] 2.2 Implement `connect` method with configurable server URL (default: http://localhost:11434)
- [x] 2.3 Implement `listLocalModels` to GET /api/tags
- [x] 2.4 Implement `pullModel` to POST /api/pull with model name
- [x] 2.5 Implement `deleteModel` to DELETE /api/delete with model name
- [x] 2.6 Implement `generate` to POST /api/generate for inference
- [x] 2.7 Add error handling for connection failures

## 3. Document Upload Service

- [x] 3.1 Create DocumentService class/service
- [x] 3.2 Implement `upload` method for PDF files (validate type, check size <= 10MB)
- [x] 3.3 Implement `store` method to save file to local storage with unique filename
- [x] 3.4 Implement `createDocumentRecord` to insert metadata to database
- [x] 3.5 Implement `getById` to retrieve document with status
- [x] 3.6 Implement `listAll` to return paginated document list
- [x] 3.7 Implement `delete` to remove file and database record

## 4. OCR Process Implementation

- [x] 4.1 Create OcrService class/service
- [x] 4.2 Implement `getConfiguration` to read from ia_configuration where process_name='ocr'
- [x] 4.3 Implement `process` method that:
- [x] 4.4 Implement status tracking (pending → processing → completed/failed)

## 5. CV Analysis Implementation

- [x] 5.1 Create CvAnalysisService class/service
- [x] 5.2 Implement `getConfiguration` to read from ia_configuration where process_name='cv_analysis'
- [x] 5.3 Implement `analyze` method that:
- [x] 5.4 Implement result storage (cv_is_cv, cv_quality_score, cv_analysis_status)
- [x] 5.5 Implement status tracking (pending → processing → completed/failed)

## 6. Web Template Implementation

- [x] 6.1 Create upload page at /documents/upload with form for PDF selection and submit
- [x] 6.2 Create documents list page at /documents showing all documents with status
- [x] 6.3 Create document detail page at /documents/{id} showing:
- [x] 6.4 Add "Run OCR" button trigger on document detail page
- [x] 6.5 Add "Analyze CV" button trigger on document detail page
- [x] 6.6 Add real-time status display (polling with 3-second interval)

## 7. Configuration Management

- [x] 7.1 Add admin API endpoint to update ia_configuration entries
- [x] 7.2 Allow changing model_name per process
- [x] 7.3 Allow changing prompt_template per process
- [x] 7.4 Allow toggling status (active/inactive) per process

## 8. Integration and Testing

- [ ] 8.1 Verify Ollama connection works
- [ ] 8.2 Test PDF upload end-to-end
- [ ] 8.3 Test OCR process with sample PDF
- [ ] 8.4 Test CV Analysis with sample CV document
- [ ] 8.5 Test error handling (invalid file, Ollama unavailable)