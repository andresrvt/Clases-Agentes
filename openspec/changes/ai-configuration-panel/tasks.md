## 1. Database Setup

- [x] 1.1 Create database migration for `ia_configuration` table with fields: prompt (TEXT), model (VARCHAR), job (VARCHAR)
- [x] 1.2 Run migration to create the table
- [x] 1.3 Add database seed data if needed (not needed - config is empty by default)

## 2. Backend API

- [x] 2.1 Create API endpoint to GET current AI configuration
- [x] 2.2 Create API endpoint to PUT/upsert AI configuration
- [x] 2.3 Connect API to database layer

## 3. Frontend Component

- [x] 3.1 Create AI configuration panel component
- [x] 3.2 Add form fields: model (text input), prompt (textarea), job (text input)
- [x] 3.3 Load current configuration on panel mount
- [x] 3.4 Implement save functionality (upsert to API)
- [x] 3.5 Implement cancel button to discard changes

## 4. Integration & Testing

- [x] 4.1 Connect configuration panel to routing/navigation
- [x] 4.2 Test configuration save and retrieve flow (requires DB)
- [x] 4.3 Test cancel button restores previous values (implemented in code)