# PHP_Laravel12_Approval

## Introduction

PHP_Laravel12_Approval is a modern Laravel 12 project designed to demonstrate a complete **Approval Workflow System** used in real-world applications.

The system enables users to submit requests while allowing administrators to review, approve, or reject them. Each request is tracked with a dynamic status, ensuring clear visibility and workflow management.

This project showcases core Laravel concepts such as MVC architecture, routing, Eloquent ORM, form validation, and dynamic UI rendering using Blade and Tailwind CSS.

It is inspired by real-world use cases like leave management systems, admin approvals, and content moderation platforms.

---

## Project Overview

This project follows the **MVC (Model-View-Controller)** architecture of Laravel.

- **Model (Approval.php)**  
  Handles database interaction and represents approval records.

- **View (Blade Files)**  
  Provides a clean and modern user interface for listing and creating requests.

- **Controller (ApprovalController.php)**  
  Manages application logic such as storing requests and updating approval status.

---

## Features

* Submit and manage approval requests with real-time status updates
* Approval actions (Approve / Reject)
* Status tracking system
* Clean UI using Blade + Tailwind
* Secure validation and routing
* Scalable structure for real-world apps

---

## Requirements

* PHP >= 8.2
* Laravel 12
* Composer
* MySQL
* Node.js & NPM (Optional for frontend assets)
* Tailwind CSS (via CDN)

---

## Step 1: Create Laravel 12 Project

```bash
composer create-project laravel/laravel PHP_Laravel12_Approval "12.*"
cd PHP_Laravel12_Approval
```

Run server:

```bash
php artisan serve
```

---

## Step 2: Setup Database

Update `.env` file:

```env
DB_DATABASE=approval_db
DB_USERNAME=root
DB_PASSWORD=
```

Run migration:

```bash
php artisan migrate
```

---

## Step 3: Create Model & Migration

We create an Approval model.

```bash
php artisan make:model Approval -m
```

This single command creates two important files:

- app/Models/Approval.php

- database/migrations/xxxx_xx_xx_create_approvals_table.php

---

## Step 4: Migration Table

File: database/migrations/xxxx_create_approvals_table.php

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('approvals', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approvals');
    }
};
```

Run:

```bash
php artisan migrate
```

---

## Step 5: Update Model

File: app/Models/Approval.php

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    protected $fillable = ['title', 'description', 'status'];
}
```

---

## Step 6: Create Controller

```bash
php artisan make:controller ApprovalController
```

File: app/Http/Controllers/ApprovalController.php

```php
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
```

---


## Step 7: Define Routes

File: routes/web.php

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApprovalController;

Route::get('/', [ApprovalController::class, 'index'])->name('approvals.index');
Route::get('/create', [ApprovalController::class, 'create'])->name('approvals.create');
Route::post('/store', [ApprovalController::class, 'store'])->name('approvals.store');
Route::get('/approve/{id}', [ApprovalController::class, 'approve'])->name('approvals.approve');
Route::get('/reject/{id}', [ApprovalController::class, 'reject'])->name('approvals.reject');
```

---

## Step 8: Create Blade Files

### index.blade.php

File: resources/views/approvals/index.blade.php

```html
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
```

---

### create.blade.php

File: resources/views/approvals/create.blade.php

```html
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
```

---

## Step 9: Run Project

```bash
php artisan serve
```

Visit:

```
http://127.0.0.1:8000
```
---

## Workflow:

1. User creates a new approval request  
2. Request is stored with **Pending** status  
3. Admin can:
   - Approve → Status becomes **Approved**
   - Reject → Status becomes **Rejected**  
4. Success messages provide instant feedback to users  
5. Dashboard updates dynamically with latest data  

---

## Output

<img src="screenshots/Screenshot 2026-03-17 133303.png" width="1000">

<img src="screenshots/Screenshot 2026-03-17 133315.png" width="1000">

<img src="screenshots/Screenshot 2026-03-17 133330.png" width="1000">

---

## Project Structure 

```
PHP_Laravel12_Approval/
│
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── ApprovalController.php
│   │
│   └── Models/
│       └── Approval.php
│
├── database/
│   ├── migrations/
│   │   └── xxxx_create_approvals_table.php
│   │
│   └── seeders/
│
├── resources/
│   ├── views/
│   │   └── approvals/
│   │       ├── index.blade.php
│   │       └── create.blade.php
│   │
│   └── css / js
│
├── routes/
│   └── web.php
│
├── public/
│
├── .env
├── composer.json
└── artisan
```

---

Your PHP_Laravel12_Approval Project is now ready!
<<<<<<< HEAD

=======
>>>>>>> development
