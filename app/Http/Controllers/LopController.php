<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lop;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LopController extends Controller
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
     * Show the form for creating a new LOP.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $statuses = [
            'OA', 'MAT DEL', 'DONE', 'SURVEY', 'POWER ON', 
            'DROP', 'MOS', 'INTEGRASI', 'DONE SURVEY', 'DONE UT', 'INSTALL RACK'
        ];
        
        $witels = [
            'ACEH', 'BABEL', 'BENGKULU', 'JAMBI', 'LAMPUNG', 
            'RIDAR', 'RIKEP', 'SUMBAR', 'SUMSEL', 'SUMUT'
        ];
        
        $sizeOltOptions = [
            'BIG XGSPON', 'MINI XGSPON', 'INSERT CARD'
        ];
        
        $platformOptions = [
            'HUAWEI', 'ZTE'
        ];
        
        $typeOptions = [
            'C600', 'C620', 'MA5800-X17', 'MA5800-X2'
        ];
        
        $catuanAcOptions = [
            'EKSISTING STO', 'EKSISTING TSEL', 'PASCABAYAR', 'PRABAYAR (PULSA)'
        ];
        
        $siteProviderOptions = [
            'DMT', 'DMT - Bifurcation', 'DMT - Reseller', 'IBS', 'NO NEED SITAC', 
            'NOT READY', 'PROTELINDO', 'PT Centratama Menara Indonesia', 
            'PT Gihon Telekomunikasi Indonesia', 'PT Quattro International', 
            'PT Era Bangun Towerindo', 'PT Protelindo', 'READY', 'STO ROOM', 
            'STP', 'TBG', 'TELKOM', 'TELKOMSEL', 'TSEL'
        ];
        
        $kendalaOptions = [
            'COMMCASE', 'NEW PLN', 'NO ISSUE', 'PERMIT', 'PONDASI', 
            'RELOC', 'SFP BIDI', 'WAITING OTN', 'WAITING UPLINK', 
            'L2SWITCH', 'MIGRASI', 'UPGRADE PLN'
        ];
        
        return view('lop.add', compact(
            'statuses', 
            'witels', 
            'sizeOltOptions', 
            'platformOptions', 
            'typeOptions', 
            'catuanAcOptions',
            'siteProviderOptions',
            'kendalaOptions'
        ));
    }

    /**
     * Store a newly created LOP.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'status_proyek' => 'required',
            'witel' => 'required',
            'site_id_location' => 'required',
            'koordinat' => 'nullable',
            'kecamatan_lokasi_olt' => 'nullable',
            'size_olt' => 'nullable',
            'platform' => 'nullable',
            'type' => 'nullable',
            'hostname' => 'nullable',
            'jumlah_modul' => 'nullable|numeric',
            'catuan_ac' => 'nullable',
            'kode_sto' => 'nullable',
            'nama_sto_uplink' => 'nullable',
            'port_metro' => 'nullable',
            'sfp' => 'nullable',
            'odp' => 'nullable|numeric',
            'port' => 'nullable|numeric',
            'start_project' => 'nullable|date',
            'toc' => 'nullable|date',
            'tanggal_plan_oa' => 'nullable|date',
            'week_plan_oa' => 'nullable',
            'lop_downlink' => 'nullable',
            'kontrak_pengadaan' => 'nullable',
            'kode_ihld' => 'nullable',
            'site_provider' => 'nullable',
            'kendala' => 'nullable',
            'last_issue' => 'nullable',
        ]);
        
        // Calculate Week Plan OA if Tanggal Plan OA is provided
        if (!empty($request->tanggal_plan_oa)) {
            $date = Carbon::parse($request->tanggal_plan_oa);
            $month = $date->format('F');
            $weekNumber = ceil($date->day / 7);
            $validatedData['week_plan_oa'] = "$month, Week $weekNumber";
        }
        
        // Add user ID
        $validatedData['user_id'] = Auth::id();
        
        Lop::create($validatedData);
        
        return redirect()->route('home')->with('success', 'LOP berhasil ditambahkan');
    }

    /**
     * Update the specified LOP resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lop  $lop
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Lop $lop)
    {
        $request->validate([
            'status_proyek' => 'required|string|max:255',
            'last_issue' => 'nullable|string',
            'kendala' => 'nullable|string',
            'tanggal_plan_oa' => 'nullable|date',
        ]);

        // Store original values before update
        $originalStatus = $lop->status_proyek;
        $originalDate = $lop->tanggal_plan_oa;

        // Update fields
        $lop->status_proyek = $request->status_proyek;
        $lop->last_issue = $request->last_issue;
        $lop->kendala = $request->kendala;
        $lop->tanggal_plan_oa = $request->tanggal_plan_oa;
        
        // Update week_plan_oa if tanggal_plan_oa was changed
        if ($request->tanggal_plan_oa && ($originalDate != $request->tanggal_plan_oa)) {
            $date = Carbon::parse($request->tanggal_plan_oa);
            $month = $date->format('F');
            $weekNumber = ceil($date->day / 7);
            $lop->week_plan_oa = "$month, Week $weekNumber";
        }

        // Save changes
        $lop->save();
        
        // Generate appropriate success message
        $successMessage = 'Site berhasil diperbarui';
        if ($originalStatus != $request->status_proyek) {
            $successMessage = "Status berhasil diubah dari $originalStatus menjadi {$request->status_proyek}";
        }

        return redirect()->back()->with('success', $successMessage);
    }

    /**
     * Get status options for forms.
     * 
     * @return array
     */
    public function getStatusOptions()
    {
        return [
            'OA', 'MAT DEL', 'DONE', 'SURVEY', 'POWER ON', 
            'DROP', 'MOS', 'INTEGRASI', 'DONE SURVEY', 'DONE UT', 'INSTALL RACK'
        ];
    }

    /**
     * Get kendala options for forms.
     * 
     * @return array
     */
    public function getKendalaOptions()
    {
        return [
            'COMMCASE', 'NEW PLN', 'NO ISSUE', 'PERMIT', 'PONDASI', 
            'RELOC', 'SFP BIDI', 'WAITING OTN', 'WAITING UPLINK', 
            'L2SWITCH', 'MIGRASI', 'UPGRADE PLN'
        ];
    }
}