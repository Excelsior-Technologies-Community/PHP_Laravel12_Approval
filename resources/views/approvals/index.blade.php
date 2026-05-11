<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Approval Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

    <div class="max-w-7xl mx-auto p-6">

        <!-- Success Alert -->
        @if(session('success'))
            <div id="alert"
                class="mb-5 flex justify-between items-center bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg">

                <span>{{ session('success') }}</span>

                <button onclick="document.getElementById('alert').remove()">
                    ✕
                </button>
            </div>

            <script>
                setTimeout(() => {
                    let alert = document.getElementById('alert');
                    if (alert) {
                        alert.style.opacity = "0";
                        setTimeout(() => alert.remove(), 500);
                    }
                }, 3000);
            </script>
        @endif

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">

            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    Approval Dashboard
                </h1>

                <p class="text-gray-500">
                    Manage all approval requests
                </p>
            </div>

            <a href="{{ route('approvals.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow">
                + New Request
            </a>

        </div>

        <!-- Search & Filter -->
        <div class="bg-white p-4 rounded-xl shadow mb-5">

            <form method="GET" class="flex flex-wrap gap-4">

                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search title..."
                    class="border border-gray-300 rounded-lg px-4 py-2 w-64">

                <select name="status" class="border border-gray-300 rounded-lg px-4 py-2">

                    <option value="">All Status</option>

                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                        Pending
                    </option>

                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>
                        Approved
                    </option>

                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>
                        Rejected
                    </option>

                </select>

                <button class="bg-gray-800 hover:bg-black text-white px-5 py-2 rounded-lg">
                    Search
                </button>

            </form>

        </div>

        <!-- Table -->
        <div class="bg-white rounded-xl shadow overflow-hidden">

            <table class="w-full text-left">

                <thead class="bg-gray-50 border-b">

                    <tr>
                        <th class="p-4">ID</th>
                        <th class="p-4">Title</th>
                        <th class="p-4">Description</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Actions</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($approvals as $item)

                        <tr class="border-b hover:bg-gray-50">

                            <td class="p-4">
                                {{ $approvals->firstItem() + $loop->index }}
                            </td>

                            <td class="p-4 font-semibold">
                                {{ $item->title }}
                            </td>

                            <td class="p-4 text-gray-600">
                                {{ $item->description }}
                            </td>

                            <td class="p-4">

                                @if($item->status == 'pending')
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">
                                        Pending
                                    </span>
                                @elseif($item->status == 'approved')
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                                        Approved
                                    </span>
                                @else
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">
                                        Rejected
                                    </span>
                                @endif

                            </td>

                            <td class="p-4 flex gap-2">

                                <a href="{{ route('approvals.approve', $item->id) }}"
                                    class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-md text-sm">
                                    Approve
                                </a>

                                <a href="{{ route('approvals.reject', $item->id) }}"
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-sm">
                                    Reject
                                </a>

                                <!-- Delete -->
                                <form action="{{ route('approvals.destroy', $item->id) }}" method="POST"
                                    onsubmit="return confirm('Delete this request?')">

                                    @csrf
                                    @method('DELETE')

                                    <button class="bg-gray-700 hover:bg-black text-white px-3 py-1 rounded-md text-sm">
                                        Delete
                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="text-center p-6 text-gray-500">
                                No approval requests found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <!-- Pagination -->
        <div class="mt-5">
            {{ $approvals->links() }}
        </div>

    </div>

</body>

</html>