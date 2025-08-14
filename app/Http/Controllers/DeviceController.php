<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = \App\Models\Device::with('user');
        if (request()->filled('category')) {
            $query->where('category', request('category'));
        }
        $devices = $query->get();
        if (request()->has('export') && request('export') === 'excel') {
            $path = \App\Helpers\ExcelExportHelper::exportDevices($devices);
            return response()->download($path)->deleteFileAfterSend(true);
        }
        if (request()->has('export') && request('export') === 'pdf') {
            $pdf = \PDF::loadView('devices.export_pdf', compact('devices'));
            return $pdf->download('devices.pdf');
        }
        return view('devices.index', compact('devices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    $users = \App\Models\User::where('role', 'user')->get();
    return view('devices.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'type' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);
        \App\Models\Device::create($request->all());
        return redirect()->route('devices.index')->with('success', 'Perangkat berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    $device = \App\Models\Device::with('user')->findOrFail($id);
    return view('devices.show', compact('device'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    $device = \App\Models\Device::findOrFail($id);
    $users = \App\Models\User::where('role', 'user')->get();
    return view('devices.edit', compact('device', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'type' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);
        $device = \App\Models\Device::findOrFail($id);
        $device->update($request->all());
        return redirect()->route('devices.index')->with('success', 'Perangkat berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    $device = \App\Models\Device::findOrFail($id);
    $device->delete();
    return redirect()->route('devices.index')->with('success', 'Perangkat berhasil dihapus');
    }
}
