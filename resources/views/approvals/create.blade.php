<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Request</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

<div class="w-full max-w-xl bg-white rounded-xl shadow-lg p-8">

    <!-- Heading -->
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold text-gray-800">Create Approval Request</h1>
        <p class="text-gray-500 text-sm">Submit your request for approval</p>
    </div>

    <!-- Form -->
    <form method="POST" action="{{ route('approvals.store') }}" class="space-y-4">
        @csrf

        <!-- Title -->
        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">
                Title
            </label>
            <input type="text" name="title"
                   class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                   placeholder="Enter request title">
        </div>

        <!-- Description -->
        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">
                Description
            </label>
            <textarea name="description" rows="4"
                      class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                      placeholder="Enter request details"></textarea>
        </div>

        <!-- Buttons -->
        <div class="flex justify-between items-center pt-4">

            <a href="{{ route('approvals.index') }}"
               class="text-gray-500 hover:text-gray-700 text-sm">
                ← Back
            </a>

            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow transition">
                Submit Request
            </button>

        </div>

    </form>

</div>

</body>
</html>