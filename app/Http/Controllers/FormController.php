<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FormController extends Controller
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
     * Display the form type selection page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('forms.index');
    }

    /**
     * Display the upload form page for a specific form type.
     *
     * @param  string  $type
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function uploadForm($type)
    {
        $validTypes = ['ba-survey-mini-olt', 'ba-survey-big-olt', 'caf'];
        
        if (!in_array($type, $validTypes)) {
            return redirect()->route('forms.index')->with('error', 'Invalid form type selected');
        }
        
        // Convert slug to display name
        $formTypeName = match ($type) {
            'ba-survey-mini-olt' => 'BA SURVEY MINI OLT',
            'ba-survey-big-olt' => 'BA SURVEY BIG OLT',
            'caf' => 'CAF',
            default => ucfirst(str_replace('-', ' ', $type))
        };
        
        return view('forms.upload', compact('type', 'formTypeName'));
    }

    /**
     * Process the form upload.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $type
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processUpload(Request $request, $type)
    {
        $validTypes = ['ba-survey-mini-olt', 'ba-survey-big-olt', 'caf'];
        
        if (!in_array($type, $validTypes)) {
            return redirect()->route('forms.index')->with('error', 'Invalid form type selected');
        }
        
        $request->validate([
            'title' => 'required|string|max:255',
            'site_id' => 'required|string|max:255',
            'form_file' => 'required|file|mimes:pdf|max:10240',
        ]);
        
        $file = $request->file('form_file');
        $filename = time() . '_' . $file->getClientOriginalName();
        
        // Store the file
        $path = $file->storeAs('forms/' . $type, $filename, 'public');
        
        // Create form record in database
        Form::create([
            'title' => $request->title,
            'site_id' => $request->site_id,
            'type' => $type,
            'file_path' => $path,
            'user_id' => Auth::id(),
        ]);
        
        return redirect()->route('forms.list')->with('success', 'Form uploaded successfully');
    }

    /**
     * Display a list of uploaded forms.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function list(Request $request)
    {
        $query = $request->input('search');
        $type = $request->input('type');
        
        $forms = Form::when($query, function($q) use ($query) {
                return $q->where('title', 'like', '%'.$query.'%')
                    ->orWhere('site_id', 'like', '%'.$query.'%');
            })
            ->when($type, function($q) use ($type) {
                return $q->where('type', $type);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('forms.list', compact('forms', 'query', 'type'));
    }

    /**
     * Download a form.
     *
     * @param  int  $id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download($id)
    {
        $form = Form::findOrFail($id);
        
        if (!Storage::disk('public')->exists($form->file_path)) {
            return redirect()->route('forms.list')->with('error', 'File not found');
        }
        
        return response()->download(storage_path('app/public/' . $form->file_path));
    }
    
}