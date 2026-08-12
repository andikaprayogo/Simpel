@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('home') }}" class="me-3">
            <i class="fas fa-arrow-left text-dark" style="font-size: 24px;"></i>
        </a>
        <h2 class="mb-0">List LOP Project</h2>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('witel.search') }}" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control form-control-lg" 
                           placeholder="Cari Witel..." 
                           name="query" 
                           value="{{ $query ?? '' }}">
                    <button class="btn btn-outline-danger" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="mb-3 text-secondary">
        {{ $totalWitels }} Witel Tersedia
    </div>

    @foreach($witels as $witel)
    <div class="card mb-3 witel-card" onclick="window.location='{{ route('witel.show', $witel->id) }}'">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-auto">
                    <div class="witel-image-container">
                        <div class="witel-red-bar"></div>
                        <img src="{{ asset($witel->image_path) }}" alt="{{ $witel->name }}" class="witel-image">
                    </div>
                </div>
                <div class="col">
                    <h4 class="mb-1">{{ $witel->name }}</h4>
                    <p class="text-secondary mb-0">{{ $witel->address }}</p>
                </div>
                <div class="col-auto">
                    <i class="fas fa-chevron-right text-danger fa-lg"></i>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<style>
    .witel-card {
        transition: all 0.3s ease;
        border-radius: 15px;
        overflow: hidden;
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        cursor: pointer;
    }

    .witel-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        background-color: #f9f9f9;
    }

    .witel-image-container {
        position: relative;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        overflow: hidden;
    }

    .witel-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .witel-red-bar {
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 6px;
        background-color: #dc0000;
    }
</style>
@endsection