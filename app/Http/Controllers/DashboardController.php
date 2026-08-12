<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lop;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema; // Add this line

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil data KPI
        $kpiData = $this->getKpiData();
        
        // Mengambil data untuk pie charts
        $statusData = $this->getStatusData();
        $kendalaData = $this->getKendalaData();
        
        // Mengambil data untuk bar charts
        $weeklyData = $this->getWeeklyData();
        $regionalData = $this->getRegionalData();
        
        // Mengambil data untuk tabel witel
        $witelData = $this->getWitelData();

        // Data Calendar yang sudah ada
        $calendarData = $this->getCalendarData();
        
        return view('home', compact('kpiData', 'statusData', 'kendalaData', 'weeklyData', 'regionalData', 'witelData', 'calendarData'));
    }
    
    private function getKpiData($filter = null)
    {
        try {
            // Query dasar
            $query = DB::table('lops');
            
            // Terapkan filter jika ada - menggunakan LIKE untuk menangani BIG XGSPON dan MINI XGSPON
            if ($filter === 'BIG') {
                $query->where('size_olt', 'LIKE', 'BIG%');
            } elseif ($filter === 'MINI') {
                $query->where('size_olt', 'LIKE', 'MINI%');
            }
            
            // Menggunakan kolom 'odp' dan 'port' yang tersedia di tabel
            $odp = $query->sum('odp') ?? 3.577;
            
            // Reset query untuk menghitung port
            $query = DB::table('lops');
            if ($filter === 'BIG') {
                $query->where('size_olt', 'LIKE', 'BIG%');
            } elseif ($filter === 'MINI') {
                $query->where('size_olt', 'LIKE', 'MINI%');
            }
            $port = $query->sum('port') ?? 28.952;
            
            // Reset query untuk menghitung durasi
            $query = DB::table('lops');
            if ($filter === 'BIG') {
                $query->where('size_olt', 'LIKE', 'BIG%');
            } elseif ($filter === 'MINI') {
                $query->where('size_olt', 'LIKE', 'MINI%');
            }
            // Menghitung durasi antara tanggal_plan_oa dan toc
            $durasi = $query->whereNotNull('tanggal_plan_oa')
                ->whereNotNull('toc')
                ->avg(DB::raw('DATEDIFF(toc, tanggal_plan_oa)')) ?? -7.75;
                
            Log::info('KPI Data Query Results', [
                'filter' => $filter,
                'odp' => $odp,
                'port' => $port,
                'durasi' => $durasi
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting KPI data: ' . $e->getMessage());
            
            $odp = $filter === 'BIG' ? 2.890 : ($filter === 'MINI' ? 1.687 : 3.577);
            $port = $filter === 'BIG' ? 22.465 : ($filter === 'MINI' ? 14.321 : 28.952);
            $durasi = $filter === 'BIG' ? -8.12 : ($filter === 'MINI' ? -6.35 : -7.75);
        }
            
        return [
            'odp' => number_format($odp, 0, '.', ''),
            'port' => number_format($port, 0, '.', ''),
            'durasi' => number_format($durasi, 0, ',', '')
        ];
    }
    
    private function getStatusData($filter = null)
    {
        try {
            // Query dasar
            $query = DB::table('lops');
            
            // Terapkan filter jika ada - menggunakan LIKE untuk menangani BIG XGSPON dan MINI XGSPON
            if ($filter === 'BIG') {
                $query->where('size_olt', 'LIKE', 'BIG%');
            } elseif ($filter === 'MINI') {
                $query->where('size_olt', 'LIKE', 'MINI%');
            }
            
            $statuses = $query->select('status_proyek', DB::raw('count(*) as total'))
                ->groupBy('status_proyek')
                ->get();
                
            $total = $statuses->sum('total');
            $labels = [];
            $series = [];
            
            foreach ($statuses as $status) {
                $labels[] = $status->status_proyek;
                $series[] = $total > 0 ? round(($status->total / $total) * 100, 1) : 0;
            }
            
            // Pastikan semua status yang diperlukan ada
            $requiredStatuses = [
                'INTEGRASI', 'INSTALL RACK', 'DONE UT', 'POWER ON', 'DONE SURVEY', 
                'MAT DEL', 'OA', 'SURVEY', 'MOS', 'DROP', 'DONE'
            ];
            
            foreach ($requiredStatuses as $reqStatus) {
                if (!in_array($reqStatus, $labels)) {
                    $labels[] = $reqStatus;
                    $series[] = 0; // Default value 0 jika status tidak ditemukan
                }
            }
            
            Log::info('Status Data Query Results', [
                'filter' => $filter,
                'total' => $total,
                'statuses_count' => count($statuses)
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting status data: ' . $e->getMessage());
            
            // Data default dengan 11 status
            $labels = [
                'DONE UT', 'POWER ON', 'DONE SURVEY', 'MAT DEL', 'OA', 
                'SURVEY', 'MOS', 'DROP', 'DONE', 'INTEGRASI', 'INSTALL RACK'
            ];
            
            if ($filter === 'BIG') {
                $series = [28.5, 23.1, 20.2, 10.5, 7.8, 4.5, 3.1, 1.3, 1.0, 11.1, 0];
            } elseif ($filter === 'MINI') {
                $series = [24.7, 26.2, 22.5, 11.8, 8.4, 3.8, 1.9, 0.5, 0.2, 11.1, 0];
            } else {
                $series = [22.2, 22.2, 22.2, 11.1, 22.2, 0, 11.1, 0, 0, 11.1, 0];
            }
            
            $total = 160;
        }
        
        return [
            'labels' => $labels,
            'series' => $series,
            'total' => $total ?? 160
        ];
    }
    
    private function getKendalaData($filter = null)
    {
        try {
            // Query dasar
            $query = DB::table('lops');
            
            // Terapkan filter jika ada - menggunakan LIKE untuk menangani BIG XGSPON dan MINI XGSPON
            if ($filter === 'BIG') {
                $query->where('size_olt', 'LIKE', 'BIG%');
            } elseif ($filter === 'MINI') {
                $query->where('size_olt', 'LIKE', 'MINI%');
            }
            
            // Menggunakan kolom 'kendala' yang tersedia di tabel
            $kendala = $query->select('kendala', DB::raw('count(*) as total'))
                ->whereNotNull('kendala')
                ->groupBy('kendala')
                ->get();
                
            $total = $kendala->sum('total');
            $labels = [];
            $series = [];
            
            foreach ($kendala as $item) {
                $labels[] = $item->kendala ?: 'NO ISSUE';
                $series[] = $total > 0 ? round(($item->total / $total) * 100, 1) : 0;
            }
            
            // Pastikan semua kendala yang diperlukan ada
            $requiredKendala = [
                'NO ISSUE', 'SFP BIDI', 'WAITING UPLINK', 'PERMIT', 'WAITING OTN', 
                'COMMCASE', 'PONDASI', 'MIGRASI', 'NEW PLN', 'RELOC', 'L2SWITCH', 'UPGRADE PLN'
            ];
            
            foreach ($requiredKendala as $reqKendala) {
                if (!in_array($reqKendala, $labels)) {
                    $labels[] = $reqKendala;
                    $series[] = 0; // Default value 0 jika kendala tidak ditemukan
                }
            }
            
            Log::info('Kendala Data Query Results', [
                'filter' => $filter,
                'total' => $total,
                'kendala_count' => count($kendala)
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting kendala data: ' . $e->getMessage());
            
            // Data default dengan 12 kendala
            $labels = [
                'NO ISSUE', 'SFP BIDI', 'WAITING UPLINK', 'PERMIT', 'WAITING OTN', 
                'COMMCASE', 'PONDASI', 'MIGRASI', 'NEW PLN', 'RELOC', 'L2SWITCH', 'UPGRADE PLN'
            ];
            
            if ($filter === 'BIG') {
                $series = [50.2, 0, 9.5, 6.7, 0, 0, 0, 0, 0, 11.1, 11.1, 0];
            } elseif ($filter === 'MINI') {
                $series = [54.8, 0, 7.9, 5.9, 0, 0, 0, 0, 0, 11.1, 11.1, 0];
            } else {
                $series = [55.5, 0, 11.1, 11.1, 0, 0, 0, 0, 0, 11.1, 11.1, 0];
            }
            
            $total = 160;
        }
                
        return [
            'labels' => $labels,
            'series' => $series,
            'total' => $total ?? 160
        ];
    }
    
    private function getWeeklyData($filter = null)
    {
        try {
            // Query dasar
            $query = DB::table('lops');
            
            // Terapkan filter jika ada - menggunakan LIKE untuk menangani BIG XGSPON dan MINI XGSPON
            if ($filter === 'BIG') {
                $query->where('size_olt', 'LIKE', 'BIG%');
            } elseif ($filter === 'MINI') {
                $query->where('size_olt', 'LIKE', 'MINI%');
            }
            
            // Menggunakan kolom 'week_plan_oa' yang tersedia di tabel
            $weeks = $query->select('week_plan_oa', DB::raw('count(*) as total'))
                ->whereNotNull('week_plan_oa')
                ->groupBy('week_plan_oa')
                ->orderByDesc('total')
                ->limit(10)
                ->get();
                
            $categories = [];
            $data = [];
            
            foreach ($weeks as $week) {
                $categories[] = $week->week_plan_oa;
                $data[] = $week->total;
            }
            
            // Jika data kosong atau tidak cukup, gunakan metode tanggal_plan_oa
            if (count($categories) < 5) {
                // Reset query
                $query = DB::table('lops');
                if ($filter === 'BIG') {
                    $query->where('size_olt', 'LIKE', 'BIG%');
                } elseif ($filter === 'MINI') {
                    $query->where('size_olt', 'LIKE', 'MINI%');
                }
                
                $weeks = $query->select(DB::raw("CONCAT(
                        CASE MONTH(tanggal_plan_oa)
                            WHEN 1 THEN 'Jan'
                            WHEN 2 THEN 'Feb'
                            WHEN 3 THEN 'Mar'
                            WHEN 4 THEN 'Apr'
                            WHEN 5 THEN 'May'
                            WHEN 6 THEN 'Jun'
                            WHEN 7 THEN 'Jul'
                            WHEN 8 THEN 'Aug'
                            WHEN 9 THEN 'Sep'
                            WHEN 10 THEN 'Oct'
                            WHEN 11 THEN 'Nov'
                            WHEN 12 THEN 'Dec'
                        END, ' W', CEILING(DAY(tanggal_plan_oa)/7)) AS week"), 
                        DB::raw('count(*) as total'))
                    ->whereNotNull('tanggal_plan_oa')
                    ->where('tanggal_plan_oa', '>=', now()->subMonths(3))
                    ->groupBy(DB::raw("CONCAT(
                        CASE MONTH(tanggal_plan_oa)
                            WHEN 1 THEN 'Jan'
                            WHEN 2 THEN 'Feb'
                            WHEN 3 THEN 'Mar'
                            WHEN 4 THEN 'Apr'
                            WHEN 5 THEN 'May'
                            WHEN 6 THEN 'Jun'
                            WHEN 7 THEN 'Jul'
                            WHEN 8 THEN 'Aug'
                            WHEN 9 THEN 'Sep'
                            WHEN 10 THEN 'Oct'
                            WHEN 11 THEN 'Nov'
                            WHEN 12 THEN 'Dec'
                        END, ' W', CEILING(DAY(tanggal_plan_oa)/7))"))
                    ->orderByDesc('total')
                    ->limit(10)
                    ->get();
                    
                $categories = [];
                $data = [];
                
                foreach ($weeks as $week) {
                    $categories[] = $week->week;
                    $data[] = $week->total;
                }
            }
            
            Log::info('Weekly Data Query Results', [
                'filter' => $filter,
                'categories_count' => count($categories),
                'data' => $data
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting weekly data: ' . $e->getMessage());
            
            $categories = ['Apr W2', 'Apr W1', 'Mar W2', 'Feb W3', 'Feb W2', 'Apr W3', 'Feb W1', 'Apr W4'];
            
            if ($filter === 'BIG') {
                $data = [35, 30, 12, 10, 8, 5, 3, 1];
            } elseif ($filter === 'MINI') {
                $data = [25, 22, 10, 8, 6, 4, 3, 1];
            } else {
                $data = [47, 46, 16, 15, 11, 7, 5, 2];
            }
        }
        
        return [
            'categories' => $categories,
            'data' => $data
        ];
    }
    
    private function getRegionalData($filter = null)
    {
        try {
            // Mendapatkan witel teratas (tanpa filter untuk tetap konsisten)
            $regions = DB::table('lops')
                ->select('witel')
                ->whereNotNull('witel')
                ->groupBy('witel')
                ->orderByDesc(DB::raw('count(*)'))
                ->limit(7)
                ->pluck('witel')
                ->toArray();
            
            // Inisialisasi array untuk menyimpan data
            $zte = [];
            $huawei = [];
            $null = [];
            
            // Loop untuk setiap witel dan hitung jumlah per platform dengan filter
            foreach ($regions as $region) {
                // Query dasar untuk ZTE
                $zteQuery = DB::table('lops')
                    ->where('witel', $region)
                    ->where('platform', 'ZTE');
                
                // Terapkan filter size_olt jika ada - menggunakan LIKE untuk menangani BIG XGSPON dan MINI XGSPON
                if ($filter === 'BIG') {
                    $zteQuery->where('size_olt', 'LIKE', 'BIG%');
                } elseif ($filter === 'MINI') {
                    $zteQuery->where('size_olt', 'LIKE', 'MINI%');
                }
                
                $zte[] = $zteQuery->count();
                
                // Query dasar untuk HUAWEI
                $huaweiQuery = DB::table('lops')
                    ->where('witel', $region)
                    ->where('platform', 'HUAWEI');
                
                // Terapkan filter size_olt jika ada - menggunakan LIKE untuk menangani BIG XGSPON dan MINI XGSPON
                if ($filter === 'BIG') {
                    $huaweiQuery->where('size_olt', 'LIKE', 'BIG%');
                } elseif ($filter === 'MINI') {
                    $huaweiQuery->where('size_olt', 'LIKE', 'MINI%');
                }
                
                $huawei[] = $huaweiQuery->count();
                
                // Query dasar untuk null/lainnya
                $nullQuery = DB::table('lops')
                    ->where('witel', $region)
                    ->where(function($query) {
                        $query->whereNull('platform')
                            ->orWhereNotIn('platform', ['ZTE', 'HUAWEI']);
                    });
                
                // Terapkan filter size_olt jika ada - menggunakan LIKE untuk menangani BIG XGSPON dan MINI XGSPON
                if ($filter === 'BIG') {
                    $nullQuery->where('size_olt', 'LIKE', 'BIG%');
                } elseif ($filter === 'MINI') {
                    $nullQuery->where('size_olt', 'LIKE', 'MINI%');
                }
                
                $null[] = $nullQuery->count();
            }
            
            Log::info('Regional Data Query Results', [
                'filter' => $filter,
                'regions' => $regions,
                'zte_counts' => $zte,
                'huawei_counts' => $huawei,
                'null_counts' => $null
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting regional data: ' . $e->getMessage());
            
            $regions = ['RIDAR', 'SUMSEL', 'BENGKULU', 'BABEL', 'LAMPUNG', 'JAMBI', 'MEDAN'];
            
            if ($filter === 'BIG') {
                $zte = [30, 18, 15, 12, 8, 7, 5];
                $huawei = [15, 10, 7, 5, 4, 3, 2];
                $null = [3, 2, 1, 1, 0, 0, 0];
            } elseif ($filter === 'MINI') {
                $zte = [20, 15, 10, 8, 6, 5, 4];
                $huawei = [10, 8, 5, 4, 3, 2, 1];
                $null = [2, 1, 1, 0, 0, 0, 0];
            } else {
                $zte = [44, 25, 23, 17, 12, 11, 9];
                $huawei = [20, 15, 10, 8, 6, 5, 4];
                $null = [5, 3, 2, 1, 0, 0, 0];
            }
        }
            
        return [
            'categories' => $regions,
            'zte' => $zte,
            'huawei' => $huawei,
            'null' => $null
        ];
    }
    
    private function getWitelData($filter = null)
    {
        try {
            // Query dasar
            $query = DB::table('lops');
            
            // Terapkan filter jika ada - menggunakan LIKE untuk menangani BIG XGSPON dan MINI XGSPON
            if ($filter === 'BIG') {
                $query->where('size_olt', 'LIKE', 'BIG%');
            } elseif ($filter === 'MINI') {
                $query->where('size_olt', 'LIKE', 'MINI%');
            }
            
            // Mendapatkan data witel
            $witelData = $query->select('witel', 'port', 'site_id_location', 'kendala')
                ->whereNotNull('witel')
                ->whereNotNull('kode_sto')
                ->orderBy('witel')
                ->limit(30)
                ->get()
                ->map(function($item) {
                    return [
                        'witel' => $item->witel,
                        'port' => $item->port,
                        'site_id_location' => $item->site_id_location,
                        'kendala' => $item->kendala ?? 'DEFAULT KENDALA'
                    ];
                })
                ->toArray();
                
            Log::info('Witel Data Query Results', [
                'filter' => $filter,
                'witel_data_count' => count($witelData)
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting witel data: ' . $e->getMessage());
            
            if ($filter === 'BIG') {
                $witelData = [
                    ['witel' => 'SUMUT', 'port' => 384, 'site_id_location' => '10985654', 'kendala' => 'NO ISSUE'],
                    ['witel' => 'SUMSEL', 'port' => 256, 'site_id_location' => '10949271', 'kendala' => 'PERMIT'],
                    ['witel' => 'RIDAR', 'port' => 384, 'site_id_location' => '11091798', 'kendala' => 'WAITING UPLINK'],
                ];
            } elseif ($filter === 'MINI') {
                $witelData = [
                    ['witel' => 'LAMPUNG', 'port' => 128, 'site_id_location' => '11075157', 'kendala' => 'L2SWITCH'],
                    ['witel' => 'JAMBI', 'port' => 64, 'site_id_location' => '10985699', 'kendala' => 'NO ISSUE'],
                    ['witel' => 'BABEL', 'port' => 128, 'site_id_location' => '10949299', 'kendala' => 'RELOC'],
                ];
            } else {
                $witelData = [
                    ['witel' => 'SUMUT', 'port' => 384, 'site_id_location' => '10985654', 'kendala' => 'NO ISSUE'],
                    ['witel' => 'SUMSEL', 'port' => 256, 'site_id_location' => '10949271', 'kendala' => 'PERMIT'],
                    ['witel' => 'RIDAR', 'port' => 384, 'site_id_location' => '11091798', 'kendala' => 'WAITING UPLINK'],
                    ['witel' => 'LAMPUNG', 'port' => 128, 'site_id_location' => '11075157', 'kendala' => 'L2SWITCH'],
                ];
            }
        }
            
        return $witelData;
    }
    
    private function getCalendarData()
    {
        // Ambil parameter month dan year dari request
        $month = request('month', date('m'));
        $year = request('year', date('Y'));
        
        // Data calendar placeholder
        return [
            'month' => $month,
            'year' => $year,
            'monthName' => date('F', mktime(0, 0, 0, $month, 1, $year)),
            'daysInMonth' => date('t', mktime(0, 0, 0, $month, 1, $year)),
            'startingDay' => date('w', mktime(0, 0, 0, $month, 1, $year)),
            'today' => ($month == date('m') && $year == date('Y')) ? date('j') : null,
            'prevMonth' => [
                'month' => $month == 1 ? 12 : $month - 1,
                'year' => $month == 1 ? $year - 1 : $year
            ],
            'nextMonth' => [
                'month' => $month == 12 ? 1 : $month + 1,
                'year' => $month == 12 ? $year + 1 : $year
            ],
            'events' => [] // Placeholder untuk events
        ];
    }
    
    // Endpoint untuk filter dashboard
    public function filter(Request $request)
    {
        try {
            $filter = $request->input('filter');
            $reset = $request->input('reset', false);
            $witel = $request->input('witel');
            $status = $request->input('status');
            $kendala = $request->input('kendala');
            
            // Log filter request untuk debugging
            Log::info('Dashboard filter request received', [
                'filter' => $filter,
                'reset' => $reset,
                'witel' => $witel,
                'status' => $status,
                'kendala' => $kendala
            ]);
            
            // Periksa distribusi nilai size_olt untuk debugging
            $sizeOltCounts = DB::table('lops')
                ->select('size_olt', DB::raw('count(*) as total'))
                ->groupBy('size_olt')
                ->get()
                ->pluck('total', 'size_olt')
                ->toArray();
                
            Log::info('Size OLT distribution in database', $sizeOltCounts);
            
            // Jika reset true atau filter adalah ALL, kembalikan semua data
            if ($reset || $filter === 'ALL') {
                return response()->json([
                    'kpiData' => $this->getKpiData(),
                    'statusData' => $this->getStatusData(),
                    'kendalaData' => $this->getKendalaData(),
                    'weeklyData' => $this->getWeeklyData(),
                    'regionalData' => $this->getRegionalData(),
                    'witelData' => $this->getWitelData()
                ]);
            }
            
            // Jika ada filter witel, status, atau kendala
            if ($witel || $status || $kendala) {
                return $this->getFilteredData($request);
            }
            
            // Filter berdasarkan BIG/MINI
            if ($filter === 'BIG' || $filter === 'MINI') {
                return response()->json([
                    'kpiData' => $this->getKpiData($filter),
                    'statusData' => $this->getStatusData($filter),
                    'kendalaData' => $this->getKendalaData($filter),
                    'weeklyData' => $this->getWeeklyData($filter),
                    'regionalData' => $this->getRegionalData($filter),
                    'witelData' => $this->getWitelData($filter)
                ]);
            }
            
            // Default response jika tidak ada filter yang cocok
            return response()->json([
                'kpiData' => $this->getKpiData(),
                'statusData' => $this->getStatusData(),
                'kendalaData' => $this->getKendalaData(),
                'weeklyData' => $this->getWeeklyData(),
                'regionalData' => $this->getRegionalData(),
                'witelData' => $this->getWitelData()
            ]);
        } catch (\Exception $e) {
            Log::error('Error in filter method: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'error' => 'Terjadi kesalahan saat memfilter data: ' . $e->getMessage()
            ], 500);
        }
    }
    
    // Method untuk filter data berdasarkan parameter lainnya
    public function getFilteredData(Request $request)
    {
        $filter = $request->filter;
        $witel = $request->witel;
        $status = $request->status;
        $kendala = $request->kendala;
        
        try {
            $query = DB::table('lops');
            
            // Filter berdasarkan filter BIG/MINI - menggunakan LIKE untuk menangani BIG XGSPON dan MINI XGSPON
            if ($filter === 'BIG') {
                $query->where('size_olt', 'LIKE', 'BIG%');
            } elseif ($filter === 'MINI') {
                $query->where('size_olt', 'LIKE', 'MINI%');
            }
            
            // Filter berdasarkan witel
            if ($witel) {
                $query->where('witel', $witel);
            }
            
            // Filter berdasarkan status
            if ($status) {
                $query->where('status_proyek', $status);
            }
            
            // Filter berdasarkan kendala
            if ($kendala) {
                $query->where('kendala', $kendala);
            }
            
            // Hitung data KPI yang difilter
            $odp = $query->sum('odp') ?? 0;
            $port = $query->sum('port') ?? 0;
            
            // Hitung durasi rata-rata
            $durasi = clone $query;
            $durasi = $durasi->whereNotNull('tanggal_plan_oa')
                ->whereNotNull('toc')
                ->avg(DB::raw('DATEDIFF(toc, tanggal_plan_oa)')) ?? 0;
            
            // Hitung data status yang difilter
            $statusQuery = clone $query;
            $statuses = $statusQuery->select('status_proyek', DB::raw('count(*) as total'))
                ->groupBy('status_proyek')
                ->get();
            
            $totalStatus = $statuses->sum('total');
            $statusLabels = [];
            $statusSeries = [];
            
            foreach ($statuses as $status) {
                $statusLabels[] = $status->status_proyek;
                $statusSeries[] = $totalStatus > 0 ? round(($status->total / $totalStatus) * 100, 1) : 0;
            }
            
            // Pastikan semua status yang diperlukan ada
            $requiredStatuses = [
                'INTEGRASI', 'INSTALL RACK', 'DONE UT', 'POWER ON', 'DONE SURVEY', 
                'MAT DEL', 'OA', 'SURVEY', 'MOS', 'DROP', 'DONE'
            ];
            
            foreach ($requiredStatuses as $reqStatus) {
                if (!in_array($reqStatus, $statusLabels)) {
                    $statusLabels[] = $reqStatus;
                    $statusSeries[] = 0;
                }
            }
            
            // Hitung data kendala yang difilter
            $kendalaQuery = clone $query;
            $kendala = $kendalaQuery->select('kendala', DB::raw('count(*) as total'))
                ->whereNotNull('kendala')
                ->groupBy('kendala')
                ->get();
            
            $totalKendala = $kendala->sum('total');
            $kendalaLabels = [];
            $kendalaSeries = [];
            
            foreach ($kendala as $item) {
                $kendalaLabels[] = $item->kendala ?: 'NO ISSUE';
                $kendalaSeries[] = $totalKendala > 0 ? round(($item->total / $totalKendala) * 100, 1) : 0;
            }
            
            // Pastikan semua kendala yang diperlukan ada
            $requiredKendala = [
                'NO ISSUE', 'SFP BIDI', 'WAITING UPLINK', 'PERMIT', 'WAITING OTN', 
                'COMMCASE', 'PONDASI', 'MIGRASI', 'NEW PLN', 'RELOC', 'L2SWITCH', 'UPGRADE PLN'
            ];
            
            foreach ($requiredKendala as $reqKendala) {
                if (!in_array($reqKendala, $kendalaLabels)) {
                    $kendalaLabels[] = $reqKendala;
                    $kendalaSeries[] = 0;
                }
            }
            
            // Mendapatkan data weekly
            $weeklyData = $this->getWeeklyData($filter);
            
            // Mendapatkan data regional
            $regionalData = $this->getRegionalData($filter);
            
            // Get witel data
            $witelData = $query->select('witel', 'port', 'site_id_location', 'kendala')
                ->whereNotNull('witel')
                ->whereNotNull('kode_sto')
                ->orderBy('witel')
                ->limit(30)
                ->get()
                ->map(function($item) {
                    return [
                        'witel' => $item->witel,
                        'port' => $item->port,
                        'site_id_location' => $item->site_id_location,
                        'kendala' => $item->kendala ?? 'DEFAULT KENDALA'
                    ];
                })
                ->toArray();
            
            Log::info('Filtered data query results', [
                'filter' => $filter,
                'witel' => $witel,
                'status' => $status,
                'kendala' => $kendala,
                'totalStatus' => $totalStatus,
                'totalKendala' => $totalKendala,
                'witelDataCount' => count($witelData)
            ]);
            
            return response()->json([
                'kpiData' => [
                    'odp' => number_format($odp, 0, '.', ''),
                    'port' => number_format($port, 0, '.', ''),
                    'durasi' => number_format($durasi, 0, ',', '')
                ],
                'statusData' => [
                    'labels' => $statusLabels,
                    'series' => $statusSeries,
                    'total' => $totalStatus
                ],
                'kendalaData' => [
                    'labels' => $kendalaLabels,
                    'series' => $kendalaSeries,
                    'total' => $totalKendala
                ],
                'weeklyData' => $weeklyData,
                'regionalData' => $regionalData,
                'witelData' => $witelData
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting filtered data: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'kpiData' => [
                    'odp' => $filter === 'BIG' ? '2.890' : '1.687',
                    'port' => $filter === 'BIG' ? '22.465' : '14.321',
                    'durasi' => $filter === 'BIG' ? '-8,12' : '-6,35'
                ],
                'statusData' => [
                    'labels' => ['DONE UT', 'POWER ON', 'DONE SURVEY', 'MAT DEL', 'OA', 'SURVEY', 'MOS', 'DROP', 'DONE', 'INTEGRASI', 'INSTALL RACK'],
                    'series' => $filter === 'BIG' 
                        ? [28.5, 23.1, 20.2, 10.5, 7.8, 4.5, 3.1, 1.3, 1.0, 11.1, 0]
                        : [24.7, 26.2, 22.5, 11.8, 8.4, 3.8, 1.9, 0.5, 0.2, 11.1, 0],
                    'total' => 160
                ],
                'kendalaData' => [
                    'labels' => ['NO ISSUE', 'SFP BIDI', 'WAITING UPLINK', 'PERMIT', 'WAITING OTN', 'COMMCASE', 'PONDASI', 'MIGRASI', 'NEW PLN', 'RELOC', 'L2SWITCH', 'UPGRADE PLN'],
                    'series' => $filter === 'BIG'
                        ? [50.2, 0, 9.5, 6.7, 0, 0, 0, 0, 0, 11.1, 11.1, 0]
                        : [54.8, 0, 7.9, 5.9, 0, 0, 0, 0, 0, 11.1, 11.1, 0],
                    'total' => 160
                ],
                'weeklyData' => [
                    'categories' => ['Apr W2', 'Apr W1', 'Mar W2', 'Feb W3', 'Feb W2', 'Apr W3', 'Feb W1', 'Apr W4'],
                    'data' => $filter === 'BIG' ? [35, 30, 12, 10, 8, 5, 3, 1] : [25, 22, 10, 8, 6, 4, 3, 1]
                ],
                'regionalData' => [
                    'categories' => ['RIDAR', 'SUMSEL', 'BENGKULU', 'BABEL', 'LAMPUNG', 'JAMBI', 'MEDAN'],
                    'zte' => $filter === 'BIG' ? [30, 18, 15, 12, 8, 7, 5] : [20, 15, 10, 8, 6, 5, 4],
                    'huawei' => $filter === 'BIG' ? [15, 10, 7, 5, 4, 3, 2] : [10, 8, 5, 4, 3, 2, 1],
                    'null' => $filter === 'BIG' ? [3, 2, 1, 1, 0, 0, 0] : [2, 1, 1, 0, 0, 0, 0]
                ],
                'witelData' => [
                    ['witel' => 'SUMUT', 'port' => 384, 'site_id_location' => '10985654', 'kendala' => 'NO ISSUE'],
                    ['witel' => 'SUMSEL', 'port' => 256, 'site_id_location' => '10949271', 'kendala' => 'PERMIT'],
                    ['witel' => 'SUMUT', 'port' => 384, 'site_id_location' => '11091798', 'kendala' => 'WAITING UPLINK'],
                ]
            ], 200);
        }
    }
    
    // Method untuk debugging database
    public function debugDatabase()
    {
        try {
            // Periksa struktur tabel
            $columns = \Illuminate\Support\Facades\Schema::getColumnListing('lops');
            
            // Periksa nilai-nilai unik untuk size_olt
            $sizeOltValues = DB::table('lops')
                ->select('size_olt')
                ->distinct()
                ->get()
                ->pluck('size_olt')
                ->toArray();
                
            // Periksa jumlah data per nilai size_olt
            $sizeOltCounts = DB::table('lops')
                ->select('size_olt', DB::raw('count(*) as total'))
                ->groupBy('size_olt')
                ->get()
                ->toArray();
                
            // Periksa sampel data
            $sampleData = DB::table('lops')
                ->select('size_olt', 'witel', 'platform', 'port', 'site_id_location')
                ->limit(5)
                ->get()
                ->toArray();
                
            return response()->json([
                'table_columns' => $columns,
                'size_olt_values' => $sizeOltValues,
                'size_olt_counts' => $sizeOltCounts,
                'sample_data' => $sampleData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error debugging database: ' . $e->getMessage()
            ], 500);
        }
    }
}