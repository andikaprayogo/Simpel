@extends('layouts.dashboard')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="mb-0 fw-bold">My Profile</h1>
                
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="text-center mb-4">
                <div class="avatar-circle mx-auto">
                    <i class="fas fa-user"></i>
                </div>
            </div>

            <!-- Personal Information -->
            <div class="card mb-4 shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <h5 class="card-title border-bottom pb-3 mb-4">Personal Information</h5>

                    <div class="profile-item d-flex mb-4">
                        <div class="profile-icon text-danger me-3">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="profile-info">
                            <div class="text-muted">Full Name</div>
                            <div class="fw-medium">{{ $user->full_name ?? 'Not set' }}</div>
                        </div>
                    </div>

                    <div class="profile-item d-flex mb-4">
                        <div class="profile-icon text-danger me-3">
                            <i class="fas fa-id-card"></i>
                        </div>
                        <div class="profile-info">
                            <div class="text-muted">NIK</div>
                            <div class="fw-medium">{{ $user->nik ?? 'Not set' }}</div>
                        </div>
                    </div>

                    <div class="profile-item d-flex mb-4">
                        <div class="profile-icon text-danger me-3">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="profile-info">
                            <div class="text-muted">Company Name</div>
                            <div class="fw-medium">{{ $user->company_name ?? 'Not set' }}</div>
                        </div>
                    </div>

                    <div class="profile-item d-flex mb-4">
                        <div class="profile-icon text-danger me-3">
                            <i class="fas fa-sitemap"></i>
                        </div>
                        <div class="profile-info">
                            <div class="text-muted">Unit</div>
                            <div class="fw-medium">{{ $user->unit ?? 'Not set' }}</div>
                        </div>
                    </div>

                    <div class="profile-item d-flex">
                        <div class="profile-icon text-danger me-3">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <div class="profile-info">
                            <div class="text-muted">Position</div>
                            <div class="fw-medium">{{ $user->position ?? 'Not set' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Account Details -->
            <div class="card mb-4 shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <h5 class="card-title border-bottom pb-3 mb-4">Account Details</h5>

                    <div class="profile-item d-flex mb-4">
                        <div class="profile-icon text-danger me-3">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="profile-info">
                            <div class="text-muted">Email</div>
                            <div class="fw-medium">{{ $user->email }}</div>
                        </div>
                    </div>

                    <div class="profile-item d-flex">
                        <div class="profile-icon text-danger me-3">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="profile-info">
                            <div class="text-muted">Telephone</div>
                            <div class="fw-medium">{{ $user->telephone ?? 'Not set' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-grid mb-5">
                <a href="{{ route('profile.edit') }}" class="btn btn-danger py-3 fw-medium">
                    Edit Information
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .avatar-circle {
        width: 120px;
        height: 120px;
        background-color: #f1f1f1;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
        border: 5px solid #fff;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .avatar-circle i {
        font-size: 60px;
        color: #888;
    }

    .profile-icon {
        width: 40px;
        height: 40px;
        background-color: #fff0f0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .profile-icon i {
        font-size: 20px;
    }

    .profile-info {
        flex: 1;
    }
    
    .text-muted {
        font-size: 0.9rem;
    }

    .fw-medium {
        font-weight: 500;
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