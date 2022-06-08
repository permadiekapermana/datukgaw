<nav class="sidebar">
<div class="sidebar-header">
    <a href="#" class="sidebar-brand">
    <h6>DATUKGAW</h6>
    </a>
    <div class="sidebar-toggler not-active">
    <span></span>
    <span></span>
    <span></span>
    </div>
</div>
<div class="sidebar-body">
    <ul class="nav">
    
    @if(session('role') == 'admin' || session('role') == 'staff')
    <li class="nav-item nav-category">Main</li>
    <li class="nav-item">
        <a href="/cms/dashboard" class="nav-link">
        <i class="link-icon" data-feather="home"></i>
        <span class="link-title">Dashboard</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="/cms/keuangan" class="nav-link">
        <i class="link-icon" data-feather="dollar-sign"></i>
        <span class="link-title">Keuangan</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="#" class="nav-link">
        <i class="link-icon" data-feather="package"></i>
        <span class="link-title">BMN</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="#" class="nav-link">
        <i class="link-icon" data-feather="book-open"></i>
        <span class="link-title">SAIBA</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="#" class="nav-link">
        <i class="link-icon" data-feather="user-check"></i>
        <span class="link-title">Kepegawaian</span>
        </a>
    </li>
    @endif

    @if(session('role') == 'admin')
    <li class="nav-item nav-category">SYSTEM</li>
    <li class="nav-item">
        <a href="/cms/users" class="nav-link">
        <i class="link-icon" data-feather="users"></i>
        <span class="link-title">Users</span>
        </a>
    </li>
    @endif

    </ul>
</div>
</nav>