@props([
    'pdfRoute',
    'excelRoute' => null,
    'params' => []
])

<div class="mb-3">
    <a href="{{ route($pdfRoute, $params) }}" class="btn btn-danger">
        <i class="bi bi-filetype-pdf"></i> PDF
    </a>
</div>
