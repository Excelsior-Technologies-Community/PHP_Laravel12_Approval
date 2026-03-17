<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Approval;

class ApprovalController extends Controller
{
    public function index()
    {
        $approvals = Approval::latest()->get();
        return view('approvals.index', compact('approvals'));
    }
    public function create()
    {
        return view('approvals.create');
    }
    public function store(Request $request)
    {
        $request->validate(['title' => 'required', 'description' => 'required',]);
        Approval::create(['title' => $request->title, 'description' => $request->description,]);
        return redirect()->route('approvals.index')->with('success', 'Request submitted successfully!');
    }
    public function approve($id)
    {
        $approval = Approval::findOrFail($id);
        $approval->update(['status' => 'approved']);
        return back()->with('success', 'Request approved!');
    }
    public function reject($id)
    {
        $approval = Approval::findOrFail($id);
        $approval->update(['status' => 'rejected']);
        return back()->with('success', 'Request rejected!');
    }
}
