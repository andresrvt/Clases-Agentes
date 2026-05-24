<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AI Configuration</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <style>
        :root {
            --font-sans: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
            --color-bg: #F7F7F5;
            --color-surface: #FFFFFF;
            --color-text: #1b1b18;
            --color-text-muted: #706f6c;
            --color-border: #e8e8e4;
            --color-primary: #F53003;
            --color-primary-hover: #d42d03;
            --color-accent: #FF4433;
            --color-success: #16a34a;
            --color-card-1: #fef2f2;
            --color-card-2: #f0fdf4;
            --color-card-3: #eff6ff;
        }
        @media (prefers-color-scheme: dark) {
            :root {
                --color-bg: #0a0a0a;
                --color-surface: #161615;
                --color-text: #EDEDEC;
                --color-text-muted: #A1A09A;
                --color-border: #2E2E2A;
                --color-card-1: #1C1917;
                --color-card-2: #14532d1a;
                --color-card-3: #1e3a5f1a;
            }
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: var(--font-sans);
            background: var(--color-bg);
            color: var(--color-text);
            min-height: 100vh;
            padding: 2rem;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--color-border);
        }
        header h1 {
            font-size: 1.75rem;
            font-weight: 600;
        }
        header p {
            color: var(--color-text-muted);
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1rem;
            border: none;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.15s;
        }
        .btn-primary {
            background: var(--color-primary);
            color: white;
        }
        .btn-primary:hover {
            background: var(--color-primary-hover);
        }
        .btn-secondary {
            background: var(--color-surface);
            color: var(--color-text);
            border: 1px solid var(--color-border);
        }
        .btn-secondary:hover {
            background: var(--color-border);
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 1.25rem;
            margin-bottom: 2rem;
        }
        .card {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: 0.75rem;
            padding: 1.25rem;
            transition: all 0.2s;
            cursor: pointer;
        }
        .card:hover {
            border-color: var(--color-primary);
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            transform: translateY(-2px);
        }
        .card.accent-1 { border-left: 3px solid var(--color-accent); }
        .card.accent-2 { border-left: 3px solid var(--color-success); }
        .card.accent-3 { border-left: 3px solid #3b82f6; }
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 0.75rem;
        }
        .card-model {
            font-size: 1rem;
            font-weight: 600;
        }
        .card-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            background: var(--color-bg);
            border-radius: 9999px;
            color: var(--color-text-muted);
        }
        .card-job {
            font-size: 0.875rem;
            color: var(--color-text-muted);
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.375rem;
        }
        .card-job svg {
            width: 14px;
            height: 14px;
        }
        .card-prompt {
            font-size: 0.8125rem;
            color: var(--color-text-muted);
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            background: var(--color-bg);
            padding: 0.75rem;
            border-radius: 0.5rem;
        }
        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            backdrop-filter: blur(4px);
            z-index: 100;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }
        .modal.active { display: flex; }
        .modal-content {
            background: var(--color-surface);
            border-radius: 1rem;
            width: 100%;
            max-width: 500px;
            padding: 1.5rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        .modal-header h2 {
            font-size: 1.25rem;
            font-weight: 600;
        }
        .modal-close {
            width: 32px;
            height: 32px;
            border: none;
            background: var(--color-bg);
            border-radius: 0.5rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--color-text-muted);
        }
        .modal-close:hover {
            background: var(--color-border);
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .form-group label {
            display: block;
            font-size: 0.8125rem;
            font-weight: 500;
            margin-bottom: 0.375rem;
            color: var(--color-text-muted);
        }
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 0.625rem 0.875rem;
            border: 1px solid var(--color-border);
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-family: inherit;
            background: var(--color-bg);
            color: var(--color-text);
            transition: border-color 0.15s;
        }
        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--color-primary);
        }
        .form-group textarea {
            min-height: 100px;
            resize: vertical;
        }
        .form-actions {
            display: flex;
            gap: 0.75rem;
            margin-top: 1.5rem;
        }
        .form-actions .btn {
            flex: 1;
        }
        .message {
            padding: 0.875rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            margin-bottom: 1rem;
            display: none;
        }
        .message.show { display: block; }
        .message.success {
            background: #dcfce7;
            color: #166534;
        }
        .message.error {
            background: #fef2f2;
            color: #991b1b;
        }
        @media (prefers-color-scheme: dark) {
            .message.success { background: #14532d; color: #86efac; }
            .message.error { background: #450a0a; color: #fca5a5; }
        }
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: var(--color-text-muted);
        }
        .empty-state svg {
            width: 48px;
            height: 48px;
            margin-bottom: 1rem;
            opacity: 0.5;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div>
                <h1>AI Configurations</h1>
                <p>Manage your local AI model settings and prompts</p>
            </div>
            <button class="btn btn-primary" onclick="openModal()">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 5v14M5 12h14"/>
                </svg>
                New Configuration
            </button>
        </header>

        <div id="message" class="message"></div>

        <div class="grid" id="config-list">
            <!-- Cards will be loaded here -->
        </div>
    </div>

    <div class="modal" id="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modal-title">New Configuration</h2>
                <button class="modal-close" onclick="closeModal()">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 6L6 18M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div id="form-message" class="message"></div>

            <form id="config-form">
                <input type="hidden" id="config-id">

                <div class="form-group">
                    <label for="model">Model</label>
                    <input type="text" id="model" placeholder="e.g., llama3, mistral, gpt4all" required>
                </div>

                <div class="form-group">
                    <label for="job">Job</label>
                    <input type="text" id="job" placeholder="e.g., text-generation, code-assistant" required>
                </div>

                <div class="form-group">
                    <label for="prompt">Prompt</label>
                    <textarea id="prompt" placeholder="Enter your system prompt..." required></textarea>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const API_URL = '/api/ia-configuration';
        let configs = [];

        async function loadConfigs() {
            try {
                const response = await fetch(API_URL);
                configs = await response.json();
                renderCards();
            } catch (error) {
                showMessage('Failed to load configurations', 'error');
            }
        }

        function renderCards() {
            const container = document.getElementById('config-list');

            if (!configs || configs.length === 0) {
                container.innerHTML = `
                    <div class="empty-state">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.071 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                        <p>No configurations yet. Create your first one!</p>
                    </div>
                `;
                return;
            }

            const accents = ['accent-1', 'accent-2', 'accent-3'];

            container.innerHTML = configs.map((config, index) => `
                <div class="card ${accents[index % accents.length]}" onclick="editConfig(${config.id})">
                    <div class="card-header">
                        <span class="card-model">${escapeHtml(config.model)}</span>
                        <span class="card-badge">${escapeHtml(config.job)}</span>
                    </div>
                    <div class="card-job">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.649z"/>
                            <path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        ${escapeHtml(config.job)}
                    </div>
                    <div class="card-prompt">${escapeHtml(config.prompt)}</div>
                </div>
            `).join('');
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text || '';
            return div.innerHTML;
        }

        function openModal(config = null) {
            const modal = document.getElementById('modal');
            const title = document.getElementById('modal-title');
            const form = document.getElementById('config-form');
            const formMsg = document.getElementById('form-message');

            formMsg.className = 'message';
            formMsg.style.display = 'none';

            if (config) {
                title.textContent = 'Edit Configuration';
                document.getElementById('config-id').value = config.id;
                document.getElementById('model').value = config.model || '';
                document.getElementById('job').value = config.job || '';
                document.getElementById('prompt').value = config.prompt || '';
            } else {
                title.textContent = 'New Configuration';
                form.reset();
                document.getElementById('config-id').value = '';
            }

            modal.classList.add('active');
        }

        function closeModal() {
            document.getElementById('modal').classList.remove('active');
        }

        function editConfig(id) {
            const config = configs.find(c => c.id === id);
            if (config) openModal(config);
        }

        function showMessage(text, type = 'success') {
            const msg = document.getElementById('message');
            msg.textContent = text;
            msg.className = `message ${type} show`;
            setTimeout(() => { msg.classList.remove('show'); }, 4000);
        }

        document.getElementById('config-form').addEventListener('submit', async (e) => {
            e.preventDefault();

            const id = document.getElementById('config-id').value;
            const data = {
                model: document.getElementById('model').value,
                job: document.getElementById('job').value,
                prompt: document.getElementById('prompt').value,
            };

            const formMsg = document.getElementById('form-message');
            const method = id ? 'PUT' : 'POST';
            const url = id ? API_URL : API_URL;

            try {
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (!response.ok) throw new Error(result.message || 'Save failed');

                closeModal();
                loadConfigs();
                showMessage('Configuration saved successfully!');
            } catch (error) {
                formMsg.textContent = error.message || 'Failed to save configuration';
                formMsg.className = 'message error show';
            }
        });

        document.getElementById('modal').addEventListener('click', (e) => {
            if (e.target.id === 'modal') closeModal();
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeModal();
        });

        loadConfigs();
    </script>
</body>
</html>