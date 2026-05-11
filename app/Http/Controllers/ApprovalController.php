<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Approval;

class ApprovalController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $status = $request->status;

        $query = Approval::query();

        // Search
        if ($search) {
            $query->where('title', 'like', "%$search%")
                ->orwhere('description', 'like', "%$search%");
        }

        // Status Filter
        if ($status) {
            $query->where('status', $status);
        }

        // Pagination
        $approvals = $query->latest()->paginate(5);

        return view('approvals.index', compact('approvals'));
    }

    public function create()
    {
        return view('approvals.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:3',
            'description' => 'required|min:5',
        ]);

        Approval::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('approvals.index')
            ->with('success', 'Request submitted successfully!');
    }

    public function approve($id)
    {
        $approval = Approval::findOrFail($id);

        $approval->update([
            'status' => 'approved'
        ]);

        return back()->with('success', 'Request approved!');
    }

    public function reject($id)
    {
        $approval = Approval::findOrFail($id);

        $approval->update([
            'status' => 'rejected'
        ]);

        return back()->with('success', 'Request rejected!');
    }

    // Delete Function
    public function destroy($id)
    {
        $approval = Approval::findOrFail($id);

        $approval->delete();

        return back()->with('success', 'Request deleted successfully!');
    }
}