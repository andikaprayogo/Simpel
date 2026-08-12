<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Witel;
use App\Models\Lop;

class WitelController extends Controller
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
     * Display the witel search page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        $witels = Witel::when($query, function ($q) use ($query) {
            return $q->where('name', 'like', '%' . $query . '%')
                    ->orWhere('address', 'like', '%' . $query . '%');
        })->get();
        
        $totalWitels = Witel::count();
        
        return view('witel.search', compact('witels', 'query', 'totalWitels'));
    }
    
    /**
     * Display the witel detail page with sites.
     *
     * @param  int  $id
     * @param  Request  $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show($id, Request $request)
    {
        $witel = Witel::findOrFail($id);
        
        $search = $request->input('search');
        
        // Get all LOPs related to this Witel with optional search
        $lops = Lop::where('witel', $witel->name)
            ->when($search, function ($query) use ($search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('site_id_location', 'like', '%' . $search . '%')
                      ->orWhere('status_proyek', 'like', '%' . $search . '%');
                });
            })
            ->latest()
            ->get();
        
        $totalSites = Lop::where('witel', $witel->name)->count();
        
        return view('witel.show', compact('witel', 'lops', 'totalSites', 'search'));
    }
    
    /**
     * Display the site detail page.
     *
     * @param  int  $lopId
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function siteDetail($lopId)
    {
        $lop = Lop::findOrFail($lopId);
        $witel = Witel::where('name', $lop->witel)->first();
        
        return view('witel.site-detail', compact('lop', 'witel'));
    }
}