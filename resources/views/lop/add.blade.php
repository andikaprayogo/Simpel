@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Header Card -->
            <div class="card mb-4">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <img src="{{ asset('img/simpel-logo.png') }}" alt="SIMPEL Logo" style="height: 60px;">
                    </div>
                    <h2 class="text-danger fw-bold">ADD LOP</h2>
                    <p class="text-secondary">Menambahkan LOP baru</p>
                    <hr>
                </div>
            </div>

            <form method="POST" action="{{ route('lop.store') }}" id="lopForm">
                @csrf

                <!-- Basic Project Information Card -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="text-danger mb-4">Informasi Dasar Proyek</h5>
                        
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-check-circle text-secondary"></i>
                                </span>
                                <select name="status_proyek" class="form-select @error('status_proyek') is-invalid @enderror" required>
                                    <option value="" disabled selected>Status Proyek (B)</option>
                                    @foreach($statuses as $status)
                                        <option value="{{ $status }}">{{ $status }}</option>
                                    @endforeach
                                </select>
                                @error('status_proyek')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-map-marker-alt text-secondary"></i>
                                </span>
                                <select name="witel" class="form-select @error('witel') is-invalid @enderror" required>
                                    <option value="" disabled selected>Witel (C)</option>
                                    @foreach($witels as $witel)
                                        <option value="{{ $witel }}">{{ $witel }}</option>
                                    @endforeach
                                </select>
                                @error('witel')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-map-marker-alt text-secondary"></i>
                                </span>
                                <input type="text" name="site_id_location" class="form-control @error('site_id_location') is-invalid @enderror" placeholder="Site ID Location (M)*" required>
                                @error('site_id_location')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <small class="text-danger">Wajib diisi</small>
                        </div>
                    </div>
                </div>

                <!-- Location and Coordinates Card -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="text-danger mb-4">Lokasi dan Koordinat</h5>
                        
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-map-pin text-secondary"></i>
                                </span>
                                <input type="text" name="koordinat" class="form-control" placeholder="Koordinat (N)">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <button type="button" id="getCurrentLocation" class="btn btn-danger w-100">
                                <i class="fas fa-location-arrow me-2"></i> GUNAKAN LOKASI SAAT INI
                            </button>
                        </div>
                        
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-map-marker-alt text-secondary"></i>
                                </span>
                                <input type="text" name="kecamatan_lokasi_olt" class="form-control" placeholder="Kecamatan Lokasi OLT (P)">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- OLT Technical Specifications Card -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="text-danger mb-4">Spesifikasi Teknis OLT</h5>
                        
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-server text-secondary"></i>
                                </span>
                                <select name="size_olt" class="form-select">
                                    <option value="" disabled selected>Size OLT (I)</option>
                                    @foreach($sizeOltOptions as $option)
                                        <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <div class="input-group">
                                    <span class="input-group-text bg-white">
                                        <i class="fas fa-building text-secondary"></i>
                                    </span>
                                    <select name="platform" class="form-select">
                                        <option value="" disabled selected>Platform</option>
                                        @foreach($platformOptions as $option)
                                            <option value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text bg-white">
                                        <i class="fas fa-cogs text-secondary"></i>
                                    </span>
                                    <select name="type" class="form-select">
                                        <option value="" disabled selected>Type</option>
                                        @foreach($typeOptions as $option)
                                            <option value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <div class="input-group">
                                    <span class="input-group-text bg-white">
                                        <i class="fas fa-desktop text-secondary"></i>
                                    </span>
                                    <input type="text" name="hostname" class="form-control" placeholder="Hostname (H)">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text bg-white">
                                        <i class="fas fa-layer-group text-secondary"></i>
                                    </span>
                                    <input type="number" name="jumlah_modul" class="form-control" placeholder="Jml Modul">
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-plug text-secondary"></i>
                                </span>
                                <select name="catuan_ac" class="form-select">
                                    <option value="" disabled selected>Catuan AC (V)</option>
                                    @foreach($catuanAcOptions as $option)
                                        <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STO and Connection Card -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="text-danger mb-4">STO dan Koneksi</h5>
                        
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <div class="input-group">
                                    <span class="input-group-text bg-white">
                                        <i class="fas fa-building text-secondary"></i>
                                    </span>
                                    <input type="text" name="kode_sto" class="form-control" placeholder="Kode STO">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text bg-white">
                                        <i class="fas fa-list text-secondary"></i>
                                    </span>
                                    <input type="text" name="nama_sto_uplink" class="form-control" placeholder="Nama STO Uplink">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <div class="input-group">
                                    <span class="input-group-text bg-white">
                                        <i class="fas fa-network-wired text-secondary"></i>
                                    </span>
                                    <input type="text" name="port_metro" class="form-control" placeholder="Port Metro (F)">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text bg-white">
                                        <i class="fas fa-ethernet text-secondary"></i>
                                    </span>
                                    <input type="text" name="sfp" class="form-control" placeholder="SFP (G)">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <div class="input-group">
                                    <span class="input-group-text bg-white">
                                        <i class="fas fa-box text-secondary"></i>
                                    </span>
                                    <input type="number" name="odp" class="form-control" placeholder="ODP (AB)">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text bg-white">
                                        <i class="fas fa-plug text-secondary"></i>
                                    </span>
                                    <input type="number" name="port" class="form-control" placeholder="Port (AC)">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Project Timeline Card -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="text-danger mb-4">Waktu Proyek</h5>
                        
                        <div class="mb-3">
                            <label for="start_project" class="form-label">Start Project</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-calendar text-secondary"></i>
                                </span>
                                <input type="date" id="start_project" name="start_project" class="form-control" placeholder="Start Project (U)">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="toc" class="form-label">TOC (Turn Over Certificate)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-file-alt text-secondary"></i>
                                </span>
                                <input type="date" id="toc" name="toc" class="form-control" placeholder="TOC (T)">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="tanggal_plan_oa" class="form-label">Tanggal Plan OA</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-calendar-alt text-secondary"></i>
                                </span>
                                <input type="date" id="tanggal_plan_oa" name="tanggal_plan_oa" class="form-control" placeholder="Tanggal Plan OA (Y)">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="week_plan_oa" class="form-label">Week Plan OA</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-camera text-secondary"></i>
                                </span>
                                <input type="text" id="week_plan_oa" name="week_plan_oa" class="form-control" placeholder="Week Plan OA (Z)" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contract and Issues Card -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="text-danger mb-4">Kontrak dan Kendala</h5>
                        
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-envelope text-secondary"></i>
                                </span>
                                <input type="text" name="lop_downlink" class="form-control" placeholder="LOP Downlink (R)">
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-file-contract text-secondary"></i>
                                </span>
                                <input type="text" name="kontrak_pengadaan" class="form-control" placeholder="Kontrak Pengadaan (S)">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <div class="input-group">
                                    <span class="input-group-text bg-white">
                                        <i class="fas fa-image text-secondary"></i>
                                    </span>
                                    <input type="text" name="kode_ihld" class="form-control" placeholder="Kode IHLD">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text bg-white">
                                        <i class="fas fa-building text-secondary"></i>
                                    </span>
                                    <select name="site_provider" class="form-select">
                                        <option value="" disabled selected>Site Provider</option>
                                        @foreach($siteProviderOptions as $option)
                                            <option value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-bug text-secondary"></i>
                                </span>
                                <select name="kendala" class="form-select">
                                    <option value="" disabled selected>Kendala (X)</option>
                                    @foreach($kendalaOptions as $option)
                                        <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-exclamation-circle text-secondary"></i>
                                </span>
                                <input type="text" name="last_issue" class="form-control" placeholder="Last Issue (W)">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="row mb-4">
                    <div class="col-6">
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-chevron-left me-2"></i> KEMBALI
                        </a>
                    </div>
                    <div class="col-6">
                        <button type="button" id="previewButton" class="btn btn-danger w-100">
                            <i class="fas fa-save me-2"></i> SIMPAN
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="previewModalLabel">Konfirmasi Data LOP</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <h6 class="fw-bold">Informasi Dasar Proyek</h6>
                        <table class="table table-sm">
                            <tr>
                                <td width="30%">Status Proyek</td>
                                <td width="5%">:</td>
                                <td id="preview_status_proyek">-</td>
                            </tr>
                            <tr>
                                <td>Witel</td>
                                <td>:</td>
                                <td id="preview_witel">-</td>
                            </tr>
                            <tr>
                                <td>Site ID Location</td>
                                <td>:</td>
                                <td id="preview_site_id_location">-</td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="col-md-12">
                        <h6 class="fw-bold mt-3">Lokasi dan Koordinat</h6>
                        <table class="table table-sm">
                            <tr>
                                <td width="30%">Koordinat</td>
                                <td width="5%">:</td>
                                <td id="preview_koordinat">-</td>
                            </tr>
                            <tr>
                                <td>Kecamatan Lokasi OLT</td>
                                <td>:</td>
                                <td id="preview_kecamatan_lokasi_olt">-</td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="col-md-12">
                        <h6 class="fw-bold mt-3">Spesifikasi Teknis OLT</h6>
                        <table class="table table-sm">
                            <tr>
                                <td width="30%">Size OLT</td>
                                <td width="5%">:</td>
                                <td id="preview_size_olt">-</td>
                            </tr>
                            <tr>
                                <td>Platform</td>
                                <td>:</td>
                                <td id="preview_platform">-</td>
                            </tr>
                            <tr>
                                <td>Type</td>
                                <td>:</td>
                                <td id="preview_type">-</td>
                            </tr>
                            <tr>
                                <td>Hostname</td>
                                <td>:</td>
                                <td id="preview_hostname">-</td>
                            </tr>
                            <tr>
                                <td>Jumlah Modul</td>
                                <td>:</td>
                                <td id="preview_jumlah_modul">-</td>
                            </tr>
                            <tr>
                                <td>Catuan AC</td>
                                <td>:</td>
                                <td id="preview_catuan_ac">-</td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="col-md-12">
                        <h6 class="fw-bold mt-3">STO dan Koneksi</h6>
                        <table class="table table-sm">
                            <tr>
                                <td width="30%">Kode STO</td>
                                <td width="5%">:</td>
                                <td id="preview_kode_sto">-</td>
                            </tr>
                            <tr>
                                <td>Nama STO Uplink</td>
                                <td>:</td>
                                <td id="preview_nama_sto_uplink">-</td>
                            </tr>
                            <tr>
                                <td>Port Metro</td>
                                <td>:</td>
                                <td id="preview_port_metro">-</td>
                            </tr>
                            <tr>
                                <td>SFP</td>
                                <td>:</td>
                                <td id="preview_sfp">-</td>
                            </tr>
                            <tr>
                                <td>ODP</td>
                                <td>:</td>
                                <td id="preview_odp">-</td>
                            </tr>
                            <tr>
                                <td>Port</td>
                                <td>:</td>
                                <td id="preview_port">-</td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="col-md-12">
                        <h6 class="fw-bold mt-3">Waktu Proyek</h6>
                        <table class="table table-sm">
                            <tr>
                                <td width="30%">Start Project</td>
                                <td width="5%">:</td>
                                <td id="preview_start_project">-</td>
                            </tr>
                            <tr>
                                <td>TOC</td>
                                <td>:</td>
                                <td id="preview_toc">-</td>
                            </tr>
                            <tr>
                                <td>Tanggal Plan OA</td>
                                <td>:</td>
                                <td id="preview_tanggal_plan_oa">-</td>
                            </tr>
                            <tr>
                                <td>Week Plan OA</td>
                                <td>:</td>
                                <td id="preview_week_plan_oa">-</td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="col-md-12">
                        <h6 class="fw-bold mt-3">Kontrak dan Kendala</h6>
                        <table class="table table-sm">
                            <tr>
                                <td width="30%">LOP Downlink</td>
                                <td width="5%">:</td>
                                <td id="preview_lop_downlink">-</td>
                            </tr>
                            <tr>
                                <td>Kontrak Pengadaan</td>
                                <td>:</td>
                                <td id="preview_kontrak_pengadaan">-</td>
                            </tr>
                            <tr>
                                <td>Kode IHLD</td>
                                <td>:</td>
                                <td id="preview_kode_ihld">-</td>
                            </tr>
                            <tr>
                                <td>Site Provider</td>
                                <td>:</td>
                                <td id="preview_site_provider">-</td>
                            </tr>
                            <tr>
                                <td>Kendala</td>
                                <td>:</td>
                                <td id="preview_kendala">-</td>
                            </tr>
                            <tr>
                                <td>Last Issue</td>
                                <td>:</td>
                                <td id="preview_last_issue">-</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="submitForm">Submit</button>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center py-5">
                <div class="checkmark-circle mb-4">
                    <div class="checkmark draw"></div>
                </div>
                <h3 class="mb-3">Berhasil!</h3>
                <p class="mb-4">Data LOP telah berhasil disimpan.</p>
                <a href="{{ route('home') }}" class="btn btn-danger">Kembali ke Home</a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<style>
    /* Success Animation Styles */
    .checkmark-circle {
        width: 100px;
        height: 100px;
        position: relative;
        display: inline-block;
        vertical-align: top;
        margin-left: auto;
        margin-right: auto;
    }
    
    .checkmark-circle .background {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: #dc0000;
        position: absolute;
    }
    
    .checkmark {
        border-radius: 50%;
        display: block;
        stroke-width: 6;
        stroke: #fff;
        stroke-miterlimit: 10;
        box-shadow: inset 0px 0px 0px #dc0000;
        animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;
        position: relative;
        top: 30px;
        right: 5px;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        stroke-width: 6;
        stroke: #dc0000;
        stroke-miterlimit: 10;
        margin: 10% auto;
    }
    
    .checkmark.draw:after {
        content: '';
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background-color: #dc0000;
        position: absolute;
        top: 0;
        left: 0;
        z-index: -1;
    }
    
    .checkmark:after {
        opacity: 1;
        height: 75px;
        width: 75px;
        transform-origin: 50% 50%;
        border-radius: 50%;
        background-color: #dc0000;
    }
    
    .checkmark-circle .checkmark.draw:after {
        animation: animateCircle 0.7s ease-out forwards;
    }
    
    .checkmark.draw:after {
        animation-delay: 0.3s;
    }
    
    .checkmark.draw {
        animation-delay: 0.3s;
        animation: drawCheck 0.7s ease-out forwards;
    }
    
    @keyframes animateCircle {
        0% {
            transform: scale(0);
            opacity: 0;
        }
        50% {
            transform: scale(0.5);
            opacity: 1;
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }
    
    @keyframes drawCheck {
        0% {
            stroke-dasharray: 0, 122;
        }
        100% {
            stroke-dasharray: 122, 122;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get current location button
    document.getElementById('getCurrentLocation').addEventListener('click', function() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                const koordinat = `${lat}, ${lng}`;
                document.querySelector('input[name="koordinat"]').value = koordinat;
            }, function(error) {
                alert('Error getting location: ' + error.message);
            });
        } else {
            alert('Geolocation is not supported by this browser.');
        }
    });
    
    // Calculate Week Plan OA based on Tanggal Plan OA
    document.getElementById('tanggal_plan_oa').addEventListener('change', function() {
        const dateInput = this.value;
        if (dateInput) {
            const date = new Date(dateInput);
            const monthNames = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"];
            const month = monthNames[date.getMonth()];
            const day = date.getDate();
            const weekNumber = Math.ceil(day / 7);
            
            document.getElementById('week_plan_oa').value = `${month}, Week ${weekNumber}`;
        } else {
            document.getElementById('week_plan_oa').value = '';
        }
    });
    
    // Preview button action
    document.getElementById('previewButton').addEventListener('click', function() {
        const form = document.getElementById('lopForm');
        const formData = new FormData(form);
        
        // Update preview modal with form data
        for (let [name, value] of formData.entries()) {
            const previewElement = document.getElementById(`preview_${name}`);
            if (previewElement) {
                previewElement.textContent = value || '-';
            }
        }
        
        // Format date fields for display
        const dateFields = ['start_project', 'toc', 'tanggal_plan_oa'];
        dateFields.forEach(field => {
            const value = formData.get(field);
            const previewElement = document.getElementById(`preview_${field}`);
            if (value && previewElement) {
                const date = new Date(value);
                const formattedDate = date.toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: 'long',
                    year: 'numeric'
                });
                previewElement.textContent = formattedDate;
            }
        });
        
        // Show preview modal
        const previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
        previewModal.show();
    });
    
    // Submit button in modal
    document.getElementById('submitForm').addEventListener('click', function() {
        const form = document.getElementById('lopForm');
        
        // Submit the form
        form.submit();
        
        // Hide preview modal
        const previewModal = bootstrap.Modal.getInstance(document.getElementById('previewModal'));
        previewModal.hide();
        
        // Show success modal
        const successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
        
        // Prevent default form submission (we'll handle redirection manually)
        return false;
    });
});
</script>
@endpush
@endsection