## Context

The system needs a configuration interface for managing local AI model settings. Users want to select different AI models and customize prompts without modifying code. The implementation requires a database-backed configuration storage and a user interface for managing these settings.

## Goals / Non-Goals

**Goals:**
- Provide a UI panel to select local AI models
- Allow customization of the prompt text
- Store configuration persistently in the database
- Support CRUD operations for AI configuration

**Non-Goals:**
- Implementing AI model execution or API integration
- User authentication or authorization for configuration access
- Model performance benchmarking or validation

## Decisions

1. **Database table `ia_configuration`**
   - Fields: `prompt` (TEXT), `model` (VARCHAR), `job` (VARCHAR)
   - Single row configuration approach (upsert pattern)
   - Rationale: Simple key-value style configuration that can evolve to multi-row if needed

2. **Frontend component structure**
   - Dedicated configuration panel component
   - Form inputs for prompt (textarea), model (dropdown/input), job (text input)
   - Save/Cancel actions with visual feedback

3. **Backend integration**
   - API endpoint to fetch current configuration
   - API endpoint to update configuration
   - Uses existing service layer patterns

## Risks / Trade-offs

- [Risk] Model names may vary by setup → Mitigation: Use free-text input for model selection, not a fixed dropdown
- [Risk] Long prompts may exceed field size → Mitigation: Use TEXT type for prompt field (no length limit)

## Migration Plan

1. Run database migration to create `ia_configuration` table
2. Deploy backend API changes
3. Deploy frontend component
4. Verify configuration loads correctly in UI

## Open Questions

- Should there be multiple configuration profiles (dev/prod)?
- Do we need to validate the model name against available local models?