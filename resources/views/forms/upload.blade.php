@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('forms.index') }}" class="me-3">
            <i class="fas fa-arrow-left text-dark" style="font-size: 24px;"></i>
        </a>
        <h2 class="mb-0">Upload {{ $formTypeName }}</h2>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('forms.process-upload', $type) }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-3">
                    <label for="title" class="form-label">Form Title</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="site_id" class="form-label">Site ID</label>
                    <input type="text" class="form-control @error('site_id') is-invalid @enderror" id="site_id" name="site_id" value="{{ old('site_id') }}" required>
                    @error('site_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="form_file" class="form-label">Select PDF File</label>
                    <input type="file" class="form-control @error('form_file') is-invalid @enderror" id="form_file" name="form_file" accept=".pdf" required>
                    @error('form_file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Max file size: 10MB</small>
                </div>
                
                <div class="d-grid">
                    <button type="submit" class="btn btn-danger btn-lg">Upload Form</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection