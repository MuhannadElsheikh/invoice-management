<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = Section::all();
        return view('section.index', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $request->validate([
            'section_name' => 'required|string|unique:sections',
            'description' => 'nullable|string',
        ]);



        Section::create([
            'section_name' => $request->section_name,
            'description' => $request->description,
            'create_by' => Auth::user()->name,
        ]);



        return redirect()->route('section.index')->with('status', 'تم إضافة قسم بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $id = $request->id;
        $request->validate([
            'section_name' => 'required|string|unique:sections,section_name,' . $id,
            'description' => 'nullable|string',
        ]);


        $section = Section::find($id);
        $section->update([
            'section_name' => $request->section_name,
            'description' => $request->description,

        ]);

        return redirect()->route('section.index')->with('status', 'تم تعديل القسم بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( Section $section)
    {

        $section->delete();
        return redirect()->route('section.index')->with('status', 'تم حذف القسم بنجاح');
    }
}
