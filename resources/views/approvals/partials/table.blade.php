<table class="w-full text-sm text-left border-collapse">
    <thead>
        <tr class="border-b border-gray-300 dark:border-gray-700 text-gray-500 dark:text-gray-400">
            <th class="py-3 px-3">Title</th>
            <th class="py-3 px-3">Requested By</th>
            <th class="py-3 px-3">Status</th>
            <th class="py-3 px-3">Date</th>
            <th class="py-3 px-3 text-right">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($approvals as $approval)
            <tr class="border-b border-gray-200 dark:border-gray-800 hover:bg-gray-100 dark:hover:bg-gray-800/50">
                <td class="py-3 px-3 font-medium">{{ $approval->title }}</td>
                <td class="py-3 px-3 text-gray-500 dark:text-gray-400">{{ $approval->requested_by ?? '—' }}</td>
                <td class="py-3 px-3">
                    @if($approval->status === 'approved')
                        <span class="px-3 py-1 rounded-full text-xs bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400">Approved</span>
                    @elseif($approval->status === 'rejected')
                        <span class="px-3 py-1 rounded-full text-xs bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-400">Rejected</span>
                    @else
                        <span class="px-3 py-1 rounded-full text-xs bg-yellow-100 text-yellow-700 dark:bg-yellow-900/40 dark:text-yellow-400">Pending</span>
                    @endif
                </td>
                <td class="py-3 px-3 text-gray-500 dark:text-gray-400">{{ $approval->created_at->format('d M Y') }}</td>
                <td class="py-3 px-3">
                    <div class="flex justify-end gap-2">
                        @if($approval->status === 'pending')
                            <a href="{{ route('approvals.approve', $approval->id) }}"
                               class="px-3 py-1 rounded bg-green-600 text-white text-xs hover:bg-green-700">Approve</a>
                            <a href="{{ route('approvals.reject', $approval->id) }}"
                               class="px-3 py-1 rounded bg-red-600 text-white text-xs hover:bg-red-700">Reject</a>
                        @endif
                        <form action="{{ route('approvals.destroy', $approval->id) }}" method="POST"
                              onsubmit="return confirm('Delete this request?')">
                            @csrf
                            @method('DELETE')
                            <button class="px-3 py-1 rounded bg-gray-500 text-white text-xs hover:bg-gray-600">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="py-6 text-center text-gray-400">No approval requests found.</td>
            </tr>
        @endforelse
    </tbody>
</table>