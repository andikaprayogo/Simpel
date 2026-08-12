@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="auth-card">
    <div class="welcome-text">
        <h3>Welcome to <span>SIMPEL</span></h3>
    </div>
    
    <div class="logo-container">
        <img src="{{ asset('img/simpel-logo.png') }}" alt="SIMPEL Logo">
    </div>
    
    <form method="POST" action="{{ route('login') }}">
        @csrf
        
        <div class="icon-input">
            <i class="fas fa-envelope" style="color: #dc0000;"></i>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>
            @error('email')
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

        <div class="forgot-password">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">Forgot password?</a>
            @endif
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-auth">
                LOGIN
            </button>
        </div>
    </form>
    
    <div class="signup-link mt-4 text-center">
        <p>Don't have an account?</p>
        <a href="{{ route('register') }}" class="btn btn-outline-success">Sign Up Now</a>
    </div>
</div>
@endsection