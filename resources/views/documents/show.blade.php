<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Documento #{{ $document->id }} - AI Document Processing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --bg-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        body {
            background: var(--bg-gradient);
            min-height: 100vh;
            padding: 40px 20px;
        }
        
        .main-container {
            max-width: 1100px;
            margin: 0 auto;
        }
        
        .header-card {
            background: white;
            border-radius: 20px;
            padding: 25px 35px;
            margin-bottom: 25px;
            box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.2);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .header-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .doc-icon-large {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            color: white;
        }
        
        .header-info h1 {
            margin: 0 0 5px;
            color: #1e293b;
            font-size: 24px;
            font-weight: 700;
        }
        
        .header-info p {
            margin: 0;
            color: #94a3b8;
            font-size: 14px;
        }
        
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            color: #64748b;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-back:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: #f0f4ff;
        }
        
        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
        }
        
        @media (max-width: 900px) {
            .content-grid {
                grid-template-columns: 1fr;
            }
        }
        
        .info-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }
        
        .card-header-custom {
            padding: 20px 25px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .card-header-custom h3 {
            margin: 0;
            color: #1e293b;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .card-header-custom h3 i {
            color: var(--primary);
        }
        
        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .status-badge.pending {
            background: #f1f5f9;
            color: #64748b;
        }
        
        .status-badge.processing {
            background: #fef3c7;
            color: #d97706;
        }
        
        .status-badge.completed {
            background: #d1fae5;
            color: #059669;
        }
        
        .status-badge.failed {
            background: #fee2e2;
            color: #dc2626;
        }
        
        .card-body-custom {
            padding: 25px;
        }
        
        .info-item {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #f1f5f9;
        }
        
        .info-item:last-child {
            border-bottom: none;
        }
        
        .info-item label {
            color: #94a3b8;
            font-size: 14px;
        }
        
        .info-item span {
            color: #1e293b;
            font-weight: 500;
        }
        
        .process-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }
        
        .process-header {
            padding: 20px 25px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .process-title {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .process-icon {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }
        
        .process-icon.ocr {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            color: white;
        }
        
        .process-icon.cv {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }
        
        .process-title h3 {
            margin: 0;
            color: #1e293b;
            font-weight: 600;
            font-size: 16px;
        }
        
        .process-title span {
            color: #94a3b8;
            font-size: 12px;
        }
        
        .process-body {
            padding: 25px;
        }
        
        .result-box {
            background: #f8fafc;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
        }
        
        .result-box.success {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
        }
        
        .result-box.error {
            background: #fef2f2;
            border: 1px solid #fecaca;
        }
        
        .result-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
            font-weight: 600;
        }
        
        .result-box.success .result-header {
            color: #059669;
        }
        
        .result-box.error .result-header {
            color: #dc2626;
        }
        
        .result-text {
            color: #64748b;
            font-size: 14px;
        }
        
        .result-textarea {
            width: 100%;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 15px;
            font-family: monospace;
            font-size: 13px;
            resize: vertical;
            min-height: 200px;
            background: white;
        }
        
        .cv-result {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 10px;
        }
        
        .cv-stat {
            background: white;
            border-radius: 12px;
            padding: 15px;
            text-align: center;
            border: 1px solid #e2e8f0;
        }
        
        .cv-stat-value {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .cv-stat-value.yes {
            color: var(--success);
        }
        
        .cv-stat-value.no {
            color: var(--danger);
        }
        
        .cv-stat-label {
            color: #94a3b8;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .btn-process {
            width: 100%;
            padding: 14px;
            border-radius: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s ease;
            border: none;
            margin-top: 15px;
        }
        
        .btn-process.ocr {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
        }
        
        .btn-process.ocr:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px -5px rgba(99, 102, 241, 0.5);
        }
        
        .btn-process.cv {
            background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
            color: white;
        }
        
        .btn-process.cv:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px -5px rgba(16, 185, 129, 0.5);
        }
        
        .btn-process:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .btn-process .spinner {
            display: inline-block;
            width: 18px;
            height: 18px;
            border: 2px solid rgba(255,255,255,0.3);
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
    <div class="main-container">
        <div class="header-card">
            <div class="header-left">
                <div class="doc-icon-large">
                    <i class="bi bi-file-earmark-pdf-fill"></i>
                </div>
                <div class="header-info">
                    <h1>{{ $document->original_filename }}</h1>
                    <p>Subido el {{ $document->upload_timestamp->format('d/m/Y H:i:s') }}</p>
                </div>
            </div>
            <a href="/documents" class="btn-back">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
        </div>
        
        <div class="content-grid">
            <div class="info-card">
                <div class="card-header-custom">
                    <h3><i class="bi bi-info-circle"></i> Información</h3>
                </div>
                <div class="card-body-custom">
                    <div class="info-item">
                        <label>ID Documento</label>
                        <span>#{{ $document->id }}</span>
                    </div>
                    <div class="info-item">
                        <label>Nombre original</label>
                        <span>{{ $document->original_filename }}</span>
                    </div>
                    <div class="info-item">
                        <label>Tamaño</label>
                        <span>{{ number_format($document->file_size / 1024, 2) }} KB</span>
                    </div>
                    <div class="info-item">
                        <label>Fecha de subida</label>
                        <span>{{ $document->upload_timestamp->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>
            
            <div class="info-card">
                <div class="card-header-custom">
                    <h3><i class="bi bi-gear"></i> Configuración IA</h3>
                </div>
                <div class="card-body-custom">
                    <div class="info-item">
                        <label>Modelo OCR</label>
                        <span>glm-ocr:q8_0</span>
                    </div>
                    <div class="info-item">
                        <label>Modelo CV</label>
                        <span>gemma4:e2b</span>
                    </div>
                    <div class="info-item">
                        <label>Storage path</label>
                        <span style="font-size: 12px; font-family: monospace;">{{ $document->storage_path }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="content-grid" style="margin-top: 25px;">
            <div class="process-card">
                <div class="process-header">
                    <div class="process-title">
                        <div class="process-icon ocr">
                            <i class="bi bi-file-text"></i>
                        </div>
                        <div>
                            <h3>OCR</h3>
                            <span>Transcripción del documento</span>
                        </div>
                    </div>
                    <span class="status-badge {{ $document->ocr_status }}">
                        @if($document->ocr_status === 'completed')<i class="bi bi-check-circle"></i>
                        @elseif($document->ocr_status === 'failed')<i class="bi bi-x-circle"></i>
                        @elseif($document->ocr_status === 'processing')<i class="bi bi-arrow-repeat"></i>
                        @else<i class="bi bi-clock"></i>
                        @endif
                        {{ ucfirst($document->ocr_status) }}
                    </span>
                </div>
                <div class="process-body">
                    @if($document->ocr_status === 'completed')
                        <div class="result-box success">
                            <div class="result-header">
                                <i class="bi bi-check-circle"></i> Procesamiento completado
                            </div>
                        </div>
                        <textarea class="result-textarea" readonly>{{ $document->ocr_result }}</textarea>
                    @elseif($document->ocr_status === 'failed')
                        <div class="result-box error">
                            <div class="result-header">
                                <i class="bi bi-x-circle"></i> Error en el procesamiento
                            </div>
                            <div class="result-text">El documento no pudo ser procesado correctamente.</div>
                        </div>
                    @elseif($document->ocr_status === 'processing')
                        <div class="result-box" style="background: #fef3c7; border-color: #fcd34d;">
                            <div class="result-header" style="color: #d97706;">
                                <i class="bi bi-arrow-repeat"></i> Procesando...
                            </div>
                            <div class="result-text">El documento está siendo transcrito.</div>
                        </div>
                    @else
                        <div class="result-box" style="background: #f8fafc; border-color: #e2e8f0;">
                            <div class="result-header" style="color: #64748b;">
                                <i class="bi bi-clock"></i> Pendiente
                            </div>
                            <div class="result-text">El documento aún no ha sido procesado.</div>
                        </div>
                    @endif
                    
                    @if($document->canRunOcr())
                        <button id="run-ocr-btn" class="btn-process ocr">
                            <i class="bi bi-play-fill"></i> Ejecutar OCR
                        </button>
                    @endif
                </div>
            </div>
            
            <div class="process-card">
                <div class="process-header">
                    <div class="process-title">
                        <div class="process-icon cv">
                            <i class="bi bi-person-badge"></i>
                        </div>
                        <div>
                            <h3>Análisis CV</h3>
                            <span>Detección y evaluación</span>
                        </div>
                    </div>
                    <span class="status-badge {{ $document->cv_analysis_status }}">
                        @if($document->cv_analysis_status === 'completed')<i class="bi bi-check-circle"></i>
                        @elseif($document->cv_analysis_status === 'failed')<i class="bi bi-x-circle"></i>
                        @elseif($document->cv_analysis_status === 'processing')<i class="bi bi-arrow-repeat"></i>
                        @else<i class="bi bi-clock"></i>
                        @endif
                        {{ ucfirst($document->cv_analysis_status) }}
                    </span>
                </div>
                <div class="process-body">
                    @if($document->cv_analysis_status === 'completed')
                        <div class="result-box success">
                            <div class="result-header">
                                <i class="bi bi-check-circle"></i> Análisis completado
                            </div>
                        </div>
                        <div class="cv-result">
                            <div class="cv-stat">
                                <div class="cv-stat-value {{ $document->cv_is_cv ? 'yes' : 'no' }}">
                                    {{ $document->cv_is_cv ? 'SÍ' : 'NO' }}
                                </div>
                                <div class="cv-stat-label">¿Es CV?</div>
                            </div>
                            <div class="cv-stat">
                                <div class="cv-stat-value" style="color: var(--primary);">
                                    {{ $document->cv_quality_score }}
                                </div>
                                <div class="cv-stat-label">Calidad / 100</div>
                            </div>
                        </div>
                    @elseif($document->cv_analysis_status === 'failed')
                        <div class="result-box error">
                            <div class="result-header">
                                <i class="bi bi-x-circle"></i> Error en el análisis
                            </div>
                            <div class="result-text">El documento no pudo ser analizado correctamente.</div>
                        </div>
                    @elseif($document->cv_analysis_status === 'processing')
                        <div class="result-box" style="background: #fef3c7; border-color: #fcd34d;">
                            <div class="result-header" style="color: #d97706;">
                                <i class="bi bi-arrow-repeat"></i> Analizando...
                            </div>
                            <div class="result-text">El documento está siendo evaluado.</div>
                        </div>
                    @else
                        <div class="result-box" style="background: #f8fafc; border-color: #e2e8f0;">
                            <div class="result-header" style="color: #64748b;">
                                <i class="bi bi-clock"></i> Pendiente
                            </div>
                            <div class="result-text">Requiere OCR completado primero.</div>
                        </div>
                    @endif
                    
                    @if($document->canRunCvAnalysis())
                        <button id="run-cv-btn" class="btn-process cv">
                            <i class="bi bi-play-fill"></i> Analizar CV
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

<script>
const documentId = {{ $document->id }};

function updateStatus(status, type) {
    const badge = document.querySelector(`.process-card:nth-child(${type === 'ocr' ? 1 : 2}) .status-badge`);
    badge.className = `status-badge ${status}`;
    badge.innerHTML = 
        status === 'completed' ? '<i class="bi bi-check-circle"></i> Completado' :
        status === 'failed' ? '<i class="bi bi-x-circle"></i> Fallido' :
        status === 'processing' ? '<i class="bi bi-arrow-repeat"></i> Procesando' :
        '<i class="bi bi-clock"></i> Pendiente';
    
    if (status === 'processing') {
        location.reload();
    }
}

document.getElementById('run-ocr-btn')?.addEventListener('click', async function() {
    const btn = this;
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner"></span> Procesando...';

    await fetch(`/documents/${documentId}/ocr`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    });
    
    location.reload();
});

document.getElementById('run-cv-btn')?.addEventListener('click', async function() {
    const btn = this;
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner"></span> Analizando...';

    await fetch(`/documents/${documentId}/cv-analysis`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    });
    
    location.reload();
});

setInterval(async () => {
    try {
        const response = await fetch(`/documents/${documentId}/status`);
        const data = await response.json();
        
        updateStatus(data.ocr_status, 'ocr');
        updateStatus(data.cv_analysis_status, 'cv');
        
        if (data.ocr_status === 'pending' || data.ocr_status === 'failed') {
            const btn = document.getElementById('run-ocr-btn');
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = '<i class="bi bi-play-fill"></i> Ejecutar OCR';
            }
        }
        
        if (data.cv_analysis_status === 'pending' || data.cv_analysis_status === 'failed') {
            const btn = document.getElementById('run-cv-btn');
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = '<i class="bi bi-play-fill"></i> Analizar CV';
            }
        }
    } catch (e) {
        console.log('Error polling status');
    }
}, 3000);
</script>
</body>
</html>