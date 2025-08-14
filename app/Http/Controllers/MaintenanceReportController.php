<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MaintenanceReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'maintenance_schedule_id' => 'required|exists:maintenance_schedules,id',
            'device_id' => 'required|exists:devices,id',
            'result' => 'required|string',
            'recommendation' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        $data = $request->all();
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('maintenance_photos', 'public');
        }
        \App\Models\MaintenanceReport::create($data);
        return redirect()->route('maintenance-reports.index')->with('success', 'Laporan maintenance berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'maintenance_schedule_id' => 'required|exists:maintenance_schedules,id',
            'device_id' => 'required|exists:devices,id',
            'result' => 'required|string',
            'recommendation' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        $report = \App\Models\MaintenanceReport::findOrFail($id);
        $data = $request->all();
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('maintenance_photos', 'public');
        }
        $report->update($data);
        return redirect()->route('maintenance-reports.index')->with('success', 'Laporan maintenance berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
