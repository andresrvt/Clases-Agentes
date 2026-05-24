## Why

Users need a way to configure which local AI model to use and customize the prompt behavior for their agents. Currently there's no UI to manage these settings, forcing developers to modify configuration files directly.

## What Changes

- New configuration panel UI to select and manage local AI models
- Database table `ia_configuration` for persistent storage of AI settings
- Fields: `prompt` (text), `model` (string), `job` (string)
- Frontend form to view/edit these configuration values

## Capabilities

### New Capabilities
- `ai-configuration`: Interface for managing AI model selection and prompt customization. Covers the configuration panel UI and database storage for prompt, model, and job settings.

### Modified Capabilities
<!-- No existing spec requirements change -->

## Impact

- New database table: `ia_configuration`
- New frontend component: AI configuration panel
- Backend routes for CRUD operations on AI configuration