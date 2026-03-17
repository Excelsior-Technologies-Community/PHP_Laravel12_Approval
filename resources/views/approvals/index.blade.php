<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Approval Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

<div class="max-w-6xl mx-auto p-6">

    <!-- Success Message -->
    @if(session('success'))
    <div id="successAlert"
         class="mb-4 flex items-center justify-between bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg shadow">

        <span class="font-medium">{{ session('success') }}</span>

        <button onclick="document.getElementById('successAlert').remove()"
                class="ml-4 text-green-700 hover:text-green-900 font-bold">
            ✕
        </button>
    </div>

    <script>
        setTimeout(() => {
            const alert = document.getElementById('successAlert');
            if (alert) {
                alert.style.transition = "opacity 0.5s";
                alert.style.opacity = "0";
                setTimeout(() => alert.remove(), 500);
            }
        }, 3000);
    </script>
    @endif

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Approval Dashboard</h1>
            <p class="text-gray-500">Manage and track all approval requests</p>
        </div>

        <a href="{{ route('approvals.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow transition">
            + New Request
        </a>
    </div>

    <!-- Card -->
    <div class="bg-white rounded-xl shadow overflow-hidden">

        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="p-4 text-sm font-semibold text-gray-600">Title</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Status</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($approvals as $item)
                <tr class="border-b hover:bg-gray-50 transition">

                    <td class="p-4 font-medium text-gray-800">
                        {{ $item->title }}
                    </td>

                    <!-- Status Badge -->
                    <td class="p-4">
                        @if($item->status == 'pending')
                            <span class="px-3 py-1 text-sm rounded-full bg-yellow-100 text-yellow-700">
                                Pending
                            </span>
                        @elseif($item->status == 'approved')
                            <span class="px-3 py-1 text-sm rounded-full bg-green-100 text-green-700">
                                Approved
                            </span>
                        @else
                            <span class="px-3 py-1 text-sm rounded-full bg-red-100 text-red-700">
                                Rejected
                            </span>
                        @endif
                    </td>

                    <!-- Actions -->
                    <td class="p-4 space-x-2">

                        <a href="{{ route('approvals.approve', $item->id) }}"
                           class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-md text-sm transition">
                            Approve
                        </a>

                        <a href="{{ route('approvals.reject', $item->id) }}"
                           class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-sm transition">
                            Reject
                        </a>

                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="3" class="p-6 text-center text-gray-500">
                        No approval requests found.
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>

    </div>

</div>

</body>
</html>