@extends('layouts.dashboard')

@section('content')
<div class="dashboard-content">
    <div class="container-fluid">
        <!-- Dashboard Analytics Section -->
        <div class="mb-5">
            <div class="row mb-4">
                <!-- KPI Cards -->
                <div class="col-6 col-md-3 mb-3">
                    <div class="kpi-card">
                        <span class="kpi-label">odp</span>
                        <h2 class="kpi-value" id="odp-value">{{ $kpiData['odp'] ?? '3.577' }}</h2>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="kpi-card">
                        <span class="kpi-label">port</span>
                        <h2 class="kpi-value" id="port-value">{{ $kpiData['port'] ?? '28.952' }}</h2>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="kpi-card">
                        <span class="kpi-label">durasiPekerjaan</span>
                        <h2 class="kpi-value" id="durasi-value">{{ $kpiData['durasi'] ?? '-7,75' }}</h2>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="d-flex flex-column h-100">
                        <button class="btn btn-danger mb-2 flex-grow-1 py-2" id="bigButton">BIG</button>
                        <button class="btn btn-danger flex-grow-1 py-2" id="miniButton">MINI</button>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <!-- Status by siteId Chart -->
                <div class="col-md-6 mb-4">
                    <div class="dashboard-card">
                        <h5 class="dashboard-card-title">STATUS by Site ID</h5>
                        <div class="chart-container">
                            <div id="statusChart"></div>
                            <div class="chart-center-label">
                                <div class="chart-center-title">siteId</div>
                                <div class="chart-center-value" id="statusSiteIdCount">{{ $statusData['total'] ?? '160' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kendala by siteId Chart -->
                <div class="col-md-6 mb-4">
                    <div class="dashboard-card">
                        <h5 class="dashboard-card-title">KENDALA by Site ID</h5>
                        <div class="chart-container">
                            <div id="kendalaChart"></div>
                            <div class="chart-center-label">
                                <div class="chart-center-title">siteId</div>
                                <div class="chart-center-value" id="kendalaSiteIdCount">{{ $kendalaData['total'] ?? '160' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <!-- Site Catuan by Week Chart -->
                <div class="col-md-6 mb-4">
                    <div class="dashboard-card">
                        <h5 class="dashboard-card-title">Site ID by WEEK PLAN OA</h5>
                        <div id="weekPlanChart"></div>
                    </div>
                </div>

                <!-- Regional Distribution Chart -->
                <div class="col-md-6 mb-4">
                    <div class="dashboard-card">
                        <h5 class="dashboard-card-title">Site ID by WITEL and PLATFORM</h5>
                        <div id="regionalChart"></div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <!-- WITEL Table -->
                <div class="col-12">
                    <div class="dashboard-card p-0">
                        <div class="witel-table-header">
                            <div class="row m-0">
                                <div class="col-1 py-2">#</div>
                                <div class="col-3 py-2">
                                    <div class="d-flex align-items-center">
                                        WITEL
                                        <i class="fas fa-caret-down ms-2"></i>
                                    </div>
                                </div>
                                <div class="col-2 py-2">Port</div>
                                <div class="col-3 py-2">Site ID</div>
                                <div class="col-3 py-2">Kendala</div>
                            </div>
                        </div>
                        <div class="witel-table-body" id="witelTableBody">
                            @foreach($witelData ?? [] as $index => $data)
                            <div class="row m-0 witel-table-row">
                                <div class="col-1 py-2">{{ $index + 1 }}.</div>
                                <div class="col-3 py-2">{{ $data['witel'] }}</div>
                                <div class="col-2 py-2">{{ $data['port'] }}</div>
                                <div class="col-3 py-2">{{ $data['site_id_location'] }}</div>
                                <div class="col-3 py-2 text-truncate">{{ $data['kendala'] }}</div>
                            </div>
                            @endforeach
                            @if(empty($witelData))
                            <div class="row m-0 witel-table-row">
                                <div class="col-1 py-2">1.</div>
                                <div class="col-3 py-2">SUMUT</div>
                                <div class="col-2 py-2">KPI</div>
                                <div class="col-3 py-2">10985654</div>
                                <div class="col-3 py-2">SMU JPP POLYGON</div>
                            </div>
                            <div class="row m-0 witel-table-row">
                                <div class="col-1 py-2">2.</div>
                                <div class="col-3 py-2">SUMUT</div>
                                <div class="col-2 py-2">PYB</div>
                                <div class="col-3 py-2">10949271</div>
                                <div class="col-3 py-2">SUMATERA UTARA</div>
                            </div>
                            <div class="row m-0 witel-table-row">
                                <div class="col-1 py-2">3.</div>
                                <div class="col-3 py-2">SUMUT</div>
                                <div class="col-2 py-2">SIH</div>
                                <div class="col-3 py-2">11091798</div>
                                <div class="col-3 py-2">SMU ODC-SIH-FAI</div>
                            </div>
                            <div class="row m-0 witel-table-row">
                                <div class="col-1 py-2">4.</div>
                                <div class="col-3 py-2">SUMUT</div>
                                <div class="col-2 py-2">TUK</div>
                                <div class="col-3 py-2">11075157</div>
                                <div class="col-3 py-2">SMU ODC-TUK-FAI</div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Services Section -->
        <div class="mb-5">
            <h1 class="mb-4 fw-bold">SIMPEL SERVICES</h1>
            
            <div class="row justify-content-center">
                <!-- ADD LOP Card -->
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <a href="{{ route('lop.create') }}" class="text-decoration-none">
                        <div class="service-card">
                            <div class="service-icon bg-blue">
                                <i class="fas fa-plus"></i>
                            </div>
                            <h4>ADD LOP</h4>
                        </div>
                    </a>
                </div>
                
                <!-- WITEL SEARCH Card -->
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <a href="{{ route('witel.search') }}" class="text-decoration-none">
                        <div class="service-card">
                            <div class="service-icon bg-red">
                                <i class="fas fa-search"></i>
                            </div>
                            <h4>WITEL SEARCH</h4>
                        </div>
                    </a>
                </div>
                
                <!-- FORMS Card -->
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <a href="{{ route('forms.index') }}" class="text-decoration-none">
                        <div class="service-card">
                            <div class="service-icon bg-primary">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <h4>FORMS</h4>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Calendar Section -->
        <div class="mb-4">
            <h1 class="mb-4 fw-bold">PLAN ACTIVITY</h1>
            
            <div class="calendar-container">
                <div class="calendar-header d-flex justify-content-between align-items-center mb-3">
                    <a href="{{ route('home', ['month' => $calendarData['prevMonth']['month'], 'year' => $calendarData['prevMonth']['year']]) }}" 
                       class="btn btn-link text-dark">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                    <h3 class="mb-0">{{ $calendarData['monthName'] }} {{ $calendarData['year'] }}</h3>
                    <a href="{{ route('home', ['month' => $calendarData['nextMonth']['month'], 'year' => $calendarData['nextMonth']['year']]) }}" 
                       class="btn btn-link text-dark">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </div>
                
                <div class="calendar border rounded p-3 bg-white">
                    <div class="weekdays d-flex justify-content-between mb-2">
                        <div class="text-center fw-bold">Min</div>
                        <div class="text-center fw-bold">Sen</div>
                        <div class="text-center fw-bold">Sel</div>
                        <div class="text-center fw-bold">Rab</div>
                        <div class="text-center fw-bold">Kam</div>
                        <div class="text-center fw-bold">Jum</div>
                        <div class="text-center fw-bold">Sab</div>
                    </div>
                    
                    <div class="days d-grid">
                        @php
                            $dayCount = 1;
                            $totalCells = $calendarData['startingDay'] + $calendarData['daysInMonth'];
                            if ($totalCells <= 35) {
                                $totalCells = 35;
                            } else {
                                $totalCells = 42;
                            }
                        @endphp
                        
                        @for ($i = 0; $i < $totalCells; $i++)
                            @if ($i < $calendarData['startingDay'])
                                <div class="day other-month"></div>
                            @elseif ($i < $calendarData['startingDay'] + $calendarData['daysInMonth'])
                                @php
                                    $currentDay = $dayCount;
                                    $classes = 'day';
                                    $dataDate = $calendarData['year'] . '-' . str_pad($calendarData['month'], 2, '0', STR_PAD_LEFT) . '-' . str_pad($currentDay, 2, '0', STR_PAD_LEFT);
                                    
                                    // Check for today
                                    if ($calendarData['today'] !== null && $currentDay == $calendarData['today']) {
                                        $classes .= ' today';
                                    }
                                    
                                    // Check for events
                                    $hasEvents = isset($calendarData['events'][$currentDay]);
                                    $hasTocEvents = false;
                                    $hasPlanOAEvents = false;
                                    
                                    if ($hasEvents) {
                                        foreach ($calendarData['events'][$currentDay] as $event) {
                                            if ($event['type'] === 'toc') {
                                                $hasTocEvents = true;
                                            } elseif ($event['type'] === 'plan_oa') {
                                                $hasPlanOAEvents = true;
                                            }
                                        }
                                    }
                                @endphp
                                
                                <div class="day-cell">
                                    <div class="{{ $classes }}" 
                                         data-date="{{ $dataDate }}"
                                         data-has-events="{{ $hasEvents ? 'true' : 'false' }}">
                                        {{ $currentDay }}
                                        
                                        @if ($hasTocEvents)
                                            <span class="event-dot toc-event"></span>
                                        @endif
                                        
                                        @if ($hasPlanOAEvents)
                                            <span class="event-dot plan-oa-event"></span>
                                        @endif
                                    </div>
                                </div>
                                
                                @php $dayCount++; @endphp
                            @else
                                <div class="day other-month"></div>
                            @endif
                        @endfor
                    </div>
                </div>
                
                <div class="calendar-legend mt-3">
                    <div class="d-flex justify-content-center">
                        <div class="legend-item me-4">
                            <span class="legend-dot today-dot"></span>
                            <span>Today</span>
                        </div>
                        <div class="legend-item me-4">
                            <span class="legend-dot toc-dot"></span>
                            <span>TOC</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-dot plan-oa-dot"></span>
                            <span>Plan OA</span>
                        </div>
                    </div>
                </div>
                
                <p class="calendar-tip text-center mt-2 mb-4 text-muted">Tap on a date to see events</p>
                
                <!-- Events Button -->
                <div class="d-flex justify-content-center">
                    <button class="btn btn-primary px-4 py-2 events-btn" data-bs-toggle="modal" data-bs-target="#eventsModal">
                        <i class="fas fa-calendar-day me-2"></i> View All Upcoming Events
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Information Modal -->
<div class="modal fade" id="filterInfoModal" tabindex="-1" aria-labelledby="filterInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterInfoModalLabel">Filter Info</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="filterInfoContent"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Date Event Modal -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div id="eventContainer"></div>
            </div>
        </div>
    </div>
</div>

<!-- Events List Modal -->
<div class="modal fade" id="eventsModal" tabindex="-1" aria-labelledby="eventsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title" id="eventsModalLabel">All Upcoming Events</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-2">
                <!-- Filter Tabs -->
                <div class="events-filter mb-3">
                    <div class="nav nav-pills events-tabs" id="events-tabs" role="tablist">
                        <button class="nav-link active" id="all-tab" data-bs-toggle="pill" data-bs-target="#all-events" type="button" role="tab" data-filter="all" data-period="all">
                            <i class="fas fa-circle-check me-1"></i> All
                        </button>
                        <button class="nav-link" id="toc-tab" data-bs-toggle="pill" data-bs-target="#toc-events" type="button" role="tab" data-filter="toc" data-period="all">
                            TOC
                        </button>
                        <button class="nav-link" id="plan-oa-tab" data-bs-toggle="pill" data-bs-target="#plan-oa-events" type="button" role="tab" data-filter="plan_oa" data-period="all">
                            Plan OA
                        </button>
                        <button class="nav-link" id="this-week-tab" data-bs-toggle="pill" data-bs-target="#this-week-events" type="button" role="tab" data-filter="all" data-period="this_week">
                            This Week
                        </button>
                        <button class="nav-link" id="this-month-tab" data-bs-toggle="pill" data-bs-target="#this-month-events" type="button" role="tab" data-filter="all" data-period="this_month">
                            This Month
                        </button>
                    </div>
                </div>
                
                <!-- Search Bar -->
                <div class="events-search mb-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" id="events-search-input" placeholder="Search by Site ID or Witel...">
                    </div>
                </div>
                
                <!-- Events List Container -->
                <div id="events-list-container">
                    <!-- Content will be loaded dynamically -->
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Dashboard Styles */
    .kpi-card {
        background-color: #f5f5f5;
        border-radius: 8px;
        padding: 15px;
        height: 100%;
    }
    
    .kpi-label {
        font-size: 14px;
        color: #666;
        font-weight: 500;
    }
    
    .kpi-value {
        font-size: 28px;
        font-weight: 600;
        margin: 0;
        margin-top: 5px;
    }
    
    .dashboard-card {
        background: #fff;
        border-radius: 8px;
        padding: 15px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        height: 100%;
    }
    
    .dashboard-card-title {
        margin-bottom: 15px;
        font-weight: 600;
    }
    
    /* Perbaikan style untuk chart container dan label tengah */
    .chart-container {
        position: relative;
        height: 320px; /* Ukuran seragam untuk kedua chart */
        width: 100%;
        margin: 0 auto;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .chart-center-label {
        position: absolute;
        top: 35%; /* Diubah dari 50% menjadi 47% untuk menggeser ke atas */
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        z-index: 5;
        pointer-events: none;
        background-color: transparent;
        width: 80px;
        height: 80px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .chart-center-title {
        font-size: 14px;
        color: #666;
        font-weight: 500;
        line-height: 1;
        margin-bottom: 5px;
    }

    .chart-center-value {
        font-size: 28px;
        font-weight: bold;
        color: #333;
        line-height: 1;
    }

    /* Ukuran seragam untuk kedua chart */
    #statusChart {
        width: 100%;
        height: 345px;
        margin: 0 auto;
    }

    #kendalaChart {
        width: 100%;
        height: 325px;
        margin: 0 auto;
    }
    
    #weekPlanChart, #regionalChart {
        width: 100%;
        min-height: 250px;
        display: block;
        position: relative;
    }
    
    .witel-table-header {
        background-color: #dc0000;
        color: white;
        font-weight: 600;
    }
    
    .witel-table-row {
        border-bottom: 1px solid #eee;
    }
    
    .witel-table-row:hover {
        background-color: #f9f9f9;
        cursor: pointer;
    }
    
    #chartTitleVendor {
        color: #4285f4;
        font-weight: 500;
    }

    #chartTitleHuawei {
        color: #34a853;
        font-weight: 500;
    }

    #chartTitleNull {
        color: #ff9800;
        font-weight: 500;
    }
        
    #bigButton, #miniButton {
        font-size: 20px;
        font-weight: bold;
    }

    /* Service Card Styles */
    .dashboard-content {
        padding: 20px 0;
    }
    
    .service-card {
        background-color: #fff;
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        padding: 25px 20px;
        text-align: center;
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    
    .service-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
    }
    
    .service-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }
    
    .service-icon i {
        font-size: 32px;
        color: #fff;
    }
    
    .service-card h4 {
        margin: 0;
        color: #333;
        font-weight: 600;
    }
    
    .bg-blue {
        background-color: #0077ff;
    }
    
    .bg-red {
        background-color: #dc0000;
    }
    
    /* Calendar Styles */
    .calendar-container {
        max-width: 800px;
        margin: 0 auto;
    }
    
    .calendar-header h3 {
        font-weight: 600;
    }
    
    .days {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 10px;
    }
    
    .day-cell {
        position: relative;
    }
    
    .day {
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.2s;
        position: relative;
    }
    
    .day:hover {
        background-color: #f0f0f0;
    }
    
    .day.other-month {
        color: #aaa;
    }
    
    .day.today {
        background-color: #dc0000;
        color: white;
    }
    
    .event-dot {
        position: absolute;
        width: 8px;
        height: 8px;
        border-radius: 50%;
    }
    
    .toc-event {
        background-color: #28a745;
        bottom: 2px;
        left: calc(50% - 8px);
    }
    
    .plan-oa-event {
        background-color: #ffc107;
        bottom: 2px;
        right: calc(50% - 8px);
    }
    
    .calendar-legend {
        font-size: 14px;
    }
    
    .legend-item {
        display: flex;
        align-items: center;
    }
    
    .legend-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        margin-right: 5px;
    }
    
    .today-dot {
        background-color: #dc0000;
    }
    
    .toc-dot {
        background-color: #28a745;
    }
    
    .plan-oa-dot {
        background-color: #ffc107;
    }
    
    .calendar-tip {
        font-size: 14px;
    }
    
    /* Event Cards */
    .event-card {
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 10px;
    }
    
    .event-card.toc {
        background-color: #28a745;
    }
    
    .event-card.plan-oa {
        background-color: #ffc107;
    }
    
    .event-card-header {
        padding: 15px;
        color: white;
    }
    
    .event-card.plan-oa .event-card-header {
        color: #212529;
    }
    
    .event-card-content {
        padding: 15px;
        background: white;
    }
    
    .event-meta {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
    }
    
    .event-meta i {
        margin-right: 8px;
    }

    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    /* Style untuk tombol aktif */
    #bigButton.active, #miniButton.active {
        background-color: #b00000;
        box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.2);
    }
    
    /* Events Button */
    .events-btn {
        background-color: #0077ff;
        border-color: #0077ff;
        font-weight: 600;
    }
    
    .events-btn:hover {
        background-color: #0062cc;
        border-color: #0062cc;
    }
    
    /* Events Modal Styles */
    .events-filter {
        overflow-x: auto;
        white-space: nowrap;
        padding-bottom: 10px;
    }
    
    .events-tabs {
        display: flex;
    }
    
    .events-tabs .nav-link {
        padding: 10px 15px;
        border-radius: 50px;
        margin-right: 10px;
        color: #666;
    }
    
    .events-tabs .nav-link.active {
        background-color: #dc0000;
        color: white;
    }
    
    .events-list-card {
        background-color: #28a745;
        border-radius: 10px;
        margin-bottom: 15px;
        cursor: pointer;
        transition: transform 0.2s;
        overflow: hidden;
    }
    
    .events-list-card:hover {
        transform: translateY(-3px);
    }
    
    .events-list-card.plan-oa {
        background-color: #ffc107;
    }
    
    .events-list-header {
        padding: 15px;
        color: white;
    }
    
    .events-list-card.plan-oa .events-list-header {
        color: #212529;
    }
    
    .events-list-content {
        background-color: white;
        padding: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .event-site-info {
        display: flex;
        align-items: center;
    }
    
    .event-witel-info {
        display: flex;
        align-items: center;
    }

    /* Filter notification */
    #filter-notification {
        position: fixed;
        top: 10px;
        right: 10px;
        z-index: 1050;
        max-width: 350px;
    }

    /* Debug Panel */
    .debug-panel {
        position: fixed;
        bottom: 10px;
        right: 10px;
        background: rgba(0,0,0,0.8);
        color: #fff;
        padding: 10px;
        border-radius: 5px;
        font-family: monospace;
        font-size: 12px;
        max-width: 300px;
        max-height: 200px;
        overflow: auto;
        z-index: 9999;
    }
    
    /* Filter Breadcrumbs */
    .filter-breadcrumbs {
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 4px;
        padding: 8px 12px;
        margin-bottom: 15px;
    }

    .filter-badge {
        cursor: pointer;
        padding: 5px 10px;
        border-radius: 20px;
        font-weight: normal;
    }

    .filter-badge:hover {
        opacity: 0.9;
    }

    .filter-badge i {
        font-size: 10px;
        vertical-align: middle;
    }

    #reset-all-filters {
        font-size: 12px;
        padding: 3px 8px;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded');
    
    // Verify if ApexCharts is loaded
    if (typeof ApexCharts === 'undefined') {
        console.error('ApexCharts library is not loaded. Make sure it is included in your layout.');
        return;
    }
    
    // Data untuk chart
    const statusData = {
        labels: {!! json_encode($statusData['labels'] ?? ['DONE UT', 'POWER ON', 'DONE SURVEY', 'MAT DEL', 'OA', 'SURVEY', 'MOS', 'DROP', 'DONE', 'INTEGRASI', 'INSTALL RACK']) !!},
        series: {!! json_encode($statusData['series'] ?? [22.2, 22.2, 22.2, 11.1, 22.2, 0, 11.1, 0, 0, 11.1, 0]) !!},
        total: {{ $statusData['total'] ?? 160 }},
        colors: [
            '#4285f4', // DONE UT - biru
            '#34a853', // POWER ON - hijau
            '#1a73e8', // DONE SURVEY - biru muda
            '#ea4335', // MAT DEL - merah
            '#fbbc05', // OA - kuning
            '#4285f4', // SURVEY - biru
            '#0f9d58', // MOS - hijau tua
            '#db4437', // DROP - merah
            '#4285f4', // DONE - biru
            '#f4b400', // INTEGRASI - kuning
            '#0f9d58'  // INSTALL RACK - hijau
        ]
    };
    
    const kendalaData = {
        labels: {!! json_encode($kendalaData['labels'] ?? ['NO ISSUE', 'SFP BIDI', 'WAITING UPLINK', 'PERMIT', 'WAITING OTN', 'COMMCASE', 'PONDASI', 'MIGRASI', 'NEW PLN', 'RELOC', 'L2SWITCH', 'UPGRADE PLN']) !!},
        series: {!! json_encode($kendalaData['series'] ?? [55.5, 0, 11.1, 11.1, 0, 0, 0, 0, 0, 11.1, 11.1, 0]) !!},
        total: {{ $kendalaData['total'] ?? 160 }},
        colors: [
            '#f4b400', // NO ISSUE - kuning
            '#4285f4', // SFP BIDI - biru
            '#673ab7', // WAITING UPLINK - ungu
            '#ea4335', // PERMIT - merah
            '#0f9d58', // WAITING OTN - hijau
            '#db4437', // COMMCASE - merah
            '#9c27b0', // PONDASI - ungu
            '#ff5722', // MIGRASI - oranye
            '#795548', // NEW PLN - coklat
            '#0f9d58', // RELOC - hijau
            '#4285f4', // L2SWITCH - biru
            '#607d8b'  // UPGRADE PLN - abu-abu
        ]
    };
    
    const weeklyData = {
        categories: {!! json_encode($weeklyData['categories'] ?? ['Apr W2', 'Apr W1', 'Mar W2', 'Feb W3', 'Feb W2', 'Apr W3', 'Feb W1', 'Apr W4']) !!},
        data: {!! json_encode($weeklyData['data'] ?? [47, 46, 16, 15, 11, 7, 5, 2]) !!}
    };
    
    const regionalData = {
        categories: {!! json_encode($regionalData['categories'] ?? ['RIDAR', 'SUMSEL', 'BENGKULU', 'BABEL', 'LAMPUNG', 'JAMBI', 'MEDAN']) !!},
        zte: {!! json_encode($regionalData['zte'] ?? [44, 25, 23, 17, 12, 11, 9]) !!},
        huawei: {!! json_encode($regionalData['huawei'] ?? [20, 15, 10, 8, 6, 5, 4]) !!},
        null: {!! json_encode($regionalData['null'] ?? [5, 3, 2, 1, 0, 0, 0]) !!}
    };
    
    // Global Filter State
    let globalFilterState = {
        sizeOlt: null, // 'BIG' atau 'MINI'
        status: null,
        kendala: null,
        week: null,
        witel: null,
        platform: null  // 'ZTE', 'HUAWEI', atau 'null'
    };
    
    // Function untuk menghitung nilai segmen dengan akurat
    function calculateSegmentValue(segmentIndex, chartType) {
        // Tentukan data yang akan digunakan
        let labels, series, total;
        
        // Gunakan data yang sudah difilter jika tersedia
        if (window.filteredData) {
            if (chartType === 'status' && window.filteredData.statusData) {
                labels = window.filteredData.statusData.labels;
                series = window.filteredData.statusData.series;
                total = window.filteredData.statusData.total;
            } else if (chartType === 'kendala' && window.filteredData.kendalaData) {
                labels = window.filteredData.kendalaData.labels;
                series = window.filteredData.kendalaData.series;
                total = window.filteredData.kendalaData.total;
            }
        }
        
        // Jika tidak ada data filter, gunakan data default
        if (!labels || !series) {
            if (chartType === 'status') {
                labels = statusData.labels;
                series = statusData.series;
                total = statusData.total;
            } else {
                labels = kendalaData.labels;
                series = kendalaData.series;
                total = kendalaData.total;
            }
        }
        
        // Pastikan index valid
        if (segmentIndex >= 0 && segmentIndex < series.length) {
            // Hitung nilai berdasarkan persentase dan total
            return Math.round((series[segmentIndex] / 100) * total);
        }
        
        return total; // Kembalikan total jika index tidak valid
    }
    
    try {
        console.log('Initializing charts');
        
        // Variables to track selected segments and filters
        let selectedStatusIndex = -1;
        let selectedKendalaIndex = -1;
        let activeFilter = null; // null, 'BIG', or 'MINI'
        
        // Tambahkan tracking untuk segment yang terpilih
        let selectedStatusSegment = null;
        let selectedKendalaSegment = null;
        
        // Inisialisasi chart status
        const statusChartOptions = {
            series: statusData.series,
            chart: {
                type: 'donut',
                height: 340,
                events: {
                    dataPointSelection: function(event, chartContext, config) {
                        const clickedIndex = config.dataPointIndex;
                        
                        // Jika mengklik segment yang sama, hapus filter
                        if (selectedStatusIndex === clickedIndex) {
                            selectedStatusIndex = -1;
                            selectedStatusSegment = null;
                            globalFilterState.status = null;
                            
                            // Reset highlight pada segment
                            this.toggleDataPointSelection(clickedIndex);
                            this.toggleDataPointSelection(clickedIndex);
                        } else {
                            const status = window.filteredData && window.filteredData.statusData ? 
                                window.filteredData.statusData.labels[clickedIndex] : 
                                statusData.labels[clickedIndex];
                            
                            // Update nilai center chart
                            const segmentValue = calculateSegmentValue(clickedIndex, 'status');
                            document.getElementById('statusSiteIdCount').textContent = segmentValue;
                            
                            // Simpan segmen yang dipilih
                            selectedStatusIndex = clickedIndex;
                            selectedStatusSegment = status;
                            globalFilterState.status = status;
                        }
                        
                        // Apply all filters to update all dashboard elements
                        applyAllFilters();
                    }
                }
            },
            labels: statusData.labels,
            colors: statusData.colors,
            legend: {
                show: true,
                position: 'bottom',
                fontSize: '12px',
                formatter: function(seriesName, opts) {
                    return `${seriesName}: ${opts.w.globals.series[opts.seriesIndex]}%`;
                }
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '65%',
                        background: 'transparent',
                        labels: {
                            show: false
                        }
                    },
                    customScale: 0.85,
                    offsetY: 0
                }
            },
            dataLabels: {
                enabled: false
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        height: 280
                    }
                }
            }]
        };
        
        // Inisialisasi chart kendala
        const kendalaChartOptions = {
            series: kendalaData.series,
            chart: {
                type: 'donut',
                height: 350,
                events: {
                    dataPointSelection: function(event, chartContext, config) {
                        const clickedIndex = config.dataPointIndex;
                        
                        // Jika mengklik segment yang sama, hapus filter
                        if (selectedKendalaIndex === clickedIndex) {
                            selectedKendalaIndex = -1;
                            selectedKendalaSegment = null;
                            globalFilterState.kendala = null;
                            
                            // Reset highlight pada segment
                            this.toggleDataPointSelection(clickedIndex);
                            this.toggleDataPointSelection(clickedIndex);
                        } else {
                            const kendala = window.filteredData && window.filteredData.kendalaData ? 
                                window.filteredData.kendalaData.labels[clickedIndex] : 
                                kendalaData.labels[clickedIndex];
                            
                            // Update nilai center chart
                            const segmentValue = calculateSegmentValue(clickedIndex, 'kendala');
                            document.getElementById('kendalaSiteIdCount').textContent = segmentValue;
                            
                            // Simpan segmen yang dipilih
                            selectedKendalaIndex = clickedIndex;
                            selectedKendalaSegment = kendala;
                            globalFilterState.kendala = kendala;
                        }
                        
                        // Apply all filters to update all dashboard elements
                        applyAllFilters();
                    }
                }
            },
            labels: kendalaData.labels,
            colors: kendalaData.colors,
            legend: {
                show: true,
                position: 'bottom',
                fontSize: '12px',
                formatter: function(seriesName, opts) {
                    return `${seriesName}: ${opts.w.globals.series[opts.seriesIndex]}%`;
                }
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '65%',
                        background: 'transparent',
                        labels: {
                            show: false
                        }
                    },
                    customScale: 0.85,
                    offsetY: 0
                }
            },
            dataLabels: {
                enabled: false
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        height: 280
                    }
                }
            }]
        };
        
        // Check if elements exist
        if (!document.getElementById('statusChart') || !document.getElementById('kendalaChart')) {
            console.error('Chart elements not found');
            return;
        }
        
        // Inisialisasi chart
        const statusChart = new ApexCharts(document.querySelector("#statusChart"), statusChartOptions);
        statusChart.render();
        window.statusChart = statusChart;
        console.log('Status chart rendered');
        
        const kendalaChart = new ApexCharts(document.querySelector("#kendalaChart"), kendalaChartOptions);
        kendalaChart.render();
        window.kendalaChart = kendalaChart;
        console.log('Kendala chart rendered');
        
        // Inisialisasi chart weekly plan
        const weekPlanChart = new ApexCharts(document.querySelector("#weekPlanChart"), {
            chart: {
                type: 'bar',
                height: 250,
                toolbar: {
                    show: false
                },
                events: {
                    dataPointSelection: function(event, chartContext, config) {
                        const weekIndex = config.dataPointIndex;
                        const weekLabel = weeklyData.categories[weekIndex];
                        
                        // Toggle filter
                        if (globalFilterState.week === weekLabel) {
                            globalFilterState.week = null;
                        } else {
                            globalFilterState.week = weekLabel;
                        }
                        
                        // Apply all filters
                        applyAllFilters();
                    }
                }
            },
            series: [{
                name: 'Record Count',
                data: weeklyData.data
            }],
            xaxis: {
                categories: weeklyData.categories
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: true,
                formatter: function (val) {
                    return val;
                },
                offsetY: -20,
                style: {
                    fontSize: '13px',
                    colors: ["#304758"]
                }
            },
            colors: ['#4285f4'],
            grid: {
                show: false
            },
            yaxis: {
                min: 0,
                max: Math.max(...weeklyData.data) + 10
            }
        });
        weekPlanChart.render();
        window.weekPlanChart = weekPlanChart;
        console.log('Weekly plan chart rendered');
        
        // Inisialisasi chart regional dengan multiple series
        const regionalChart = new ApexCharts(document.querySelector("#regionalChart"), {
            chart: {
                type: 'bar',
                height: 250,
                stacked: true,
                toolbar: {
                    show: false
                },
                events: {
                    dataPointSelection: function(event, chartContext, config) {
                        const witelIndex = config.dataPointIndex;
                        const platformIndex = config.seriesIndex;
                        const witelLabel = regionalData.categories[witelIndex];
                        
                        // Platform berdasarkan index series
                        let platformLabel;
                        if (platformIndex === 0) platformLabel = 'ZTE';
                        else if (platformIndex === 1) platformLabel = 'HUAWEI';
                        else if (platformIndex === 2) platformLabel = 'null';
                        
                        // Toggle filter Witel
                        if (globalFilterState.witel === witelLabel && globalFilterState.platform === platformLabel) {
                            globalFilterState.witel = null;
                            globalFilterState.platform = null;
                        } else {
                            globalFilterState.witel = witelLabel;
                            globalFilterState.platform = platformLabel;
                        }
                        
                        // Apply all filters
                        applyAllFilters();
                    }
                }
            },
            series: [
                {
                    name: 'ZTE',
                    data: regionalData.zte
                },
                {
                    name: 'HUAWEI',
                    data: regionalData.huawei
                },
                {
                    name: 'null',
                    data: regionalData.null
                }
            ],
            xaxis: {
                categories: regionalData.categories
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: true,
                formatter: function (val) {
                    return val;
                },
                offsetY: -5,
                style: {
                    fontSize: '13px',
                    colors: ["#304758"]
                }
            },
            colors: ['#4285f4', '#34a853', '#ff9800'], // Biru untuk ZTE, Hijau untuk HUAWEI, Orange untuk null
            grid: {
                show: false
            },
            legend: {
                show: true,
                position: 'bottom'
            }
        });
        regionalChart.render();
        window.regionalChart = regionalChart;
        console.log('Regional chart rendered');
        
        // Reset nilai jika klik di luar chart
        document.addEventListener('click', function(event) {
            const clickedElement = event.target;
            const isStatusChartClick = clickedElement.closest('#statusChart');
            const isKendalaChartClick = clickedElement.closest('#kendalaChart');
            const isWeekPlanClick = clickedElement.closest('#weekPlanChart');
            const isRegionalChartClick = clickedElement.closest('#regionalChart');
            const isFilterButton = clickedElement.id === 'bigButton' || clickedElement.id === 'miniButton';
            const isFilterBadge = clickedElement.closest('.filter-badge');
            const isResetButton = clickedElement.id === 'reset-all-filters';
            
            // Jika klik di luar semua elemen interaktif
            if (!isStatusChartClick && !isKendalaChartClick && !isWeekPlanClick && !isRegionalChartClick && 
                !isFilterButton && !isFilterBadge && !isResetButton && 
                clickedElement.tagName !== 'path' && clickedElement.tagName !== 'svg') {
                
                // Tidak ada aksi khusus untuk klik di luar elemen
                // Filter handling dilakukan oleh event handler masing-masing elemen
            }
        });
        
    } catch (error) {
        console.error('Error initializing charts:', error);
    }
    
    // Add debug panel (can be removed in production)
    const debugPanel = document.createElement('div');
    debugPanel.className = 'debug-panel d-none'; // add d-none to hide by default
    debugPanel.id = 'debugPanel';
    debugPanel.innerHTML = '<strong>Debug Panel</strong><br>Click BIG/MINI to see details';
    document.body.appendChild(debugPanel);
    
    // Setup for filter buttons
    const bigButton = document.getElementById('bigButton');
    const miniButton = document.getElementById('miniButton');
    let activeFilter = null;

    // Improved BIG button handler (mutual exclusion)
    bigButton.addEventListener('click', function() {
        console.log('BIG button clicked');
        
        if (activeFilter === 'BIG') {
            // Deactivate
            bigButton.classList.remove('active');
            bigButton.style.backgroundColor = '';
            activeFilter = null;
            globalFilterState.sizeOlt = null;
        } else {
            // Activate
            bigButton.classList.add('active');
            miniButton.classList.remove('active');
            bigButton.style.backgroundColor = '#b00000';
            miniButton.style.backgroundColor = '';
            activeFilter = 'BIG';
            globalFilterState.sizeOlt = 'BIG';
        }
        
        // Apply all filters
        applyAllFilters();
    });
    
    // Improved MINI button handler (mutual exclusion)
    miniButton.addEventListener('click', function() {
        console.log('MINI button clicked');
        
        if (activeFilter === 'MINI') {
            // Deactivate
            miniButton.classList.remove('active');
            miniButton.style.backgroundColor = '';
            activeFilter = null;
            globalFilterState.sizeOlt = null;
        } else {
            // Activate
            miniButton.classList.add('active');
            bigButton.classList.remove('active');
            miniButton.style.backgroundColor = '#b00000';
            bigButton.style.backgroundColor = '';
            activeFilter = 'MINI';
            globalFilterState.sizeOlt = 'MINI';
        }
        
        // Apply all filters
        applyAllFilters();
    });
    
    // Function untuk mencatat dan menampilkan filter yang aktif
    function updateFilterBreadcrumbs() {
        // Hapus breadcrumbs yang ada
        const existingBreadcrumbs = document.getElementById('filter-breadcrumbs');
        if (existingBreadcrumbs) {
            existingBreadcrumbs.remove();
        }
        
        // Cek jika ada filter yang aktif
        const hasActiveFilters = Object.values(globalFilterState).some(value => value !== null);
        if (!hasActiveFilters) return;
        
        // Buat container untuk breadcrumbs
        const breadcrumbsContainer = document.createElement('div');
        breadcrumbsContainer.id = 'filter-breadcrumbs';
        breadcrumbsContainer.className = 'filter-breadcrumbs mt-2 mb-3';
        breadcrumbsContainer.style.padding = '8px 12px';
        breadcrumbsContainer.style.background = '#f8f9fa';
        breadcrumbsContainer.style.borderRadius = '4px';
        breadcrumbsContainer.style.fontSize = '14px';
        
        // Label untuk filter aktif
        let breadcrumbsHTML = '<span class="me-2"><strong>Filter Aktif:</strong></span>';
        
        // Tambahkan setiap filter yang aktif
        if (globalFilterState.sizeOlt) {
            breadcrumbsHTML += `<span class="badge bg-info me-2 filter-badge" data-filter="sizeOlt">${globalFilterState.sizeOlt} <i class="fas fa-times ms-1"></i></span>`;
        }
        if (globalFilterState.status) {
            breadcrumbsHTML += `<span class="badge bg-primary me-2 filter-badge" data-filter="status">Status: ${globalFilterState.status} <i class="fas fa-times ms-1"></i></span>`;
        }
        if (globalFilterState.kendala) {
            breadcrumbsHTML += `<span class="badge bg-warning me-2 filter-badge" data-filter="kendala">Kendala: ${globalFilterState.kendala} <i class="fas fa-times ms-1"></i></span>`;
        }
        if (globalFilterState.week) {
            breadcrumbsHTML += `<span class="badge bg-success me-2 filter-badge" data-filter="week">Week: ${globalFilterState.week} <i class="fas fa-times ms-1"></i></span>`;
        }
        if (globalFilterState.witel) {
            breadcrumbsHTML += `<span class="badge bg-secondary me-2 filter-badge" data-filter="witel">Witel: ${globalFilterState.witel} <i class="fas fa-times ms-1"></i></span>`;
        }
        if (globalFilterState.platform) {
            breadcrumbsHTML += `<span class="badge bg-dark me-2 filter-badge" data-filter="platform">Platform: ${globalFilterState.platform} <i class="fas fa-times ms-1"></i></span>`;
        }
        
        // Tambahkan reset button
        breadcrumbsHTML += `<button class="btn btn-sm btn-outline-danger ms-2" id="reset-all-filters">Reset All</button>`;
        
        breadcrumbsContainer.innerHTML = breadcrumbsHTML;
        
        // Tambahkan breadcrumbs ke dalam dashboard
        const dashboardContent = document.querySelector('.dashboard-content .container-fluid');
        if (dashboardContent) {
            dashboardContent.insertBefore(breadcrumbsContainer, dashboardContent.firstChild);
            
            // Tambahkan event listener untuk badge dan reset button
            document.querySelectorAll('.filter-badge').forEach(badge => {
                badge.addEventListener('click', function() {
                    const filterType = this.dataset.filter;
                    clearFilter(filterType);
                });
            });
            
            document.getElementById('reset-all-filters').addEventListener('click', resetAllFilters);
        }
    }
    
    // Function untuk menerapkan semua filter sekaligus
    function applyAllFilters() {
        showLoadingOverlay();
        
        // Siapkan payload berdasarkan filter yang aktif
        const payload = {};
        
        if (globalFilterState.sizeOlt) {
            payload.filter = globalFilterState.sizeOlt;
        }
        if (globalFilterState.status) {
            payload.status = globalFilterState.status;
        }
        if (globalFilterState.kendala) {
            payload.kendala = globalFilterState.kendala;
        }
        if (globalFilterState.week) {
            payload.week = globalFilterState.week;
        }
        if (globalFilterState.witel) {
            payload.witel = globalFilterState.witel;
        }
        if (globalFilterState.platform) {
            payload.platform = globalFilterState.platform;
        }
        
        // Jika tidak ada filter aktif, reset ke semua data
        if (Object.keys(payload).length === 0) {
            payload.reset = true;
        }
        
        // Update current filter untuk kompatibilitas dengan kode lama
        window.currentFilter = globalFilterState.sizeOlt || 'ALL';
        
        // Ambil CSRF token
        const token = document.querySelector('meta[name="csrf-token"]')?.content || '';
        
        console.log('Applying filters with payload:', payload);
        
        // Fetch data dengan semua filter yang aktif
        fetch('/dashboard/filter', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(payload),
            credentials: 'same-origin'
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            // Update global data
            window.filteredData = data;
            
            // Update all dashboard elements
            updateAllDashboardElements(data);
            
            // Update filter breadcrumbs
            updateFilterBreadcrumbs();
            
            hideLoadingOverlay();
        })
        .catch(error => {
            console.error('Error applying filters:', error);
            showErrorNotification('Error applying filters: ' + error.message);
            hideLoadingOverlay();
        });
    }
    
    // Function untuk memperbarui semua elemen dashboard
    function updateAllDashboardElements(data) {
        // Update KPI values
        if (data.kpiData) {
            document.getElementById('odp-value').innerText = data.kpiData.odp;
            document.getElementById('port-value').innerText = data.kpiData.port;
            document.getElementById('durasi-value').innerText = data.kpiData.durasi;
        }
        
        // Update Status Chart
        if (data.statusData && window.statusChart) {
            window.statusChart.updateOptions({ 
                series: data.statusData.series,
                labels: data.statusData.labels
            });
            
            // Jika tidak ada filter status aktif, update nilai di tengah
            if (!globalFilterState.status) {
                document.getElementById('statusSiteIdCount').textContent = data.statusData.total;
            } else {
                // Jika ada filter status aktif, recalculate nilai segmen
                const segmentIndex = data.statusData.labels.indexOf(globalFilterState.status);
                if (segmentIndex >= 0) {
                    const segmentValue = Math.round((data.statusData.series[segmentIndex] / 100) * data.statusData.total);
                    document.getElementById('statusSiteIdCount').textContent = segmentValue;
                }
            }
        }
        
        // Update Kendala Chart
        if (data.kendalaData && window.kendalaChart) {
            window.kendalaChart.updateOptions({ 
                series: data.kendalaData.series,
                labels: data.kendalaData.labels
            });
            
            // Jika tidak ada filter kendala aktif, update nilai di tengah
            if (!globalFilterState.kendala) {
                document.getElementById('kendalaSiteIdCount').textContent = data.kendalaData.total;
            } else {
                // Jika ada filter kendala aktif, recalculate nilai segmen
                const segmentIndex = data.kendalaData.labels.indexOf(globalFilterState.kendala);
                if (segmentIndex >= 0) {
                    const segmentValue = Math.round((data.kendalaData.series[segmentIndex] / 100) * data.kendalaData.total);
                    document.getElementById('kendalaSiteIdCount').textContent = segmentValue;
                }
            }
        }
        
        // Update Weekly Chart
        if (data.weeklyData && window.weekPlanChart) {
            window.weekPlanChart.updateOptions({
                series: [{
                    name: 'Record Count',
                    data: data.weeklyData.data
                }],
                xaxis: {
                    categories: data.weeklyData.categories
                }
            });
        }
        
        // Update Regional Chart
        if (data.regionalData && window.regionalChart) {
            window.regionalChart.updateOptions({
                series: [
                    {
                        name: 'ZTE',
                        data: data.regionalData.zte
                    },
                    {
                        name: 'HUAWEI',
                        data: data.regionalData.huawei
                    },
                    {
                        name: 'null',
                        data: data.regionalData.null
                    }
                ],
                xaxis: {
                    categories: data.regionalData.categories
                }
            });
        }
        
        // Update Witel Table
        if (data.witelData) {
            updateWitelTable(data.witelData);
        }
    }
    
    // Function untuk mereset semua filter
    function resetAllFilters() {
        // Reset global filter state
        globalFilterState = {
            sizeOlt: null,
            status: null,
            kendala: null,
            week: null,
            witel: null,
            platform: null
        };
        
        // Reset UI state
        if (window.statusChart) {
            window.statusChart.resetSeries();
            selectedStatusIndex = -1;
            selectedStatusSegment = null;
        }
        
        if (window.kendalaChart) {
            window.kendalaChart.resetSeries();
            selectedKendalaIndex = -1;
            selectedKendalaSegment = null;
        }
        
        // Reset button states
        document.getElementById('bigButton').classList.remove('active');
        document.getElementById('bigButton').style.backgroundColor = '';
        document.getElementById('miniButton').classList.remove('active');
        document.getElementById('miniButton').style.backgroundColor = '';
        activeFilter = null;
        
        // Apply reset to fetch all data
        applyAllFilters();
    }
    
    // Function untuk menghapus filter spesifik
    function clearFilter(filterType) {
        if (filterType && globalFilterState[filterType] !== undefined) {
            globalFilterState[filterType] = null;
            
            // Reset UI components based on filter type
            if (filterType === 'sizeOlt') {
                document.getElementById('bigButton').classList.remove('active');
                document.getElementById('bigButton').style.backgroundColor = '';
                document.getElementById('miniButton').classList.remove('active');
                document.getElementById('miniButton').style.backgroundColor = '';
                activeFilter = null;
            }
            else if (filterType === 'status' && window.statusChart) {
                window.statusChart.resetSeries();
                selectedStatusIndex = -1;
                selectedStatusSegment = null;
            }
            else if (filterType === 'kendala' && window.kendalaChart) {
                window.kendalaChart.resetSeries();
                selectedKendalaIndex = -1;
                selectedKendalaSegment = null;
            }
            
            // Apply remaining filters
            applyAllFilters();
        }
    }
    
    // Function untuk update tabel witel
    function updateWitelTable(witelData) {
        const tableBody = document.getElementById('witelTableBody');
        if (!tableBody) {
            console.error('Witel table body element not found');
            return;
        }
        
        tableBody.innerHTML = '';
        
        if (witelData.length === 0) {
            const emptyRow = document.createElement('div');
            emptyRow.className = 'row m-0 witel-table-row';
            emptyRow.innerHTML = `
                <div class="col-12 py-3 text-center">Tidak ada data yang sesuai dengan filter</div>
            `;
            tableBody.appendChild(emptyRow);
            return;
        }
        
        witelData.forEach((data, index) => {
            const row = document.createElement('div');
            row.className = 'row m-0 witel-table-row';
            
            // Highlight row if it matches the current witel filter
            if (globalFilterState.witel && globalFilterState.witel === data.witel) {
                row.style.backgroundColor = '#f0f0f0';
            }
            
            row.innerHTML = `
                <div class="col-1 py-2">${index + 1}.</div>
                <div class="col-3 py-2">${data.witel || '-'}</div>
                <div class="col-2 py-2">${data.port || '-'}</div>
                <div class="col-3 py-2">${data.site_id_location || '-'}</div>
                <div class="col-3 py-2 text-truncate">${data.kendala || '-'}</div>
            `;
            
            tableBody.appendChild(row);
        });
        
        // Attach click handlers to rows
        attachWitelRowHandlers();
    }
    
    // Function untuk menangani klik pada baris tabel
    function attachWitelRowHandlers() {
        document.querySelectorAll('.witel-table-row').forEach(row => {
            row.addEventListener('click', function() {
                // Get witel from this row
                const witelCell = this.querySelector('.col-3:nth-child(2)');
                if (witelCell) {
                    const witel = witelCell.textContent.trim();
                    
                    // Toggle filter
                    if (globalFilterState.witel === witel) {
                        globalFilterState.witel = null;
                        document.querySelectorAll('.witel-table-row').forEach(r => r.style.backgroundColor = '');
                    } else {
                        globalFilterState.witel = witel;
                        document.querySelectorAll('.witel-table-row').forEach(r => r.style.backgroundColor = '');
                        this.style.backgroundColor = '#f0f0f0';
                    }
                    
                    // Apply all filters
                    applyAllFilters();
                }
            });
        });
    }
    
    // Helpers for loading and error states
    function showLoadingOverlay() {
        const existingOverlay = document.getElementById('loading-overlay');
        if (existingOverlay) {
            return;
        }
        
        const loadingIndicator = document.createElement('div');
        loadingIndicator.className = 'loading-overlay';
        loadingIndicator.id = 'loading-overlay';
        loadingIndicator.innerHTML = `
            <div class="spinner-border text-light" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        `;
        document.body.appendChild(loadingIndicator);
    }

    function hideLoadingOverlay() {
        const loadingIndicator = document.getElementById('loading-overlay');
        if (loadingIndicator) {
            loadingIndicator.remove();
        }
    }

    function showErrorNotification(message) {
        const notification = document.createElement('div');
        notification.className = 'alert alert-danger alert-dismissible fade show';
        notification.style.position = 'fixed';
        notification.style.top = '10px';
        notification.style.right = '10px';
        notification.style.zIndex = '1050';
        notification.style.maxWidth = '350px';
        
        notification.innerHTML = `
            <strong>Error:</strong> ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        document.body.appendChild(notification);
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 150);
        }, 5000);
    }
    
    // Fungsi untuk menampilkan notifikasi filter aktif
    function showFilterNotification(filter) {
        // Hapus notifikasi sebelumnya jika ada
        const existingNotification = document.getElementById('filter-notification');
        if (existingNotification) {
            existingNotification.remove();
        }
        
        if (filter !== 'ALL') {
            const notification = document.createElement('div');
            notification.id = 'filter-notification';
            notification.className = 'alert alert-info alert-dismissible fade show';
            notification.style.position = 'fixed';
            notification.style.top = '10px';
            notification.style.right = '10px';
            notification.style.zIndex = '1050';
            notification.style.maxWidth = '350px';
            
            notification.innerHTML = `
                <strong>Filter Aktif:</strong> Menampilkan data OLT ${filter} XGSPON saja
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
            
            document.body.appendChild(notification);
            
            // Otomatis hilangkan notifikasi setelah 5 detik
            setTimeout(() => {
                if (notification.classList) {
                    notification.classList.remove('show');
                    setTimeout(() => {
                        if (notification.parentNode) {
                            notification.remove();
                        }
                    }, 150);
                }
            }, 5000);
            
            // Tambahkan event listener untuk tombol close
            const closeButton = notification.querySelector('.btn-close');
            if (closeButton) {
                closeButton.addEventListener('click', function() {
                    notification.remove();
                });
            }
        }
    }
    
    // Handle day click to show events (kalender)
    const days = document.querySelectorAll('.day[data-has-events="true"]');
    days.forEach(day => {
        day.addEventListener('click', function() {
            const date = this.dataset.date;
            fetchEvents(date);
        });
    });
    
    // Also make today clickable even if no events
    const today = document.querySelector('.day.today');
    if (today) {
        today.addEventListener('click', function() {
            const date = this.dataset.date;
            fetchEvents(date);
        });
    }
    
    // Function to fetch events for a specific date
    function fetchEvents(date) {
        fetch('{{ route('get-date-events') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({ date: date })
        })
        .then(response => response.json())
        .then(data => {
            showEventModal(data);
        })
        .catch(error => {
            console.error('Error fetching events:', error);
        });
    }
    
    // Function to show the event modal
    function showEventModal(data) {
        const eventContainer = document.getElementById('eventContainer');
        eventContainer.innerHTML = '';
        
        const date = new Date(data.date);
        const formattedDate = date.toLocaleDateString('en-US', { 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        });
        
        // TOC events
        if (data.events.toc && data.events.toc.length > 0) {
            data.events.toc.forEach(event => {
                const eventCard = createEventCard('TOC', formattedDate, event, 'toc');
                eventContainer.appendChild(eventCard);
            });
        }
        
        // Plan OA events
        if (data.events.plan_oa && data.events.plan_oa.length > 0) {
            data.events.plan_oa.forEach(event => {
                const eventCard = createEventCard('Plan OA', formattedDate, event, 'plan-oa');
                eventContainer.appendChild(eventCard);
            });
        }
        
        // If no events, show a message
        if (eventContainer.innerHTML === '') {
            eventContainer.innerHTML = `
                <div class="p-4 text-center">
                    <h5>No events for ${formattedDate}</h5>
                </div>
            `;
        }
        
        // Show the modal
        const eventModal = new bootstrap.Modal(document.getElementById('eventModal'));
        eventModal.show();
    }
    
    // Function to create event card for date modal
    function createEventCard(title, date, event, type) {
        const div = document.createElement('div');
        div.className = `event-card ${type}`;
        
        div.innerHTML = `
            <div class="event-card-header">
                <h5 class="m-0"><i class="far fa-calendar-check me-2"></i>${title}</h5>
                <div>${date}</div>
            </div>
            <div class="event-card-content">
                <div class="event-meta">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Site ID: ${event.site_id_location}</span>
                </div>
                <div class="event-meta">
                    <i class="fas fa-building"></i>
                    <span>Witel: ${event.witel}</span>
                </div>
            </div>
        `;
        
        div.addEventListener('click', function() {
            window.location.href = '/site/' + event.id;
        });
        
        return div;
    }
    
    // Handle events modal
    const eventsModal = document.getElementById('eventsModal');
    eventsModal.addEventListener('show.bs.modal', function (event) {
        loadEvents('all', 'all');
    });
    
    // Events Tab Click Handling
    const eventTabs = document.querySelectorAll('#events-tabs .nav-link');
    eventTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const type = this.dataset.filter;
            const period = this.dataset.period;
            loadEvents(type, period);
        });
    });
    
    // Events Search
    const searchInput = document.getElementById('events-search-input');
    let searchTimeout;
    
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            const activeTab = document.querySelector('#events-tabs .nav-link.active');
            const type = activeTab.dataset.filter;
            const period = activeTab.dataset.period;
            loadEvents(type, period, this.value);
        }, 500);
    });
    
    // Function to load events
    function loadEvents(type, period, search = '') {
        const eventsListContainer = document.getElementById('events-list-container');
        eventsListContainer.innerHTML = '<div class="text-center py-4"><div class="spinner-border text-primary" role="status"></div><p class="mt-2">Loading events...</p></div>';
        
        fetch('{{ route('search-events') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({ 
                type: type,
                period: period,
                query: search,
                filter: window.currentFilter // Include current filter if active
            })
        })
        .then(response => response.json())
        .then(data => {
            displayEvents(data, eventsListContainer);
        })
        .catch(error => {
            console.error('Error loading events:', error);
            eventsListContainer.innerHTML = '<div class="alert alert-danger">Error loading events. Please try again.</div>';
        });
    }
    
    // Function to display events in the modal
    function displayEvents(data, container) {
        container.innerHTML = '';
        
        let hasEvents = false;
        
        // Display TOC events
        if (data.toc && data.toc.length > 0) {
            hasEvents = true;
            data.toc.forEach(event => {
                const eventDate = new Date(event.toc);
                const formattedDate = eventDate.toISOString().split('T')[0];
                const card = createEventsListCard('TOC', formattedDate, event, 'toc');
                container.appendChild(card);
            });
        }
        
        // Display Plan OA events
        if (data.plan_oa && data.plan_oa.length > 0) {
            hasEvents = true;
            data.plan_oa.forEach(event => {
                const eventDate = new Date(event.tanggal_plan_oa);
                const formattedDate = eventDate.toISOString().split('T')[0];
                const card = createEventsListCard('Plan OA', formattedDate, event, 'plan-oa');
                container.appendChild(card);
            });
        }
        
        if (!hasEvents) {
            container.innerHTML = '<div class="alert alert-info">No events found.</div>';
        }
    }
    
    // Function to create event card for events list
    function createEventsListCard(title, date, event, type) {
        const div = document.createElement('div');
        div.className = `events-list-card ${type}`;
        
        div.innerHTML = `
            <div class="events-list-header">
                <h5 class="m-0">${title}</h5>
                <div>${date}</div>
            </div>
            <div class="events-list-content">
                <div class="event-site-info">
                    <i class="fas fa-table-cells me-2"></i>
                    <span>Site ID: ${event.site_id_location}</span>
                </div>
                <div class="event-witel-info">
                    <i class="fas fa-map-marker-alt me-2"></i>
                    <span>Witel: ${event.witel}</span>
                </div>
            </div>
        `;
        
        div.addEventListener('click', function() {
            window.location.href = '/site/' + event.id;
        });
        
        return div;
    }
    
    // Keyboard shortcuts for BIG/MINI toggle
    document.addEventListener('keydown', function(event) {
        // Alt+B for BIG toggle
        if (event.altKey && event.key === 'b') {
            document.getElementById('bigButton').click();
        }
        // Alt+M for MINI toggle
        if (event.altKey && event.key === 'm') {
            document.getElementById('miniButton').click();
        }
        // Alt+R for reset all filters
        if (event.altKey && event.key === 'r') {
            resetAllFilters();
        }
    });
    
    // Add debug mode toggle 
    // Press Alt+D to toggle debug panel visibility
    document.addEventListener('keydown', function(event) {
        if (event.altKey && event.key === 'd') {
            const debugPanel = document.getElementById('debugPanel');
            if (debugPanel) {
                debugPanel.classList.toggle('d-none');
            }
        }
    });
    
    // Log initialization complete
    console.log('Interactive Dashboard initialization complete');
});
</script>
@endsection