<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Approval;
use Illuminate\Support\Facades\Log;

class ApprovalController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $query = Approval::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('requester', 'like', "%{$search}%");
            });
        }

        $approvals = $query->latest()->paginate(10);
        
        // Get search history from session
        $searchHistory = session()->get('search_history', []);
        
        return view('approvals.index', compact('approvals', 'search', 'searchHistory'));
    }

    public function create()
    {
        return view('approvals.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requester' => 'required|string|max:100',
        ]);

        Approval::create($request->all());

        return redirect()->route('approvals.index')->with('success', 'Approval request created successfully!');
    }

    public function approve($id)
    {
        $approval = Approval::findOrFail($id);
        $approval->update(['status' => 'approved']);

        return redirect()->route('approvals.index')->with('success', 'Approval approved successfully!');
    }

    public function reject($id)
    {
        $approval = Approval::findOrFail($id);
        $approval->update(['status' => 'rejected']);

        return redirect()->route('approvals.index')->with('success', 'Approval rejected successfully!');
    }

    public function destroy($id)
    {
        $approval = Approval::findOrFail($id);
        $approval->delete();

        return redirect()->route('approvals.index')->with('success', 'Approval deleted successfully!');
    }

    public function searchSuggestions(Request $request)
    {
        $search = $request->get('query', '');
        
        if (strlen($search) < 2) {
            return response()->json([]);
        }

        // Save to search history
        $history = session()->get('search_history', []);
        if (!in_array($search, $history)) {
            array_unshift($history, $search);
            if (count($history) > 10) {
                array_pop($history);
            }
            session()->put('search_history', $history);
        }

        $suggestions = Approval::where('title', 'like', "%{$search}%")
            ->orWhere('description', 'like', "%{$search}%")
            ->orWhere('requester', 'like', "%{$search}%")
            ->limit(5)
            ->get(['id', 'title', 'requester', 'status']);

        return response()->json($suggestions);
    }
}