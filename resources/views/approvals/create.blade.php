<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Create Approval Request</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --bg-primary: #0a0e17;
            --bg-secondary: #111827;
            --bg-card: #1a2332;
            --bg-input: #0f1729;
            --text-primary: #e8edf5;
            --text-secondary: #94a3b8;
            --border-color: #2d3a4f;
            --shadow: 0 4px 20px rgba(0,0,0,0.3);
            --accent: #6366f1;
            --accent-hover: #818cf8;
            --radius: 12px;
            --transition: 0.3s ease;
        }

        [data-theme="light"] {
            --bg-primary: #f1f5f9;
            --bg-secondary: #ffffff;
            --bg-card: #ffffff;
            --bg-input: #f8fafc;
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --border-color: #e2e8f0;
            --shadow: 0 4px 20px rgba(0,0,0,0.08);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
            transition: background var(--transition), color var(--transition);
        }

        .container { max-width: 600px; margin: 0 auto; padding: 40px 20px; }

        .card {
            background: var(--bg-secondary);
            border-radius: var(--radius);
            padding: 32px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 2px solid var(--border-color);
        }

        .card-header h2 {
            font-size: 24px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .card-header h2 i { color: var(--accent); }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-group .required {
            color: var(--danger);
            margin-left: 4px;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            background: var(--bg-input);
            border: 2px solid var(--border-color);
            border-radius: var(--radius);
            color: var(--text-primary);
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            transition: var(--transition);
            outline: none;
        }

        .form-control:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 120px;
        }

        .form-text {
            font-size: 12px;
            color: var(--text-secondary);
            margin-top: 4px;
        }

        .btn {
            padding: 12px 24px;
            border-radius: var(--radius);
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
        }

        .btn-primary {
            background: var(--accent);
            color: white;
        }

        .btn-primary:hover {
            background: var(--accent-hover);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(99,102,241,0.4);
        }

        .btn-secondary {
            background: var(--bg-input);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
        }

        .btn-secondary:hover {
            border-color: var(--accent);
        }

        .btn-group {
            display: flex;
            gap: 12px;
            margin-top: 8px;
        }

        .theme-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 50%;
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            color: var(--text-primary);
            font-size: 18px;
            z-index: 100;
            box-shadow: var(--shadow);
        }

        .theme-toggle:hover {
            transform: rotate(20deg);
            border-color: var(--accent);
        }

        @media (max-width: 480px) {
            .container { padding: 20px 12px; }
            .card { padding: 20px; }
            .btn-group { flex-direction: column; }
            .btn { justify-content: center; }
        }
    </style>
</head>
<body>

<button class="theme-toggle" onclick="toggleTheme()" title="Toggle Theme">
    <i class="fas fa-moon" id="themeIcon"></i>
</button>

<div class="container">
    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-plus-circle"></i> New Approval Request</h2>
            <a href="{{ route('approvals.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>

        <form action="{{ route('approvals.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="title">Title <span class="required">*</span></label>
                <input type="text" name="title" id="title" class="form-control" 
                       placeholder="Enter approval title" value="{{ old('title') }}" required>
                @error('title')
                    <div class="form-text" style="color:var(--danger);">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="requester">Requester <span class="required">*</span></label>
                <input type="text" name="requester" id="requester" class="form-control" 
                       placeholder="Enter requester name" value="{{ old('requester') }}" required>
                @error('requester')
                    <div class="form-text" style="color:var(--danger);">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description <span class="required">*</span></label>
                <textarea name="description" id="description" class="form-control" 
                          placeholder="Describe the approval request in detail..." required>{{ old('description') }}</textarea>
                @error('description')
                    <div class="form-text" style="color:var(--danger);">{{ $message }}</div>
                @enderror
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane"></i> Submit Request
                </button>
                <a href="{{ route('approvals.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleTheme() {
        const html = document.documentElement;
        const icon = document.getElementById('themeIcon');
        
        if (html.getAttribute('data-theme') === 'dark') {
            html.setAttribute('data-theme', 'light');
            icon.className = 'fas fa-sun';
            localStorage.setItem('theme', 'light');
        } else {
            html.setAttribute('data-theme', 'dark');
            icon.className = 'fas fa-moon';
            localStorage.setItem('theme', 'dark');
        }
    }

    (function initTheme() {
        const saved = localStorage.getItem('theme');
        const icon = document.getElementById('themeIcon');
        if (saved === 'light') {
            document.documentElement.setAttribute('data-theme', 'light');
            icon.className = 'fas fa-sun';
        } else {
            document.documentElement.setAttribute('data-theme', 'dark');
            icon.className = 'fas fa-moon';
        }
    })();
</script>

</body>
</html>