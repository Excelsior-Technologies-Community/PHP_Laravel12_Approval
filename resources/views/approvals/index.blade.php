<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Approval System</title>
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
            --hover-bg: #1e2d45;
            --accent: #6366f1;
            --accent-hover: #818cf8;
            --success: #22c55e;
            --warning: #f59e0b;
            --danger: #ef4444;
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
            --hover-bg: #f1f5f9;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
            transition: background var(--transition), color var(--transition);
        }

        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }

        /* Navbar */
        .navbar {
            background: var(--bg-secondary);
            border-bottom: 1px solid var(--border-color);
            padding: 16px 0;
            position: sticky;
            top: 0;
            z-index: 100;
            backdrop-filter: blur(10px);
        }

        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-brand {
            font-size: 22px;
            font-weight: 700;
            color: var(--text-primary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-brand i { color: var(--accent); }

        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .theme-toggle {
            background: var(--bg-input);
            border: 1px solid var(--border-color);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            color: var(--text-primary);
            font-size: 18px;
        }

        .theme-toggle:hover {
            border-color: var(--accent);
            transform: rotate(20deg);
        }

        .btn {
            padding: 10px 20px;
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

        .btn-success {
            background: var(--success);
            color: white;
        }

        .btn-success:hover {
            background: #16a34a;
            transform: translateY(-2px);
        }

        .btn-danger {
            background: var(--danger);
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
            transform: translateY(-2px);
        }

        .btn-warning {
            background: var(--warning);
            color: white;
        }

        .btn-warning:hover {
            background: #d97706;
            transform: translateY(-2px);
        }

        .btn-sm {
            padding: 6px 14px;
            font-size: 12px;
        }

        /* Search Section */
        .search-section {
            background: var(--bg-secondary);
            border-radius: var(--radius);
            padding: 20px;
            margin-bottom: 24px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow);
            position: relative;
        }

        .search-box {
            display: flex;
            gap: 12px;
            position: relative;
        }

        .search-box input {
            flex: 1;
            padding: 12px 44px 12px 16px;
            background: var(--bg-input);
            border: 2px solid var(--border-color);
            border-radius: var(--radius);
            color: var(--text-primary);
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            transition: var(--transition);
            outline: none;
        }

        .search-box input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
        }

        .search-box input::placeholder {
            color: var(--text-secondary);
        }

        .search-box .search-icon {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
        }

        /* Search Suggestions */
        .suggestions-dropdown {
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            right: 0;
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            display: none;
            max-height: 300px;
            overflow-y: auto;
            z-index: 50;
        }

        .suggestions-dropdown.show { display: block; }

        .suggestion-item {
            padding: 12px 16px;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid var(--border-color);
        }

        .suggestion-item:last-child { border-bottom: none; }

        .suggestion-item:hover {
            background: var(--hover-bg);
        }

        .suggestion-item .s-title {
            font-weight: 500;
            color: var(--text-primary);
        }

        .suggestion-item .s-meta {
            font-size: 12px;
            color: var(--text-secondary);
            margin-left: auto;
        }

        .suggestion-item .s-badge {
            padding: 2px 10px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 600;
        }

        .s-badge.pending { background: rgba(245,158,11,0.15); color: var(--warning); }
        .s-badge.approved { background: rgba(34,197,94,0.15); color: var(--success); }
        .s-badge.rejected { background: rgba(239,68,68,0.15); color: var(--danger); }

        /* Search History */
        .search-history {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px solid var(--border-color);
        }

        .history-tag {
            padding: 4px 12px;
            background: var(--bg-input);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            font-size: 12px;
            color: var(--text-secondary);
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .history-tag:hover {
            border-color: var(--accent);
            color: var(--text-primary);
        }

        .history-tag .remove-history {
            cursor: pointer;
            color: var(--danger);
            font-size: 10px;
        }

        /* Stats */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: var(--bg-secondary);
            border-radius: var(--radius);
            padding: 18px 20px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow);
        }

        .stat-card .stat-label {
            font-size: 12px;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-card .stat-value {
            font-size: 28px;
            font-weight: 700;
            margin-top: 4px;
        }

        .stat-card .stat-value.pending { color: var(--warning); }
        .stat-card .stat-value.approved { color: var(--success); }
        .stat-card .stat-value.rejected { color: var(--danger); }
        .stat-card .stat-value.total { color: var(--accent); }

        /* Table */
        .table-wrapper {
            background: var(--bg-secondary);
            border-radius: var(--radius);
            border: 1px solid var(--border-color);
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .table-wrapper .table-header {
            padding: 18px 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-wrapper .table-header h3 {
            font-size: 18px;
            font-weight: 600;
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            padding: 12px 16px;
            text-align: left;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-secondary);
            border-bottom: 2px solid var(--border-color);
            background: var(--bg-input);
        }

        td {
            padding: 12px 16px;
            border-bottom: 1px solid var(--border-color);
            font-size: 14px;
        }

        tr:hover td {
            background: var(--hover-bg);
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .status-badge.pending {
            background: rgba(245,158,11,0.15);
            color: var(--warning);
        }

        .status-badge.approved {
            background: rgba(34,197,94,0.15);
            color: var(--success);
        }

        .status-badge.rejected {
            background: rgba(239,68,68,0.15);
            color: var(--danger);
        }

        .action-btns {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-secondary);
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 16px;
            opacity: 0.5;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 6px;
            padding: 16px 20px;
            border-top: 1px solid var(--border-color);
        }

        .pagination a, .pagination span {
            padding: 8px 14px;
            border-radius: 8px;
            text-decoration: none;
            color: var(--text-primary);
            transition: var(--transition);
            border: 1px solid var(--border-color);
        }

        .pagination a:hover {
            background: var(--accent);
            border-color: var(--accent);
            color: white;
        }

        .pagination .active {
            background: var(--accent);
            border-color: var(--accent);
            color: white;
        }

        /* Toast */
        .toast {
            position: fixed;
            bottom: 24px;
            right: 24px;
            padding: 14px 20px;
            border-radius: var(--radius);
            color: white;
            font-weight: 500;
            z-index: 1000;
            animation: slideIn 0.3s ease;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
            display: none;
        }

        .toast.success { background: var(--success); }
        .toast.error { background: var(--danger); }

        @keyframes slideIn {
            from { transform: translateX(100px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .navbar .container { flex-wrap: wrap; gap: 12px; }
            .navbar-actions { width: 100%; justify-content: flex-end; }
            .search-box { flex-direction: column; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            table { font-size: 13px; }
            td, th { padding: 8px 12px; }
            .action-btns .btn-sm { font-size: 10px; padding: 4px 10px; }
        }

        @media (max-width: 480px) {
            .stats-grid { grid-template-columns: 1fr; }
            .container { padding: 12px; }
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: var(--bg-input); }
        ::-webkit-scrollbar-thumb { background: var(--border-color); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--accent); }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
    <div class="container">
        <a href="{{ route('approvals.index') }}" class="navbar-brand">
            <i class="fas fa-clipboard-check"></i>
            Approval System
        </a>
        <div class="navbar-actions">
            <button class="theme-toggle" onclick="toggleTheme()" title="Toggle Theme">
                <i class="fas fa-moon" id="themeIcon"></i>
            </button>
            <a href="{{ route('approvals.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> New Request
            </a>
        </div>
    </div>
</nav>

<div class="container">

    <!-- Search Section -->
    <div class="search-section" id="searchSection">
        <div class="search-box">
            <input type="text" id="searchInput" placeholder="Search approvals by title, requester or description..." value="{{ $search }}">
            <i class="fas fa-search search-icon"></i>
            
            <!-- Suggestions Dropdown -->
            <div class="suggestions-dropdown" id="suggestionsDropdown">
                <!-- Live suggestions will appear here -->
            </div>
        </div>

        <!-- Search History -->
        @if(!empty($searchHistory))
        <div class="search-history" id="searchHistory">
            <span style="font-size:12px;color:var(--text-secondary);display:flex;align-items:center;gap:6px;">
                <i class="fas fa-clock"></i> Recent Searches:
            </span>
            @foreach($searchHistory as $history)
                <span class="history-tag" onclick="applySearch('{{ $history }}')">
                    <i class="fas fa-search" style="font-size:10px;"></i>
                    {{ $history }}
                    <span class="remove-history" onclick="event.stopPropagation(); removeHistory('{{ $history }}')">
                        <i class="fas fa-times"></i>
                    </span>
                </span>
            @endforeach
            <span class="history-tag" onclick="clearHistory()" style="color:var(--danger);border-color:rgba(239,68,68,0.3);">
                <i class="fas fa-trash-alt" style="font-size:10px;"></i> Clear All
            </span>
        </div>
        @endif
    </div>

    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Total Requests</div>
            <div class="stat-value total">{{ $approvals->total() }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Pending</div>
            <div class="stat-value pending">{{ $approvals->where('status', 'pending')->count() }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Approved</div>
            <div class="stat-value approved">{{ $approvals->where('status', 'approved')->count() }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Rejected</div>
            <div class="stat-value rejected">{{ $approvals->where('status', 'rejected')->count() }}</div>
        </div>
    </div>

    <!-- Table -->
    <div class="table-wrapper">
        <div class="table-header">
            <h3><i class="fas fa-list"></i> All Requests</h3>
            <span style="font-size:13px;color:var(--text-secondary);">
                {{ $approvals->total() }} records found
            </span>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Requester</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @forelse($approvals as $approval)
                        <tr>
                            <td>{{ $approvals->firstItem() + $loop->index }}</td>
                            <td><strong>{{ $approval->title }}</strong></td>
                            <td>{{ $approval->requester }}</td>
                            <td>{{ Str::limit($approval->description, 40) }}</td>
                            <td>
                                <span class="status-badge {{ $approval->status }}">
                                    {{ ucfirst($approval->status) }}
                                </span>
                            </td>
                            <td style="font-size:12px;color:var(--text-secondary);">
                                {{ $approval->created_at->diffForHumans() }}
                            </td>
                            <td>
                                <div class="action-btns">
                                    @if($approval->status === 'pending')
                                        <a href="{{ route('approvals.approve', $approval->id) }}" 
                                           class="btn btn-success btn-sm"
                                           onclick="return confirm('Approve this request?')">
                                            <i class="fas fa-check"></i>
                                        </a>
                                        <a href="{{ route('approvals.reject', $approval->id) }}" 
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('Reject this request?')">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    @endif
                                    <form action="{{ route('approvals.destroy', $approval->id) }}" 
                                          method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" 
                                                onclick="return confirm('Delete this request?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="fas fa-inbox"></i>
                                    <p>No approval requests found</p>
                                    <a href="{{ route('approvals.create') }}" class="btn btn-primary" style="margin-top:12px;">
                                        <i class="fas fa-plus"></i> Create First Request
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($approvals->hasPages())
            <div class="pagination">
                {{ $approvals->appends(['search' => $search])->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Toast -->
<div id="toast" class="toast"></div>

<script>
    // ─── THEME ────────────────────────────────────────────────
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

    // Load saved theme
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

    // ─── LIVE SEARCH ──────────────────────────────────────────
    const searchInput = document.getElementById('searchInput');
    const suggestionsDropdown = document.getElementById('suggestionsDropdown');
    let searchTimeout;

    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const query = this.value.trim();
        
        if (query.length < 1) {
            suggestionsDropdown.classList.remove('show');
            return;
        }

        searchTimeout = setTimeout(() => {
            fetchSuggestions(query);
        }, 300);
    });

    // Close suggestions on click outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.search-box')) {
            suggestionsDropdown.classList.remove('show');
        }
    });

    function fetchSuggestions(query) {
        fetch(`{{ route('approvals.suggestions') }}?query=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                if (data.length === 0) {
                    suggestionsDropdown.innerHTML = `
                        <div style="padding:16px;text-align:center;color:var(--text-secondary);">
                            <i class="fas fa-search"></i> No suggestions found
                        </div>
                    `;
                    suggestionsDropdown.classList.add('show');
                    return;
                }

                let html = '';
                data.forEach(item => {
                    const statusClass = item.status || 'pending';
                    html += `
                        <div class="suggestion-item" onclick="applySearch('${item.title}')">
                            <i class="fas fa-file-alt" style="color:var(--accent);"></i>
                            <span class="s-title">${item.title}</span>
                            <span class="s-meta">
                                <span class="s-badge ${statusClass}">${item.status || 'pending'}</span>
                                ${item.requester ? ` • ${item.requester}` : ''}
                            </span>
                        </div>
                    `;
                });
                
                // Add "View all results" option
                html += `
                    <div class="suggestion-item" onclick="applySearch('${query}')" style="border-bottom:none;background:var(--accent);color:white;">
                        <i class="fas fa-arrow-right"></i>
                        <span>View all results for "${query}"</span>
                    </div>
                `;

                suggestionsDropdown.innerHTML = html;
                suggestionsDropdown.classList.add('show');
            })
            .catch(() => {
                suggestionsDropdown.classList.remove('show');
            });
    }

    function applySearch(query) {
        searchInput.value = query;
        suggestionsDropdown.classList.remove('show');
        window.location.href = `{{ route('approvals.index') }}?search=${encodeURIComponent(query)}`;
    }

    // ─── SEARCH HISTORY ──────────────────────────────────────
    function removeHistory(query) {
        fetch(`{{ route('approvals.suggestions') }}?query=${encodeURIComponent(query)}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        }).catch(() => {});
        
        // Remove from UI
        const tags = document.querySelectorAll('.history-tag');
        tags.forEach(tag => {
            if (tag.textContent.trim() === query) {
                tag.remove();
            }
        });
        
        // If no history left, reload
        if (document.querySelectorAll('.history-tag').length <= 1) {
            location.reload();
        }
    }

    function clearHistory() {
        if (confirm('Clear all search history?')) {
            // We'll just reload and session will be cleared via controller
            // For now, just reload
            location.href = `{{ route('approvals.index') }}`;
        }
    }

    // ─── TOAST ─────────────────────────────────────────────────
    function showToast(message, type = 'success') {
        const toast = document.getElementById('toast');
        toast.textContent = message;
        toast.className = `toast ${type}`;
        toast.style.display = 'block';
        setTimeout(() => {
            toast.style.display = 'none';
        }, 3000);
    }

    // Show flash messages from session
    @if(session('success'))
        showToast('{{ session('success') }}', 'success');
    @endif

    @if(session('error'))
        showToast('{{ session('error') }}', 'error');
    @endif

    // ─── ENTER KEY SEARCH ─────────────────────────────────────
    searchInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            suggestionsDropdown.classList.remove('show');
            window.location.href = `{{ route('approvals.index') }}?search=${encodeURIComponent(this.value.trim())}`;
        }
    });

    // ─── KEYBOARD SHORTCUT ────────────────────────────────────
    document.addEventListener('keydown', function(e) {
        // Ctrl+K or Cmd+K to focus search
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            searchInput.focus();
            searchInput.select();
        }
        
        // Escape to close suggestions
        if (e.key === 'Escape') {
            suggestionsDropdown.classList.remove('show');
        }
    });

    // Show search history on focus if input is empty
    searchInput.addEventListener('focus', function() {
        if (this.value.trim() === '' && {{ $approvals->total() }} > 0) {
            // Show recent searches from history tags
            const historyTags = document.querySelectorAll('.history-tag:not(:last-child)');
            if (historyTags.length > 0) {
                let html = '';
                historyTags.forEach(tag => {
                    const text = tag.textContent.trim();
                    html += `
                        <div class="suggestion-item" onclick="applySearch('${text}')">
                            <i class="fas fa-clock" style="color:var(--text-secondary);"></i>
                            <span class="s-title">${text}</span>
                            <span class="s-meta" style="font-size:11px;color:var(--text-secondary);">recent</span>
                        </div>
                    `;
                });
                suggestionsDropdown.innerHTML = html;
                suggestionsDropdown.classList.add('show');
            }
        }
    });
</script>

</body>
</html>