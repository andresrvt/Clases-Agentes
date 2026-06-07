<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Subir Documento - AI Document Processing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --bg-light: #f8fafc;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .main-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            max-width: 500px;
            width: 100%;
        }
        
        .card-header-custom {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            padding: 30px;
            text-align: center;
        }
        
        .card-header-custom i {
            font-size: 48px;
            color: white;
            margin-bottom: 15px;
        }
        
        .card-header-custom h2 {
            color: white;
            margin: 0;
            font-weight: 600;
        }
        
        .card-header-custom p {
            color: rgba(255,255,255,0.8);
            margin: 10px 0 0;
        }
        
        .card-body-custom {
            padding: 40px;
        }
        
        .upload-zone {
            border: 2px dashed #e2e8f0;
            border-radius: 16px;
            padding: 40px;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            background: #f8fafc;
        }
        
        .upload-zone:hover {
            border-color: var(--primary);
            background: #f0f4ff;
        }
        
        .upload-zone.dragover {
            border-color: var(--primary);
            background: #e0e7ff;
            transform: scale(1.02);
        }
        
        .upload-zone i {
            font-size: 56px;
            color: #94a3b8;
            margin-bottom: 15px;
        }
        
        .upload-zone.dragover i {
            color: var(--primary);
        }
        
        .upload-zone p {
            color: #64748b;
            margin: 0;
            font-size: 14px;
        }
        
        .upload-zone .highlight {
            color: var(--primary);
            font-weight: 600;
        }
        
        #file-input {
            display: none;
        }
        
        .file-info {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px;
            background: #f0f9ff;
            border-radius: 12px;
            margin-top: 20px;
            border: 1px solid #e0f2fe;
        }
        
        .file-info i {
            font-size: 28px;
            color: var(--primary);
        }
        
        .file-info .file-name {
            flex: 1;
            font-weight: 500;
            color: #1e293b;
        }
        
        .file-info .file-size {
            color: #64748b;
            font-size: 13px;
        }
        
        .btn-upload {
            width: 100%;
            padding: 16px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border: none;
            color: white;
            margin-top: 20px;
            transition: all 0.3s ease;
        }
        
        .btn-upload:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(99, 102, 241, 0.4);
        }
        
        .btn-upload:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .progress-wrapper {
            margin-top: 20px;
        }
        
        .progress-custom {
            height: 8px;
            border-radius: 4px;
            background: #e2e8f0;
            overflow: hidden;
        }
        
        .progress-custom .progress-bar {
            background: linear-gradient(90deg, var(--primary) 0%, #818cf8 100%);
            height: 100%;
            transition: width 0.3s ease;
        }
        
        .status-message {
            text-align: center;
            margin-top: 15px;
            font-weight: 500;
            color: #64748b;
        }
        
        .alert-custom {
            padding: 16px 20px;
            border-radius: 12px;
            margin-top: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .alert-custom.success {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #065f46;
        }
        
        .alert-custom.error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }
        
        .alert-custom i {
            font-size: 20px;
        }
        
        .btn-secondary-custom {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            color: #64748b;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            margin-top: 15px;
        }
        
        .btn-secondary-custom:hover {
            border-color: var(--primary);
            color: var(--primary);
        }
        
        .spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="main-card">
        <div class="card-header-custom">
            <i class="bi bi-robot"></i>
            <h2>AI Document Processing</h2>
            <p>Sube un PDF para processarlo con OCR y análisis CV</p>
        </div>
        
        <div class="card-body-custom">
            <form id="upload-form">
                <div id="drop-zone" class="upload-zone">
                    <i class="bi bi-cloud-arrow-up"></i>
                    <p><span class="highlight">Haz clic para seleccionar</span> o arrastra el archivo aquí</p>
                    <p style="font-size: 12px; margin-top: 8px;">PDF únicamente, máximo 10MB</p>
                    <input type="file" id="file-input" accept=".pdf">
                </div>
                
                <div id="file-info" class="file-info d-none">
                    <i class="bi bi-file-earmark-pdf-fill"></i>
                    <div>
                        <div class="file-name" id="file-name"></div>
                        <div class="file-size" id="file-size"></div>
                    </div>
                    <i class="bi bi-check-circle-fill" style="color: var(--success);"></i>
                </div>
                
                <button id="upload-btn" class="btn-upload" disabled>
                    <i class="bi bi-upload"></i> Subir Documento
                </button>
            </form>
            
            <div id="progress-wrapper" class="progress-wrapper d-none">
                <div class="progress-custom">
                    <div class="progress-bar" style="width: 0%"></div>
                </div>
                <div class="status-message">Subiendo... <span class="spinner"></span></div>
            </div>
            
            <div id="result-wrapper" class="d-none">
                <div id="result-alert" class="alert-custom success">
                    <i class="bi bi-check-circle"></i>
                    <span>Archivo subido correctamente</span>
                </div>
                <div class="text-center">
                    <a href="/documents" class="btn-secondary-custom">
                        <i class="bi bi-list-ul"></i> Ver documentos
                    </a>
                </div>
            </div>
            
            <div id="error-wrapper" class="d-none">
                <div id="error-alert" class="alert-custom error">
                    <i class="bi bi-exclamation-circle"></i>
                    <span>Error al subir</span>
                </div>
            </div>
        </div>
    </div>

<script>
const dropZone = document.getElementById('drop-zone');
const fileInput = document.getElementById('file-input');
const uploadBtn = document.getElementById('upload-btn');
const fileInfo = document.getElementById('file-info');
const fileName = document.getElementById('file-name');
const fileSize = document.getElementById('file-size');
const progressWrapper = document.getElementById('progress-wrapper');
const resultWrapper = document.getElementById('result-wrapper');
const errorWrapper = document.getElementById('error-wrapper');

function formatBytes(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

function handleFile(file) {
    if (file.type !== 'application/pdf') {
        alert('Solo se permiten archivos PDF');
        return;
    }
    if (file.size > 10 * 1024 * 1024) {
        alert('El archivo debe ser menor a 10MB');
        return;
    }
    
    fileName.textContent = file.name;
    fileSize.textContent = formatBytes(file.size);
    fileInfo.classList.remove('d-none');
    dropZone.classList.add('d-none');
    uploadBtn.disabled = false;
}

dropZone.addEventListener('click', () => fileInput.click());

dropZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropZone.classList.add('dragover');
});

dropZone.addEventListener('dragleave', () => {
    dropZone.classList.remove('dragover');
});

dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.classList.remove('dragover');
    if (e.dataTransfer.files.length) {
        handleFile(e.dataTransfer.files[0]);
    }
});

fileInput.addEventListener('change', () => {
    if (fileInput.files.length) {
        handleFile(fileInput.files[0]);
    }
});

uploadBtn.addEventListener('click', async () => {
    if (!fileInput.files.length) return;

    const formData = new FormData();
    formData.append('file', fileInput.files[0]);

    progressWrapper.classList.remove('d-none');
    uploadBtn.disabled = true;
    uploadBtn.innerHTML = '<span class="spinner"></span> Subiendo...';

    try {
        const response = await fetch('/documents/upload', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        const data = await response.json();

        progressWrapper.classList.add('d-none');

        if (response.ok) {
            resultWrapper.classList.remove('d-none');
            fileInfo.classList.add('d-none');
        } else {
            errorWrapper.classList.remove('d-none');
            document.querySelector('#error-alert span').textContent = data.message || 'Error al subir';
            uploadBtn.disabled = false;
            uploadBtn.innerHTML = '<i class="bi bi-upload"></i> Subir Documento';
        }
    } catch (e) {
        progressWrapper.classList.add('d-none');
        errorWrapper.classList.remove('d-none');
        document.querySelector('#error-alert span').textContent = 'Error de conexión';
        uploadBtn.disabled = false;
        uploadBtn.innerHTML = '<i class="bi bi-upload"></i> Subir Documento';
    }
});
</script>
</body>
</html>