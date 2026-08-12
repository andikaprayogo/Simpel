@extends('layouts.dashboard')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('profile.index') }}" class="me-3">
                    <i class="fas fa-arrow-left text-dark" style="font-size: 24px;"></i>
                </a>
                <h1 class="mb-0 fw-bold">Edit Profile</h1>
            </div>

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Please check the form and try again.</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Personal Information -->
                <div class="card mb-4 shadow-sm border-0 rounded-4">
                    <div class="card-body p-4">
                        <h5 class="card-title border-bottom pb-3 mb-4">Personal Information</h5>

                        <div class="mb-3">
                            <label for="full_name" class="form-label">Full Name</label>
                            <input type="text" class="form-control @error('full_name') is-invalid @enderror" 
                                id="full_name" name="full_name" value="{{ old('full_name', $user->full_name) }}">
                            @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nik" class="form-label">NIK</label>
                            <input type="text" class="form-control @error('nik') is-invalid @enderror" 
                                id="nik" name="nik" value="{{ old('nik', $user->nik) }}">
                            @error('nik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="company_name" class="form-label">Company Name</label>
                            <input type="text" class="form-control @error('company_name') is-invalid @enderror" 
                                id="company_name" name="company_name" value="{{ old('company_name', $user->company_name) }}">
                            @error('company_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="unit" class="form-label">Unit</label>
                            <input type="text" class="form-control @error('unit') is-invalid @enderror" 
                                id="unit" name="unit" value="{{ old('unit', $user->unit) }}">
                            @error('unit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="position" class="form-label">Position</label>
                            <input type="text" class="form-control @error('position') is-invalid @enderror" 
                                id="position" name="position" value="{{ old('position', $user->position) }}">
                            @error('position')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Account Details -->
                <div class="card mb-4 shadow-sm border-0 rounded-4">
                    <div class="card-body p-4">
                        <h5 class="card-title border-bottom pb-3 mb-4">Account Details</h5>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" value="{{ $user->email }}" disabled>
                            <small class="text-muted">Email address cannot be changed</small>
                        </div>

                        <div class="mb-3">
                            <label for="telephone" class="form-label">Telephone</label>
                            <input type="text" class="form-control @error('telephone') is-invalid @enderror" 
                                id="telephone" name="telephone" value="{{ old('telephone', $user->telephone) }}">
                            @error('telephone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-grid mb-5">
                    <button type="submit" class="btn btn-danger py-3 fw-medium">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .form-control {
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
    }

    .form-control:focus {
        border-color: #dc0000;
        box-shadow: 0 0 0 0.25rem rgba(220, 0, 0, 0.25);
    }

    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .btn-danger {
        background-color: #dc0000;
        border-color: #dc0000;
    }
    
    .btn-danger:hover {
        background-color: #b80000;
        border-color: #b80000;
    }
</style>
@endsection