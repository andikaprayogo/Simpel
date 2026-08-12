@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('forms.index') }}" class="me-3">
            <i class="fas fa-arrow-left text-danger" style="font-size: 24px;"></i>
        </a>
        <h2 class="mb-0 text-danger">{{ $formTypeName }}</h2>
    </div>

    <div class="mb-4">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="#" id="form-tab">
                    <span class="text-danger border-bottom border-danger px-4 py-1 fw-bold">FORM</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" id="search-tab">SEARCH</a>
            </li>
        </ul>
        <hr class="mt-0 border-danger">
    </div>

    <div class="card mb-4">
        <div class="card-body p-0">
            <div class="text-center my-4">
                <h4 class="text-danger border border-danger rounded-pill py-2 px-4 d-inline-block">BERITA ACARA SURVEY MINI OLT</h4>
            </div>

            <div id="alert-container" class="px-4"></div>
            
            <form id="miniOltForm" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $form->id ?? '' }}">
                
                <div class="mb-4 px-4">
                    <div class="bg-danger text-white p-2 rounded">
                        <strong>Basic Information</strong>
                    </div>
                </div>
                
                <div class="mb-3 px-4">
                    <input type="text" class="form-control" id="header_no" name="header_no" placeholder="Header No. (e.g., JBI-PT3-MAB-FY-JA...)" value="{{ $form->header_no ?? '' }}" required>
                    <div class="invalid-feedback" id="header_no_error"></div>
                </div>
                
                <div class="mb-3 px-4">
                    <input type="text" class="form-control" id="lokasi_id_site" name="lokasi_id_site" placeholder="Lokasi (ID Site)" value="{{ $form->lokasi_id_site ?? '' }}" required>
                    <div class="invalid-feedback" id="lokasi_id_site_error"></div>
                </div>
                
                <div class="mb-3 px-4">
                    <input type="text" class="form-control" id="no_ihld_lop" name="no_ihld_lop" placeholder="No IHLD/LOP" value="{{ $form->no_ihld_lop ?? '' }}" required>
                    <div class="invalid-feedback" id="no_ihld_lop_error"></div>
                </div>
                
                <div class="mb-3 px-4">
                    <select class="form-select" id="platform" name="platform" required>
                        <option value="" disabled selected>Platform</option>
                        @foreach($platformOptions as $platform)
                            <option value="{{ $platform }}" {{ ($form->platform ?? '') == $platform ? 'selected' : '' }}>{{ $platform }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback" id="platform_error"></div>
                </div>
                
                <div class="mb-3 px-4">
                    <select class="form-select" id="site_provider" name="site_provider" required>
                        <option value="" disabled selected>Site Provider</option>
                        @foreach($siteProviderOptions as $provider)
                            <option value="{{ $provider }}" {{ ($form->site_provider ?? '') == $provider ? 'selected' : '' }}>{{ $provider }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback" id="site_provider_error"></div>
                </div>
                
                <div class="mb-3 px-4">
                    <input type="text" class="form-control" id="nomor_kontrak" name="nomor_kontrak" placeholder="Nomor Kontrak" value="{{ $form->nomor_kontrak ?? '' }}" required>
                    <div class="invalid-feedback" id="nomor_kontrak_error"></div>
                </div>
                
                <div class="mb-4 px-4">
                    <p class="mb-0">Hari ini: <strong class="text-danger">{{ $formattedDate }}</strong></p>
                </div>
                
                <div class="mb-4 px-4">
                    <div class="bg-danger text-white p-2 rounded">
                        <strong>Spesifikasi dan Kebutuhan</strong>
                    </div>
                </div>
                
                <!-- Specification fields with survey results and agreements -->
                
                <!-- Item 1: Rack Tempat Perangkat -->
                <div class="mb-4">
                    <div class="px-4 py-3" style="background-color: #f8f9fa;">
                        <div class="row align-items-center">
                            <div class="col-md-8 mb-2 mb-md-0">
                                <label class="form-label mb-0">1. Rack tempat Perangkat MINI OLT & OTB</label>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-muted">Type</span>
                                    <select class="form-select" name="rack_tempat_perangkat">
                                        <option value="" disabled selected>-</option>
                                        @foreach($specificationOptions as $option)
                                            <option value="{{ $option }}" {{ ($form->rack_tempat_perangkat ?? '') == $option ? 'selected' : '' }}>{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invalid-feedback" id="rack_tempat_perangkat_error"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="px-4 mt-2">
                        <textarea class="form-control mb-2" name="rack_tempat_perangkat_hasil" rows="3" placeholder="Hasil Survey dan Uraian Pekerjaan">{{ $form->rack_tempat_perangkat_hasil ?? '' }}</textarea>
                        <textarea class="form-control" name="rack_tempat_perangkat_kesepakatan" rows="3" placeholder="Kesepakatan / Proposed">{{ $form->rack_tempat_perangkat_kesepakatan ?? '' }}</textarea>
                    </div>
                </div>
                
                <!-- Item 2: Rectifier -->
                <div class="mb-4">
                    <div class="px-4 py-3" style="background-color: #f8f9fa;">
                        <div class="row align-items-center">
                            <div class="col-md-8 mb-2 mb-md-0">
                                <label class="form-label mb-0">2. Rectifier</label>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-muted">Type</span>
                                    <select class="form-select" name="rectifier">
                                        <option value="" disabled selected>-</option>
                                        @foreach($specificationOptions as $option)
                                            <option value="{{ $option }}" {{ ($form->rectifier ?? '') == $option ? 'selected' : '' }}>{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invalid-feedback" id="rectifier_error"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="px-4 mt-2">
                        <textarea class="form-control mb-2" name="rectifier_hasil" rows="3" placeholder="Hasil Survey dan Uraian Pekerjaan">{{ $form->rectifier_hasil ?? '' }}</textarea>
                        <textarea class="form-control" name="rectifier_kesepakatan" rows="3" placeholder="Kesepakatan / Proposed">{{ $form->rectifier_kesepakatan ?? '' }}</textarea>
                    </div>
                </div>
                
                <!-- Item 3: Ketersediaan Daya DC -->
                <div class="mb-4">
                    <div class="px-4 py-3" style="background-color: #f8f9fa;">
                        <div class="row align-items-center">
                            <div class="col-md-8 mb-2 mb-md-0">
                                <label class="form-label mb-0">3. Ketersediaan Daya DC</label>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-muted">Type</span>
                                    <select class="form-select" name="ketersediaan_daya_dc">
                                        <option value="" disabled selected>-</option>
                                        @foreach($specificationOptions as $option)
                                            <option value="{{ $option }}" {{ ($form->ketersediaan_daya_dc ?? '') == $option ? 'selected' : '' }}>{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invalid-feedback" id="ketersediaan_daya_dc_error"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="px-4 mt-2">
                        <textarea class="form-control mb-2" name="ketersediaan_daya_dc_hasil" rows="3" placeholder="Hasil Survey dan Uraian Pekerjaan">{{ $form->ketersediaan_daya_dc_hasil ?? '' }}</textarea>
                        <textarea class="form-control" name="ketersediaan_daya_dc_kesepakatan" rows="3" placeholder="Kesepakatan / Proposed">{{ $form->ketersediaan_daya_dc_kesepakatan ?? '' }}</textarea>
                    </div>
                </div>
                
                <!-- Item 4: Baterai -->
                <div class="mb-4">
                    <div class="px-4 py-3" style="background-color: #f8f9fa;">
                        <div class="row align-items-center">
                            <div class="col-md-8 mb-2 mb-md-0">
                                <label class="form-label mb-0">4. Baterai</label>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-muted">Type</span>
                                    <select class="form-select" name="baterai">
                                        <option value="" disabled selected>-</option>
                                        @foreach($specificationOptions as $option)
                                            <option value="{{ $option }}" {{ ($form->baterai ?? '') == $option ? 'selected' : '' }}>{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invalid-feedback" id="baterai_error"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="px-4 mt-2">
                        <textarea class="form-control mb-2" name="baterai_hasil" rows="3" placeholder="Hasil Survey dan Uraian Pekerjaan">{{ $form->baterai_hasil ?? '' }}</textarea>
                        <textarea class="form-control" name="baterai_kesepakatan" rows="3" placeholder="Kesepakatan / Proposed">{{ $form->baterai_kesepakatan ?? '' }}</textarea>
                    </div>
                </div>
                
                <!-- Item 5: MCB -->
                <div class="mb-4">
                    <div class="px-4 py-3" style="background-color: #f8f9fa;">
                        <div class="row align-items-center">
                            <div class="col-md-8 mb-2 mb-md-0">
                                <label class="form-label mb-0">5. MCB untuk Pemasangan MINI OLT</label>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-muted">Type</span>
                                    <select class="form-select" name="mcb_pemasangan">
                                        <option value="" disabled selected>-</option>
                                        @foreach($specificationOptions as $option)
                                            <option value="{{ $option }}" {{ ($form->mcb_pemasangan ?? '') == $option ? 'selected' : '' }}>{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invalid-feedback" id="mcb_pemasangan_error"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="px-4 mt-2">
                        <textarea class="form-control mb-2" name="mcb_pemasangan_hasil" rows="3" placeholder="Hasil Survey dan Uraian Pekerjaan">{{ $form->mcb_pemasangan_hasil ?? '' }}</textarea>
                        <textarea class="form-control" name="mcb_pemasangan_kesepakatan" rows="3" placeholder="Kesepakatan / Proposed">{{ $form->mcb_pemasangan_kesepakatan ?? '' }}</textarea>
                    </div>
                </div>
                
                <!-- Item 6: Grounding -->
                <div class="mb-4">
                    <div class="px-4 py-3" style="background-color: #f8f9fa;">
                        <div class="row align-items-center">
                            <div class="col-md-8 mb-2 mb-md-0">
                                <label class="form-label mb-0">6. Grounding</label>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-muted">Type</span>
                                    <select class="form-select" name="grounding">
                                        <option value="" disabled selected>-</option>
                                        @foreach($specificationOptions as $option)
                                            <option value="{{ $option }}" {{ ($form->grounding ?? '') == $option ? 'selected' : '' }}>{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invalid-feedback" id="grounding_error"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="px-4 mt-2">
                        <textarea class="form-control mb-2" name="grounding_hasil" rows="3" placeholder="Hasil Survey dan Uraian Pekerjaan">{{ $form->grounding_hasil ?? '' }}</textarea>
                        <textarea class="form-control" name="grounding_kesepakatan" rows="3" placeholder="Kesepakatan / Proposed">{{ $form->grounding_kesepakatan ?? '' }}</textarea>
                    </div>
                </div>
                
                <!-- Item 7: Indoor Room -->
                <div class="mb-4">
                    <div class="px-4 py-3" style="background-color: #f8f9fa;">
                        <div class="row align-items-center">
                            <div class="col-md-8 mb-2 mb-md-0">
                                <label class="form-label mb-0">7. Indoor Room</label>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-muted">Type</span>
                                    <select class="form-select" name="indoor_room">
                                        <option value="" disabled selected>-</option>
                                        @foreach($specificationOptions as $option)
                                            <option value="{{ $option }}" {{ ($form->indoor_room ?? '') == $option ? 'selected' : '' }}>{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invalid-feedback" id="indoor_room_error"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="px-4 mt-2">
                        <textarea class="form-control mb-2" name="indoor_room_hasil" rows="3" placeholder="Hasil Survey dan Uraian Pekerjaan">{{ $form->indoor_room_hasil ?? '' }}</textarea>
                        <textarea class="form-control" name="indoor_room_kesepakatan" rows="3" placeholder="Kesepakatan / Proposed">{{ $form->indoor_room_kesepakatan ?? '' }}</textarea>
                    </div>
                </div>
                
                <!-- Item 8: Ketersediaan Daya AC -->
                <div class="mb-4">
                    <div class="px-4 py-3" style="background-color: #f8f9fa;">
                        <div class="row align-items-center">
                            <div class="col-md-8 mb-2 mb-md-0">
                                <label class="form-label mb-0">8. Ketersediaan Daya AC</label>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-muted">Type</span>
                                    <select class="form-select" name="ketersediaan_daya_ac">
                                        <option value="" disabled selected>-</option>
                                        @foreach($specificationOptions as $option)
                                            <option value="{{ $option }}" {{ ($form->ketersediaan_daya_ac ?? '') == $option ? 'selected' : '' }}>{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invalid-feedback" id="ketersediaan_daya_ac_error"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="px-4 mt-2">
                        <textarea class="form-control mb-2" name="ketersediaan_daya_ac_hasil" rows="3" placeholder="Hasil Survey dan Uraian Pekerjaan">{{ $form->ketersediaan_daya_ac_hasil ?? '' }}</textarea>
                        <textarea class="form-control" name="ketersediaan_daya_ac_kesepakatan" rows="3" placeholder="Kesepakatan / Proposed">{{ $form->ketersediaan_daya_ac_kesepakatan ?? '' }}</textarea>
                    </div>
                </div>
                
                <!-- Item 9: BA Kesiapan Uplink -->
                <div class="mb-4">
                    <div class="px-4 py-3" style="background-color: #f8f9fa;">
                        <div class="row align-items-center">
                            <div class="col-md-8 mb-2 mb-md-0">
                                <label class="form-label mb-0">9. BA Kesiapan Uplink</label>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-muted">Type</span>
                                    <select class="form-select" name="ba_kesiapan_uplink">
                                        <option value="" disabled selected>-</option>
                                        @foreach($specificationOptions as $option)
                                            <option value="{{ $option }}" {{ ($form->ba_kesiapan_uplink ?? '') == $option ? 'selected' : '' }}>{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invalid-feedback" id="ba_kesiapan_uplink_error"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="px-4 mt-2">
                        <textarea class="form-control mb-2" name="ba_kesiapan_uplink_hasil" rows="3" placeholder="Hasil Survey dan Uraian Pekerjaan">{{ $form->ba_kesiapan_uplink_hasil ?? '' }}</textarea>
                        <textarea class="form-control" name="ba_kesiapan_uplink_kesepakatan" rows="3" placeholder="Kesepakatan / Proposed">{{ $form->ba_kesiapan_uplink_kesepakatan ?? '' }}</textarea>
                    </div>
                </div>
                
                <!-- Item 10: Conduit -->
                <div class="mb-4">
                    <div class="px-4 py-3" style="background-color: #f8f9fa;">
                        <div class="row align-items-center">
                            <div class="col-md-8 mb-2 mb-md-0">
                                <label class="form-label mb-0">10. Conduit</label>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-muted">Type</span>
                                    <select class="form-select" name="conduit" >
                                        <option value="" disabled selected>-</option>
                                        @foreach($specificationOptions as $option)
                                            <option value="{{ $option }}" {{ ($form->conduit ?? '') == $option ? 'selected' : '' }}>{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invalid-feedback" id="conduit_error"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="px-4 mt-2">
                        <textarea class="form-control mb-2" name="conduit_hasil" rows="3" placeholder="Hasil Survey dan Uraian Pekerjaan">{{ $form->conduit_hasil ?? '' }}</textarea>
                        <textarea class="form-control" name="conduit_kesepakatan" rows="3" placeholder="Kesepakatan / Proposed">{{ $form->conduit_kesepakatan ?? '' }}</textarea>
                    </div>
                </div>
                
                <div class="d-grid mt-5 px-4 mb-4">
                    <button type="submit" class="btn btn-danger btn-lg py-3">SUBMIT</button>
                </div>
            </form>
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
                <p class="mb-4">Form BA Survey Mini OLT telah berhasil disimpan.</p>
                <div class="d-flex justify-content-center gap-2">
                    <a href="{{ route('forms.upload', 'ba-survey-mini-olt') }}" class="btn btn-outline-secondary">Buat Lagi</a>
                    <a href="{{ route('forms.list') }}" class="btn btn-danger">Lihat Daftar</a>
                </div>
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
    
    /* Nav tab styles */
    .nav-tabs .nav-link {
        color: #333;
        border: none;
    }
    
    .nav-tabs .nav-link.active {
        font-weight: bold;
        color: #333;
        background-color: transparent;
        border: none;
    }
    
    textarea {
        resize: none;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('miniOltForm');
    const successModal = new bootstrap.Modal(document.getElementById('successModal'));
    const alertContainer = document.getElementById('alert-container');
    
    // Handle form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Reset error messages
        document.querySelectorAll('.invalid-feedback').forEach(el => {
            el.innerHTML = '';
        });
        document.querySelectorAll('.form-control, .form-select').forEach(el => {
            el.classList.remove('is-invalid');
        });
        alertContainer.innerHTML = '';
        
        // Submit form data via AJAX
        const formData = new FormData(form);
        
        fetch('{{ route("forms.process-mini-olt") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            if (data.errors) {
                // Show validation errors
                Object.keys(data.errors).forEach(field => {
                    const errorElement = document.getElementById(`${field}_error`);
                    if (errorElement) {
                        errorElement.innerHTML = data.errors[field][0];
                        document.getElementById(field)?.classList.add('is-invalid');
                        
                        // For select elements that don't have direct IDs
                        const selectElement = document.querySelector(`select[name="${field}"]`);
                        if (selectElement) {
                            selectElement.classList.add('is-invalid');
                        }
                    }
                });
                
                // Show alert for site ID uniqueness error
                if (data.errors.lokasi_id_site) {
                    alertContainer.innerHTML = `
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            ${data.errors.lokasi_id_site[0]}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `;
                }
            } else if (data.success) {
                // Update form ID if needed
                if (data.form_id) {
                    // Add a hidden input with the form ID if it doesn't exist
                    if (!document.querySelector('input[name="id"]')) {
                        const formIdInput = document.createElement('input');
                        formIdInput.type = 'hidden';
                        formIdInput.name = 'id';
                        formIdInput.value = data.form_id;
                        form.appendChild(formIdInput);
                    } else {
                        document.querySelector('input[name="id"]').value = data.form_id;
                    }
                }
                
                // Show success modal
                successModal.show();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alertContainer.innerHTML = `
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    An error occurred while submitting the form. Please try again.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
        });
    });
    
    // Handle tabs
    document.getElementById('search-tab').addEventListener('click', function(e) {
        e.preventDefault();
        window.location.href = '{{ route("forms.list", ["type" => "ba-survey-mini-olt"]) }}';
    });
});
</script>
@endpush
@endsection