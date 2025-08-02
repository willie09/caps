<?php

namespace App\Http\Controllers;

use App\Models\WalkInLog;
use Illuminate\Http\Request;

class WalkInLogController extends Controller
{
    public function index()
    {
        $walkInLogs = WalkInLog::all();
        return view('walkins', compact('walkInLogs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'time' => 'required|date_format:H:i',
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0',
        ]);

        WalkInLog::create($validated);

        return redirect()->route('walkins')->with('success', 'Walk-in log added successfully.');
    }
    
    public function destroy($id)
{
$walkInLog = WalkInLog::findOrFail($id);
$walkInLog->delete();


return redirect()->route('walkins')->with('success', 'Walk-in log deleted successfully.');
}
}
