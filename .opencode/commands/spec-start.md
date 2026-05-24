---
description: Start the multi-agent spec pipeline. Creates an OpenSpec change, initializes the pipeline state, and invokes the orchestrator to begin the 5-phase workflow.
---

Start the multi-agent spec pipeline for a new feature.

**Input**: The argument after `/spec-start` is a description of what the user wants to build.

**Steps**

1. **Check prerequisites**

   Before doing anything, verify the environment:

   a. Check openspec CLI is available:
   ```bash
   openspec --version
   ```
   If this fails, show:
   ```
   Error: OpenSpec CLI is required but not found in PATH.
   Install with: npm install -g @fission-ai/openspec
   ```
   And abort.

   b. Check all 6 agent files exist:
   - `.opencode/agents/spec-orchestrator.md`
   - `.opencode/agents/spec-designer.md`
   - `.opencode/agents/spec-validator.md`
   - `.opencode/agents/spec-developer.md`
   - `.opencode/agents/spec-qa.md`
   - `.opencode/agents/spec-documenter.md`

    If any are missing, list them and ask: "Some agent files are missing. Create them first, or would you like to proceed anyway (some phases may not work)?"

    c. Check model availability:
      - The pipeline requires the following models: `alibaba-coding-plan/qwen3.6-plus` (used by designer, validator, QA, documenter) and `alibaba-coding-plan/glm-5` (used by developer)
      - Verify these models are configured in the user's OpenCode settings
     - If a model is not available, warn the user and record the fallback warning:
       ```
       Warning: Model '<model>' is required by the pipeline but may not be available in your configuration.
       The pipeline will fallback to your default model, which may affect quality.
       ```
     - Record the fallback warning in status.json history (see step 6) with format:
       ```json
       {
         "type": "model_fallback",
         "model": "<model>",
         "reason": "not configured",
         "fallback_to": "default",
         "timestamp": "<ISO8601>"
       }
       ```
     - If BOTH models are unavailable, offer to proceed with default model or abort

    d. Validate model format in agent files:
    - Read each agent file's frontmatter and check the `model` field
    - Valid format: `provider/model-id` (e.g., `alibaba-coding-plan/qwen3.6-plus`)
    - Invalid format: bare model name without provider prefix (e.g., `qwen3.6-plus`, `glm-5`)
    - For each agent with invalid model format:
      ```
      Warning: Agent '<agent-name>' has invalid model format: 'model: <value>'
      Expected format: 'model: provider/model-id' (e.g., 'model: alibaba-coding-plan/qwen3.6-plus')
      The pipeline may fail with ProviderModelNotFoundError if this is not corrected.
      ```
    - If ANY agent has invalid model format, ask the user:
      > "Some agent files have incomplete model formats. This may cause errors during pipeline execution. Would you like to (1) Fix them now, (2) Proceed anyway (may fail), or (3) Abort?"
    - If user chooses "Fix them now", provide guidance on the correct format for each affected agent

 2. **If no input provided, ask what they want to build**

   Use the **AskUserQuestion tool** (open-ended, no preset options) to ask:
   > "What feature do you want to build through the multi-agent pipeline? Describe what you want."

   **IMPORTANT**: Do NOT proceed without understanding what the user wants to build.

3. **Derive change name**

   From the user's description, derive a kebab-case name (e.g., "add user authentication" → `add-user-auth`).

4. **Check if change already exists**

   ```bash
   openspec status --change "<name>" --json
   ```

   If the change exists and has a `.pipeline/status.json`, announce: "Found existing pipeline for this change. Resuming from current state." and read the status.json to determine where to resume.

   If the change exists but has no pipeline, suggest using a different name or continuing the existing change.

5. **Create the OpenSpec change** (if it doesn't exist)

   ```bash
   openspec new change "<name>"
   ```

6. **Initialize pipeline infrastructure**

     Create the `.pipeline/` directory structure inside the change:
     ```
     openspec/changes/<name>/.pipeline/
     ├── status.json
     ├── feedback/    (empty)
     ├── qa/          (empty)
     └── notes/       (empty)
     ```

     Create `status.json` with initial state:
     ```json
     {
       "change": "<name>",
       "phase": "design",
       "iteration": 1,
       "history": []
     }
     ```
     
     If any model fallback warnings were generated in step 1c, add them to the history array before saving:
     ```json
     {
       "change": "<name>",
       "phase": "design",
       "iteration": 1,
       "history": [
         {
           "type": "model_fallback",
           "model": "<model>",
           "reason": "not configured",
           "fallback_to": "default",
           "timestamp": "<ISO8601>"
         }
       ]
     }
     ```

7. **Announce pipeline start**

    Display to the user:
    ```
    Multi-Agent Spec Pipeline Started

    Change: <name>
    Phase: Design (1/7)
    Agents: orchestrator → designer → validator → developer → qa → documenter

    Phases:
    1. Design       - Create specs, validate with reviewer loop
    2. Development  - Implement tasks
    3. QA           - Verify implementation against specs (+ /opsx-verify)
    4. Reconciliation - Update specs to match implementation
    5. Documentation - Generate docs, verify consistency
    6. User Review  - Final review, option to request changes (full cycle restart)
    7. Cleanup      - Clean pipeline files → sync specs → archive

    Starting Phase 1: Design...
    ```

8. **Invoke the orchestrator**

    Switch to the `spec-orchestrator` agent or invoke it to begin the pipeline. The orchestrator will:
    - Invoke spec-designer to create artifacts
    - Invoke spec-validator to review BEFORE showing to user
    - Present validated artifacts for user approval
    - Run the full 7-phase pipeline

**Guardrails**
- Do NOT skip the pipeline - the orchestrator manages all phases
- If a change with the same name exists, check for existing pipeline and resume
- Ensure kebab-case naming convention
- The orchestrator handles all agent coordination - do not invoke agents directly
