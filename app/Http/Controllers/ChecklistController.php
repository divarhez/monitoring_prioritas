<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChecklistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $checklists = \App\Models\Checklist::with('device')->get();
    return view('checklists.index', compact('checklists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    $devices = \App\Models\Device::all();
    return view('checklists.create', compact('devices'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'device_id' => 'required|exists:devices,id',
            'item' => 'required|string',
            'status' => 'required|boolean',
            'note' => 'nullable|string',
        ]);
        \App\Models\Checklist::create($request->all());
        return redirect()->route('checklists.index')->with('success', 'Checklist berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    $checklist = \App\Models\Checklist::findOrFail($id);
    return view('checklists.show', compact('checklist'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    $checklist = \App\Models\Checklist::findOrFail($id);
    $devices = \App\Models\Device::all();
    return view('checklists.edit', compact('checklist', 'devices'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'device_id' => 'required|exists:devices,id',
            'item' => 'required|string',
            'status' => 'required|boolean',
            'note' => 'nullable|string',
        ]);
        $checklist = \App\Models\Checklist::findOrFail($id);
        $checklist->update($request->all());
        return redirect()->route('checklists.index')->with('success', 'Checklist berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    $checklist = \App\Models\Checklist::findOrFail($id);
    $checklist->delete();
    return redirect()->route('checklists.index')->with('success', 'Checklist berhasil dihapus');
    }
}
