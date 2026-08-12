@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div class="d-flex align-items-center">
            <a href="{{ route('home') }}" class="me-3">
                <i class="fas fa-arrow-left text-dark" style="font-size: 24px;"></i>
            </a>
            <h2 class="mb-0">Upload Forms</h2>
        </div>
        <a href="{{ route('forms.list') }}" class="btn btn-outline-secondary">
            <i class="fas fa-upload"></i>
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center mb-4">
                <i class="fas fa-file-alt text-danger me-2" style="font-size: 24px;"></i>
                <h4 class="mb-0 text-danger">Select Form Type</h4>
            </div>
            
            <div class="d-grid gap-3">
                <a href="{{ route('forms.upload', 'ba-survey-mini-olt') }}" class="btn btn-danger btn-lg text-start">
                    BA SURVEY MINI OLT
                </a>
                
                <a href="{{ route('forms.upload', 'ba-survey-big-olt') }}" class="btn btn-danger btn-lg text-start">
                    BA SURVEY BIG OLT
                </a>
                
                <a href="{{ route('forms.upload', 'caf') }}" class="btn btn-danger btn-lg text-start">
                    CAF
                </a>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center" 
             data-bs-toggle="collapse" 
             href="#infoCollapse" 
             role="button" 
             aria-expanded="false" 
             aria-controls="infoCollapse">
            <div class="d-flex align-items-center">
                <i class="fas fa-info-circle text-danger me-2" style="font-size: 24px;"></i>
                <h5 class="mb-0 text-danger">Information</h5>
            </div>
            <i class="fas fa-chevron-up text-secondary"></i>
        </div>
        <div class="collapse show" id="infoCollapse">
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="d-flex align-items-center mb-3">
                        <i class="fas fa-database text-primary me-3" style="font-size: 20px;"></i>
                        <span>All uploaded forms will be stored in our database</span>
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="fas fa-file-pdf text-primary me-3" style="font-size: 20px;"></i>
                        <span>You can download forms as PDF files</span>
                    </li>
                    <li class="d-flex align-items-center">
                        <i class="fas fa-search text-primary me-3" style="font-size: 20px;"></i>
                        <span>Forms can be searched by any user</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const infoHeader = document.querySelector('.card-header[data-bs-toggle="collapse"]');
    const chevronIcon = infoHeader.querySelector('.fas.fa-chevron-up');
    
    // Toggle chevron icon on collapse
    document.getElementById('infoCollapse').addEventListener('hidden.bs.collapse', function () {
        chevronIcon.classList.remove('fa-chevron-up');
        chevronIcon.classList.add('fa-chevron-down');
    });
    
    document.getElementById('infoCollapse').addEventListener('shown.bs.collapse', function () {
        chevronIcon.classList.remove('fa-chevron-down');
        chevronIcon.classList.add('fa-chevron-up');
    });
});
</script>
@endsection