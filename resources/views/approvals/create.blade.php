<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Request</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

<div class="w-full max-w-2xl bg-white rounded-xl shadow-lg p-8">

    <div class="mb-6 text-center">

        <h1 class="text-3xl font-bold text-gray-800">
            Create Approval Request
        </h1>

        <p class="text-gray-500">
            Submit request for approval
        </p>

    </div>

    <form action="{{ route('approvals.store') }}"
          method="POST"
          class="space-y-5">

        @csrf

        <!-- Title -->
        <div>

            <label class="block mb-1 text-sm font-medium text-gray-700">
                Title
            </label>

            <input
                type="text"
                name="title"
                value="{{ old('title') }}"
                placeholder="Enter title"
                class="w-full border border-gray-300 rounded-lg p-3">

            @error('title')
                <p class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror

        </div>

        <!-- Description -->
        <div>

            <label class="block mb-1 text-sm font-medium text-gray-700">
                Description
            </label>

            <textarea
                name="description"
                rows="5"
                placeholder="Enter description"
                class="w-full border border-gray-300 rounded-lg p-3">{{ old('description') }}</textarea>

            @error('description')
                <p class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror

        </div>

        <!-- Buttons -->
        <div class="flex justify-between items-center pt-4">

            <a href="{{ route('approvals.index') }}"
               class="text-gray-500 hover:text-black">
                ← Back
            </a>

            <button
                type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow">
                Submit Request
            </button>

        </div>

    </form>

</div>

</body>
</html>