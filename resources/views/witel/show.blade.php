@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('witel.search') }}" class="me-3">
            <i class="fas fa-arrow-left text-dark" style="font-size: 24px;"></i>
        </a>
        <h1 class="mb-0">{{ $witel->name }}</h1>
    </div>
    
    <div class="row mb-4">
        <div class="col-md-6">
            <h3 class="text-danger">Total Sites: {{ $totalSites }}</h3>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('witel.show', $witel->id) }}" method="GET">
                <div class="input-group">
                    <span class="input-group-text bg-white">
                        <i class="fas fa-search text-secondary"></i>
                    </span>
                    <input type="text" name="search" class="form-control form-control-lg" placeholder="Search by Site ID or Status..." value="{{ $search ?? '' }}">
                </div>
            </form>
        </div>
    </div>

    @if($lops->isEmpty())
        <div class="alert alert-info">
            No sites found for {{ $witel->name }} {{ $search ? 'matching your search' : '' }}.
        </div>
    @endif

    @foreach($lops as $lop)
        <div class="card mb-3 site-card" onclick="window.location='{{ route('witel.site-detail', $lop->id) }}'">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-9">
                        <div class="d-flex">
                            <div class="site-icon-circle me-3">
                                <span>{{ substr($lop->site_id_location, 0, 1) }}</span>
                            </div>
                            <div>
                                <h4 class="mb-1">{{ $lop->site_id_location }}</h4>
                                <div class="mb-2">
                                    <span class="status-badge 
                                        @if($lop->status_proyek == 'MAT DEL') bg-warning text-dark
                                        @elseif($lop->status_proyek == 'DONE') bg-success
                                        @elseif($lop->status_proyek == 'DONE UT') bg-success
                                        @elseif($lop->status_proyek == 'SURVEY') bg-info
                                        @elseif($lop->status_proyek == 'DONE SURVEY') bg-info
                                        @elseif($lop->status_proyek == 'DROP') bg-danger
                                        @elseif($lop->status_proyek == 'OA') bg-primary
                                        @elseif($lop->status_proyek == 'MOS') bg-secondary
                                        @elseif($lop->status_proyek == 'POWER ON') bg-success
                                        @elseif($lop->status_proyek == 'INTEGRASI') bg-primary
                                        @elseif($lop->status_proyek == 'INSTALL RACK') bg-info
                                        @else bg-secondary
                                        @endif">
                                        {{ $lop->status_proyek }}
                                    </span>
                                </div>
                                <p class="mb-1">Last Issue: {{ $lop->last_issue ?? 'No issue reported' }}</p>
                                @if($lop->koordinat)
                                    <p class="mb-0 text-muted">Koordinat: {{ $lop->koordinat }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex align-items-center justify-content-end">
                        <i class="fas fa-chevron-right text-muted"></i>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Tampilan Peta Mapbox -->
    <div class="card mb-4">
        <div class="card-header bg-white">
            <h4 class="mb-0">Peta Lokasi Sites</h4>
        </div>
        <div class="card-body">
            <div id="map" style="width: 100%; height: 500px; border-radius: 10px;"></div>
        </div>
        <div class="card-footer bg-white">
            <div class="d-flex flex-wrap justify-content-center">
                <div class="d-flex align-items-center me-3 mb-2">
                    <div style="width: 15px; height: 15px; background-color: #ffc107; border-radius: 50%; margin-right: 5px;"></div>
                    <small>MAT DEL</small>
                </div>
                <div class="d-flex align-items-center me-3 mb-2">
                    <div style="width: 15px; height: 15px; background-color: #198754; border-radius: 50%; margin-right: 5px;"></div>
                    <small>DONE/POWER ON</small>
                </div>
                <div class="d-flex align-items-center me-3 mb-2">
                    <div style="width: 15px; height: 15px; background-color: #0dcaf0; border-radius: 50%; margin-right: 5px;"></div>
                    <small>SURVEY/INSTALL</small>
                </div>
                <div class="d-flex align-items-center me-3 mb-2">
                    <div style="width: 15px; height: 15px; background-color: #dc3545; border-radius: 50%; margin-right: 5px;"></div>
                    <small>DROP</small>
                </div>
                <div class="d-flex align-items-center me-3 mb-2">
                    <div style="width: 15px; height: 15px; background-color: #0d6efd; border-radius: 50%; margin-right: 5px;"></div>
                    <small>OA/INTEGRASI</small>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <div style="width: 15px; height: 15px; background-color: #6c757d; border-radius: 50%; margin-right: 5px;"></div>
                    <small>MOS/LAINNYA</small>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .site-card {
        border-radius: 10px;
        transition: all 0.3s;
        cursor: pointer;
        border: 1px solid #f0f0f0;
    }
    
    .site-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .site-icon-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: #f1f1f1;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        font-weight: bold;
        color: #666;
    }
    
    .status-badge {
        display: inline-block;
        padding: 5px 15px;
        border-radius: 25px;
        color: #fff;
        font-weight: bold;
        font-size: 0.85rem;
    }
</style>

<!-- Script untuk Mapbox -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Memastikan Mapbox sudah dimuat
    if (typeof mapboxgl !== 'undefined') {
        // Inisialisasi Mapbox dengan API key Anda
        mapboxgl.accessToken = '{{ env('MAPBOX_API_KEY') }}';
        
        // Data lops dari controller
        const sites = @json($lops);
        
        // Menentukan warna marker berdasarkan status
        const getStatusColor = (status) => {
            switch(status) {
                case 'MAT DEL': 
                    return '#ffc107';
                case 'DONE':
                case 'DONE UT':
                case 'POWER ON':
                    return '#198754';
                case 'SURVEY':
                case 'DONE SURVEY':
                case 'INSTALL RACK':
                    return '#0dcaf0';
                case 'DROP':
                    return '#dc3545';
                case 'OA':
                case 'INTEGRASI':
                    return '#0d6efd';
                case 'MOS':
                default:
                    return '#6c757d';
            }
        };
        
        // Inisialisasi koordinat default
        let centerLat = -0.789275;
        let centerLng = 113.921327; // Koordinat Indonesia
        let defaultZoom = 5;
        
        // Hitung rata-rata koordinat jika data ada
        if (sites && sites.length > 0) {
            let totalLat = 0;
            let totalLng = 0;
            let validCoords = 0;
            
            sites.forEach(site => {
                if (site.koordinat) {
                    const coords = site.koordinat.split(',');
                    if (coords.length === 2) {
                        const lat = parseFloat(coords[0]);
                        const lng = parseFloat(coords[1]);
                        if (!isNaN(lat) && !isNaN(lng)) {
                            totalLat += lat;
                            totalLng += lng;
                            validCoords++;
                        }
                    }
                }
            });
            
            if (validCoords > 0) {
                centerLat = totalLat / validCoords;
                centerLng = totalLng / validCoords;
                defaultZoom = 8;
            }
        }
        
        // Inisialisasi map
        const map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [centerLng, centerLat],
            zoom: defaultZoom
        });
        
        // Tambahkan kontrol navigasi
        map.addControl(new mapboxgl.NavigationControl());
        
        // Tunggu sampai map loaded
        map.on('load', function() {
            // Tambahkan layer untuk site labels dan markers
            map.addSource('sites', {
                'type': 'geojson',
                'data': {
                    'type': 'FeatureCollection',
                    'features': sites.filter(site => site.koordinat).map(site => {
                        const coords = site.koordinat.split(',');
                        if (coords.length === 2) {
                            const lat = parseFloat(coords[0]);
                            const lng = parseFloat(coords[1]);
                            if (!isNaN(lat) && !isNaN(lng)) {
                                return {
                                    'type': 'Feature',
                                    'geometry': {
                                        'type': 'Point',
                                        'coordinates': [lng, lat]
                                    },
                                    'properties': {
                                        'site_id': site.site_id_location,
                                        'status': site.status_proyek,
                                        'last_issue': site.last_issue || 'No issue reported',
                                        'color': getStatusColor(site.status_proyek)
                                    }
                                };
                            }
                        }
                        return null;
                    }).filter(Boolean)
                }
            });
            
            // Tambahkan layer untuk markers
            map.addLayer({
                'id': 'site-markers',
                'type': 'circle',
                'source': 'sites',
                'paint': {
                    'circle-radius': 6,
                    'circle-color': ['get', 'color'],
                    'circle-stroke-width': 2,
                    'circle-stroke-color': '#ffffff'
                }
            });
            
            // Tambahkan layer untuk labels
            map.addLayer({
                'id': 'site-labels',
                'type': 'symbol',
                'source': 'sites',
                'layout': {
                    'text-field': ['get', 'site_id'],
                    'text-variable-anchor': ['top', 'bottom', 'left', 'right'],
                    'text-radial-offset': 1,
                    'text-justify': 'auto',
                    'text-size': 12,
                    'text-font': ['Open Sans Regular', 'Arial Unicode MS Regular'],
                    'text-allow-overlap': false,
                    'text-ignore-placement': false
                },
                'paint': {
                    'text-color': '#000000',
                    'text-halo-color': '#ffffff',
                    'text-halo-width': 1.5
                }
            });
            
            // Tambahkan popup saat klik pada marker
            map.on('click', 'site-markers', function(e) {
                const coordinates = e.features[0].geometry.coordinates.slice();
                const properties = e.features[0].properties;
                
                // Buat konten popup
                const popupContent = `
                    <h5>${properties.site_id}</h5>
                    <p><strong>Status:</strong> ${properties.status}</p>
                    <p><strong>Last Issue:</strong> ${properties.last_issue}</p>
                `;
                
                // Pastikan popup tidak tumpang tindih jika zoom level berubah
                while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                    coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                }
                
                new mapboxgl.Popup()
                    .setLngLat(coordinates)
                    .setHTML(popupContent)
                    .addTo(map);
            });
            
            // Ubah cursor saat hover di atas marker
            map.on('mouseenter', 'site-markers', function() {
                map.getCanvas().style.cursor = 'pointer';
            });
            
            map.on('mouseleave', 'site-markers', function() {
                map.getCanvas().style.cursor = '';
            });
        });
    } else {
        console.error('Mapbox belum dimuat! Pastikan Anda sudah menambahkan script Mapbox di layout.');
    }
});
</script>
@endsection