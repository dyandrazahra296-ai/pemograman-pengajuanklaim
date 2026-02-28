<nav class="navbar bg-white border-bottom px-4 d-flex justify-content-between">
    <h5 class="mb-0">Dashboard</h5>

    <div class="dropdown">
        <button
            type="button"
            class="btn d-flex align-items-center gap-2"
            data-bs-toggle="dropdown"
            aria-expanded="false"
        >
            <div class="avatar-circle">A</div>
            <div class="text-start">
                <div class="fw-bold">Administrator</div>
                <small class="text-muted">Admin</small>
            </div>
        </button>

        <ul class="dropdown-menu dropdown-menu-end shadow">
            <li>
                <a class="dropdown-item" href="/profile">
                    👤 My Profile
                </a>
            </li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li>
                <a class="dropdown-item text-danger" href="/logout">
                    🚪 Logout
                </a>
            </li>
        </ul>
    </div>
</nav>
