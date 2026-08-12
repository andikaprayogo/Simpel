@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div class="d-flex align-items-center">
            <a href="{{ route('witel.show', $witel->id) }}" class="me-3">
                <i class="fas fa-arrow-left text-dark" style="font-size: 24px;"></i>
            </a>
            <div>
                <h1 class="mb-0">Site Detail</h1>
                <h5 class="text-muted">{{ $witel->name }}</h5>
            </div>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editSiteModal">
            <i class="fas fa-edit me-2"></i> Edit Site
        </button>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card mb-4">
        <div class="card-header bg-white">
            <h3 class="card-title mb-0">
                {{ $lop->site_id_location }} - 
                <span class="
                    @if($lop->status_proyek == 'MAT DEL') text-warning
                    @elseif($lop->status_proyek == 'DONE') text-success
                    @elseif($lop->status_proyek == 'DONE UT') text-success
                    @elseif($lop->status_proyek == 'SURVEY') text-info
                    @elseif($lop->status_proyek == 'DONE SURVEY') text-info
                    @elseif($lop->status_proyek == 'DROP') text-danger
                    @elseif($lop->status_proyek == 'OA') text-primary
                    @elseif($lop->status_proyek == 'MOS') text-secondary
                    @elseif($lop->status_proyek == 'POWER ON') text-success
                    @elseif($lop->status_proyek == 'INTEGRASI') text-primary
                    @elseif($lop->status_proyek == 'INSTALL RACK') text-info
                    @else text-secondary
                    @endif">
                    {{ $lop->status_proyek }}
                </span>
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <h5>Informasi Dasar Proyek</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th class="w-50">Witel</th>
                                <td>{{ $lop->witel }}</td>
                            </tr>
                            <tr>
                                <th>Site ID Location</th>
                                <td>{{ $lop->site_id_location }}</td>
                            </tr>
                            <tr>
                                <th>Status Proyek</th>
                                <td>
                                    <span class="
                                        @if($lop->status_proyek == 'MAT DEL') text-warning
                                        @elseif($lop->status_proyek == 'DONE') text-success
                                        @elseif($lop->status_proyek == 'DONE UT') text-success
                                        @elseif($lop->status_proyek == 'SURVEY') text-info
                                        @elseif($lop->status_proyek == 'DONE SURVEY') text-info
                                        @elseif($lop->status_proyek == 'DROP') text-danger
                                        @elseif($lop->status_proyek == 'OA') text-primary
                                        @elseif($lop->status_proyek == 'MOS') text-secondary
                                        @elseif($lop->status_proyek == 'POWER ON') text-success
                                        @elseif($lop->status_proyek == 'INTEGRASI') text-primary
                                        @elseif($lop->status_proyek == 'INSTALL RACK') text-info
                                        @else text-secondary
                                        @endif">
                                        {{ $lop->status_proyek }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Koordinat</th>
                                <td>{{ $lop->koordinat ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Kecamatan Lokasi OLT</th>
                                <td>{{ $lop->kecamatan_lokasi_olt ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <h5>Spesifikasi Teknis OLT</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th class="w-50">Size OLT</th>
                                <td>{{ $lop->size_olt ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Platform</th>
                                <td>{{ $lop->platform ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Type</th>
                                <td>{{ $lop->type ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Hostname</th>
                                <td>{{ $lop->hostname ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Jumlah Modul</th>
                                <td>{{ $lop->jumlah_modul ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Catuan AC</th>
                                <td>{{ $lop->catuan_ac ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <h5>STO dan Koneksi</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th class="w-50">Kode STO</th>
                                <td>{{ $lop->kode_sto ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Nama STO Uplink</th>
                                <td>{{ $lop->nama_sto_uplink ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Port Metro</th>
                                <td>{{ $lop->port_metro ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>SFP</th>
                                <td>{{ $lop->sfp ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>ODP</th>
                                <td>{{ $lop->odp ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Port</th>
                                <td>{{ $lop->port ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <h5>Waktu Proyek</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th class="w-50">Start Project</th>
                                <td>{{ $lop->start_project ? $lop->start_project->format('d-m-Y') : '-' }}</td>
                            </tr>
                            <tr>
                                <th>TOC</th>
                                <td>{{ $lop->toc ? $lop->toc->format('d-m-Y') : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Plan OA</th>
                                <td>{{ $lop->tanggal_plan_oa ? $lop->tanggal_plan_oa->format('d-m-Y') : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Week Plan OA</th>
                                <td>{{ $lop->week_plan_oa ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <h5>Kontrak dan Kendala</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th class="w-50">LOP Downlink</th>
                                <td>{{ $lop->lop_downlink ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Kontrak Pengadaan</th>
                                <td>{{ $lop->kontrak_pengadaan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Kode IHLD</th>
                                <td>{{ $lop->kode_ihld ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Site Provider</th>
                                <td>{{ $lop->site_provider ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Kendala</th>
                                <td>{{ $lop->kendala ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Last Issue</th>
                                <td>{{ $lop->last_issue ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="col-md-12">
                    <h5>Informasi Tambahan</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th class="w-25">Created At</th>
                                <td>{{ $lop->created_at->format('Y-m-d') }}</td>
                            </tr>
                            <tr>
                                <th>Updated At</th>
                                <td>{{ $lop->updated_at->format('Y-m-d') }}</td>
                            </tr>
                            <tr>
                                <th>Created By</th>
                                <td>{{ $lop->user->full_name ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Site Modal -->
<div class="modal fade" id="editSiteModal" tabindex="-1" aria-labelledby="editSiteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('lop.update', $lop->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editSiteModalLabel">Edit Site {{ $lop->site_id_location }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="status_proyek" class="form-label">Status Proyek</label>
                        <select class="form-select @error('status_proyek') is-invalid @enderror" id="status_proyek" name="status_proyek">
                            <option value="">-- Pilih Status --</option>
                            <option value="MAT DEL" {{ $lop->status_proyek == 'MAT DEL' ? 'selected' : '' }}>MAT DEL</option>
                            <option value="DONE" {{ $lop->status_proyek == 'DONE' ? 'selected' : '' }}>DONE</option>
                            <option value="DONE UT" {{ $lop->status_proyek == 'DONE UT' ? 'selected' : '' }}>DONE UT</option>
                            <option value="SURVEY" {{ $lop->status_proyek == 'SURVEY' ? 'selected' : '' }}>SURVEY</option>
                            <option value="DONE SURVEY" {{ $lop->status_proyek == 'DONE SURVEY' ? 'selected' : '' }}>DONE SURVEY</option>
                            <option value="DROP" {{ $lop->status_proyek == 'DROP' ? 'selected' : '' }}>DROP</option>
                            <option value="OA" {{ $lop->status_proyek == 'OA' ? 'selected' : '' }}>OA</option>
                            <option value="MOS" {{ $lop->status_proyek == 'MOS' ? 'selected' : '' }}>MOS</option>
                            <option value="POWER ON" {{ $lop->status_proyek == 'POWER ON' ? 'selected' : '' }}>POWER ON</option>
                            <option value="INTEGRASI" {{ $lop->status_proyek == 'INTEGRASI' ? 'selected' : '' }}>INTEGRASI</option>
                            <option value="INSTALL RACK" {{ $lop->status_proyek == 'INSTALL RACK' ? 'selected' : '' }}>INSTALL RACK</option>
                        </select>
                        @error('status_proyek')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="last_issue" class="form-label">Last Issue</label>
                        <textarea class="form-control @error('last_issue') is-invalid @enderror" id="last_issue" name="last_issue" rows="3">{{ old('last_issue', $lop->last_issue) }}</textarea>
                        @error('last_issue')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="kendala" class="form-label">Kendala</label>
                        <textarea class="form-control @error('kendala') is-invalid @enderror" id="kendala" name="kendala" rows="3">{{ old('kendala', $lop->kendala) }}</textarea>
                        @error('kendala')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="tanggal_plan_oa" class="form-label">Tanggal Plan OA</label>
                        <input type="date" class="form-control @error('tanggal_plan_oa') is-invalid @enderror" id="tanggal_plan_oa" name="tanggal_plan_oa" value="{{ old('tanggal_plan_oa', $lop->tanggal_plan_oa ? $lop->tanggal_plan_oa->format('Y-m-d') : '') }}">
                        @error('tanggal_plan_oa')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection