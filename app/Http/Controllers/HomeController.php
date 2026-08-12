<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lop;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');
        
        $today = Carbon::now();
        
        if ($month && $year) {
            $currentDate = Carbon::create($year, $month, 1);
        } else {
            $currentDate = Carbon::create($today->year, $today->month, 1);
        }
        
        $currentMonth = $currentDate->month;
        $currentYear = $currentDate->year;
        
        // Get the first day of the month and the total days in month
        $firstDay = Carbon::create($currentYear, $currentMonth, 1);
        $daysInMonth = $firstDay->daysInMonth;
        
        // Get the starting day of the week (0 for Sunday, 1 for Monday, etc.)
        $startingDay = $firstDay->dayOfWeek;
        
        // Calculate previous and next months
        $prevMonth = (clone $firstDay)->subMonth();
        $nextMonth = (clone $firstDay)->addMonth();
        
        // Get event data for this month
        $tocEvents = Lop::whereYear('toc', $currentYear)
            ->whereMonth('toc', $currentMonth)
            ->get(['id', 'toc', 'site_id_location', 'witel']);
            
        $planOAEvents = Lop::whereYear('tanggal_plan_oa', $currentYear)
            ->whereMonth('tanggal_plan_oa', $currentMonth)
            ->get(['id', 'tanggal_plan_oa', 'site_id_location', 'witel']);
            
        // Format the events for the calendar
        $events = [];
        
        foreach ($tocEvents as $event) {
            $day = Carbon::parse($event->toc)->day;
            if (!isset($events[$day])) {
                $events[$day] = [];
            }
            $events[$day][] = [
                'type' => 'toc',
                'id' => $event->id,
                'date' => Carbon::parse($event->toc)->format('Y-m-d'),
                'site_id' => $event->site_id_location,
                'witel' => $event->witel
            ];
        }
        
        foreach ($planOAEvents as $event) {
            $day = Carbon::parse($event->tanggal_plan_oa)->day;
            if (!isset($events[$day])) {
                $events[$day] = [];
            }
            $events[$day][] = [
                'type' => 'plan_oa',
                'id' => $event->id,
                'date' => Carbon::parse($event->tanggal_plan_oa)->format('Y-m-d'),
                'site_id' => $event->site_id_location,
                'witel' => $event->witel
            ];
        }
        
        $calendarData = [
            'year' => $currentYear,
            'month' => $currentMonth,
            'monthName' => $currentDate->format('F'),
            'daysInMonth' => $daysInMonth,
            'startingDay' => $startingDay,
            'today' => ($currentMonth == $today->month && $currentYear == $today->year) ? $today->day : null,
            'events' => $events,
            'prevMonth' => [
                'month' => $prevMonth->month,
                'year' => $prevMonth->year,
                'name' => $prevMonth->format('F Y')
            ],
            'nextMonth' => [
                'month' => $nextMonth->month,
                'year' => $nextMonth->year,
                'name' => $nextMonth->format('F Y')
            ]
        ];
        
        // Get upcoming events for the event modal
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();
        
        // TOC Events
        $upcomingTocEvents = Lop::where('toc', '>=', now())
            ->orderBy('toc')
            ->limit(20)
            ->get(['id', 'toc', 'site_id_location', 'witel']);
            
        $tocThisWeek = Lop::whereBetween('toc', [$startOfWeek, $endOfWeek])
            ->orderBy('toc')
            ->get(['id', 'toc', 'site_id_location', 'witel']);
            
        $tocThisMonth = Lop::whereBetween('toc', [$startOfMonth, $endOfMonth])
            ->orderBy('toc')
            ->get(['id', 'toc', 'site_id_location', 'witel']);
            
        // Plan OA Events
        $upcomingPlanOAEvents = Lop::where('tanggal_plan_oa', '>=', now())
            ->orderBy('tanggal_plan_oa')
            ->limit(20)
            ->get(['id', 'tanggal_plan_oa', 'site_id_location', 'witel']);
            
        $planOAThisWeek = Lop::whereBetween('tanggal_plan_oa', [$startOfWeek, $endOfWeek])
            ->orderBy('tanggal_plan_oa')
            ->get(['id', 'tanggal_plan_oa', 'site_id_location', 'witel']);
            
        $planOAThisMonth = Lop::whereBetween('tanggal_plan_oa', [$startOfMonth, $endOfMonth])
            ->orderBy('tanggal_plan_oa')
            ->get(['id', 'tanggal_plan_oa', 'site_id_location', 'witel']);
        
        $upcomingEvents = [
            'toc' => $upcomingTocEvents,
            'plan_oa' => $upcomingPlanOAEvents,
            'this_week' => [
                'toc' => $tocThisWeek,
                'plan_oa' => $planOAThisWeek
            ],
            'this_month' => [
                'toc' => $tocThisMonth,
                'plan_oa' => $planOAThisMonth
            ]
        ];
        
        return view('home', compact('calendarData', 'upcomingEvents'));
    }
    
    /**
     * Get event details for a specific date.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDateEvents(Request $request)
    {
        $date = $request->input('date');
        $carbonDate = Carbon::parse($date);
        
        $tocEvents = Lop::whereDate('toc', $date)
            ->get(['id', 'toc', 'site_id_location', 'witel', 'status_proyek']);
            
        $planOAEvents = Lop::whereDate('tanggal_plan_oa', $date)
            ->get(['id', 'tanggal_plan_oa', 'site_id_location', 'witel', 'status_proyek']);
            
        $events = [
            'toc' => $tocEvents,
            'plan_oa' => $planOAEvents
        ];
        
        return response()->json([
            'events' => $events,
            'date' => $carbonDate->format('Y-m-d')
        ]);
    }
    
    /**
     * Search events.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchEvents(Request $request)
    {
        $query = $request->input('query');
        $type = $request->input('type', 'all');
        $period = $request->input('period', 'all');
        
        $tocQuery = Lop::query();
        $planOAQuery = Lop::query();
        
        // Apply search query if provided
        if ($query) {
            $tocQuery->where(function($q) use ($query) {
                $q->where('site_id_location', 'like', "%{$query}%")
                  ->orWhere('witel', 'like', "%{$query}%");
            });
            
            $planOAQuery->where(function($q) use ($query) {
                $q->where('site_id_location', 'like', "%{$query}%")
                  ->orWhere('witel', 'like', "%{$query}%");
            });
        }
        
        // Apply period filter
        if ($period === 'this_week') {
            $startOfWeek = now()->startOfWeek();
            $endOfWeek = now()->endOfWeek();
            
            $tocQuery->whereBetween('toc', [$startOfWeek, $endOfWeek]);
            $planOAQuery->whereBetween('tanggal_plan_oa', [$startOfWeek, $endOfWeek]);
        } elseif ($period === 'this_month') {
            $startOfMonth = now()->startOfMonth();
            $endOfMonth = now()->endOfMonth();
            
            $tocQuery->whereBetween('toc', [$startOfMonth, $endOfMonth]);
            $planOAQuery->whereBetween('tanggal_plan_oa', [$startOfMonth, $endOfMonth]);
        } else {
            // Default to upcoming events
            $tocQuery->where('toc', '>=', now());
            $planOAQuery->where('tanggal_plan_oa', '>=', now());
        }
        
        // Get results based on type
        $results = [];
        
        if ($type === 'all' || $type === 'toc') {
            $results['toc'] = $tocQuery->orderBy('toc')->limit(20)
                ->get(['id', 'toc', 'site_id_location', 'witel']);
        }
        
        if ($type === 'all' || $type === 'plan_oa') {
            $results['plan_oa'] = $planOAQuery->orderBy('tanggal_plan_oa')->limit(20)
                ->get(['id', 'tanggal_plan_oa', 'site_id_location', 'witel']);
        }
        
        return response()->json($results);
    }
}