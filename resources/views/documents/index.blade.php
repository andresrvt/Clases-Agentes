<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Documentos - AI Document Processing</title>
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
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .header-card {
            background: white;
            border-radius: 20px;
            padding: 30px 40px;
            margin-bottom: 30px;
            box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.2);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .header-card h1 {
            margin: 0;
            color: #1e293b;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .header-card h1 i {
            color: var(--primary);
        }
        
        .btn-primary-custom {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 28px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border: none;
            border-radius: 12px;
            color: white;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px -3px rgba(99, 102, 241, 0.4);
        }
        
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px -5px rgba(99, 102, 241, 0.5);
            color: white;
        }
        
        .documents-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }
        
        .table {
            margin: 0;
        }
        
        .table thead th {
            background: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
            padding: 16px 20px;
        }
        
        .table tbody td {
            padding: 20px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }
        
        .table tbody tr:last-child td {
            border-bottom: none;
        }
        
        .table tbody tr:hover {
            background: #f8fafc;
        }
        
        .doc-id {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 14px;
        }
        
        .doc-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .doc-icon {
            font-size: 32px;
            color: #ef4444;
        }
        
        .doc-name {
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 2px;
        }
        
        .doc-meta {
            color: #94a3b8;
            font-size: 13px;
        }
        
        .badge-custom {
            padding: 8px 14px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 12px;
        }
        
        .badge-pending {
            background: #f1f5f9;
            color: #64748b;
        }
        
        .badge-processing {
            background: #fef3c7;
            color: #d97706;
        }
        
        .badge-completed {
            background: #d1fae5;
            color: #059669;
        }
        
        .badge-failed {
            background: #fee2e2;
            color: #dc2626;
        }
        
        .btn-action {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            border: 2px solid #e2e8f0;
            background: white;
            color: #64748b;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .btn-action:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: #f0f4ff;
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #94a3b8;
        }
        
        .empty-state i {
            font-size: 64px;
            margin-bottom: 20px;
            color: #cbd5e1;
        }
        
        .empty-state h3 {
            color: #64748b;
            margin-bottom: 10px;
        }
        
        .pagination-wrapper {
            padding: 20px;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
        }
        
        @media (max-width: 768px) {
            .header-card {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }
            
            .table thead {
                display: none;
            }
            
            .table tbody td {
                display: block;
                padding: 12px 16px;
            }
            
            .table tbody tr {
                background: white;
                border-radius: 12px;
                margin-bottom: 12px;
                box-shadow: 0 2px 8px -2px rgba(0, 0, 0, 0.1);
            }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="header-card">
            <h1><i class="bi bi-collection"></i> Documentos</h1>
            <a href="/documents/upload" class="btn-primary-custom">
                <i class="bi bi-plus-lg"></i> Nuevo Documento
            </a>
        </div>
        
        <div class="documents-card">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 60px;">ID</th>
                        <th>Documento</th>
                        <th>Tamaño</th>
                        <th>Fecha</th>
                        <th>Estado OCR</th>
                        <th>Estado CV</th>
                        <th style="width: 60px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documents as $doc)
                    <tr>
                        <td><div class="doc-id">{{ $doc->id }}</div></td>
                        <td>
                            <div class="doc-info">
                                <i class="bi bi-file-earmark-pdf-fill doc-icon"></i>
                                <div>
                                    <div class="doc-name">{{ $doc->original_filename }}</div>
                                    <div class="doc-meta">ID: {{ $doc->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="color: #64748b; font-size: 14px;">{{ number_format($doc->file_size / 1024, 2) }} KB</td>
                        <td style="color: #64748b; font-size: 14px;">{{ $doc->upload_timestamp->format('d/m/Y H:i') }}</td>
                        <td>
                            <span class="badge-custom badge-{{ $doc->ocr_status }}">
                                @if($doc->ocr_status === 'completed')<i class="bi bi-check-circle"></i>
                                @elseif($doc->ocr_status === 'failed')<i class="bi bi-x-circle"></i>
                                @elseif($doc->ocr_status === 'processing')<i class="bi bi-arrow-repeat"></i>
                                @else<i class="bi bi-clock"></i>
                                @endif
                                {{ ucfirst($doc->ocr_status) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge-custom badge-{{ $doc->cv_analysis_status }}">
                                @if($doc->cv_analysis_status === 'completed')<i class="bi bi-check-circle"></i>
                                @elseif($doc->cv_analysis_status === 'failed')<i class="bi bi-x-circle"></i>
                                @elseif($doc->cv_analysis_status === 'processing')<i class="bi bi-arrow-repeat"></i>
                                @else<i class="bi bi-clock"></i>
                                @endif
                                {{ ucfirst($doc->cv_analysis_status) }}
                            </span>
                        </td>
                        <td>
                            <a href="/documents/{{ $doc->id }}" class="btn-action">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <i class="bi bi-folder2-open"></i>
                                <h3>No hay documentos</h3>
                                <p>Sube tu primer documento para comenzar</p>
                                <a href="/documents/upload" class="btn-primary-custom" style="display: inline-flex; margin-top: 15px;">
                                    <i class="bi bi-upload"></i> Subir Documento
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            
            @if($documents->hasPages())
            <div class="pagination-wrapper">
                {{ $documents->links() }}
            </div>
            @endif
        </div>
    </div>
</body>
</html>