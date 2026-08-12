@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<div class="auth-card">
    <div class="d-flex align-items-center back-button">
        <i class="fas fa-chevron-left"></i>
    </div>
    
    <h3 class="auth-header">Create Account</h3>
    
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-4">
            <h5 class="section-header">Personal Information</h5>
            
            <div class="icon-input">
                <i class="fas fa-user" style="color: #dc0000;"></i>
                <input id="full_name" type="text" class="form-control @error('full_name') is-invalid @enderror" name="full_name" value="{{ old('full_name') }}" placeholder="Full Name" required>
                @error('full_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="icon-input">
                <i class="fas fa-id-card" style="color: #dc0000;"></i>
                <input id="nik" type="text" class="form-control @error('nik') is-invalid @enderror" name="nik" value="{{ old('nik') }}" placeholder="NIK" required>
                @error('nik')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="icon-input">
                <i class="fas fa-building" style="color: #dc0000;"></i>
                <input id="company_name" type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name" value="{{ old('company_name') }}" placeholder="Company Name">
                @error('company_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="icon-input">
                <i class="fas fa-sitemap" style="color: #dc0000;"></i>
                <input id="unit" type="text" class="form-control @error('unit') is-invalid @enderror" name="unit" value="{{ old('unit') }}" placeholder="Unit">
                @error('unit')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="icon-input">
                <i class="fas fa-briefcase" style="color: #dc0000;"></i>
                <input id="position" type="text" class="form-control @error('position') is-invalid @enderror" name="position" value="{{ old('position') }}" placeholder="Position">
                @error('position')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="mb-4">
            <h5 class="section-header">Account Details</h5>
            
            <div class="icon-input">
                <i class="fas fa-envelope" style="color: #dc0000;"></i>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email" required>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="icon-input">
                <i class="fas fa-phone" style="color: #dc0000;"></i>
                <input id="phone_number" type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number') }}" placeholder="Phone Number">
                @error('phone_number')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="icon-input">
                <i class="fas fa-lock" style="color: #dc0000;"></i>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required>
                <i class="toggle-password " onclick="togglePassword('password')"></i>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-auth">
                SIGN UP
            </button>
        </div>
    </form>
</div>
@endsection