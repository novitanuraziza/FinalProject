<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">
                    {{ Auth::user()->unreadNotifications->count() }}
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">
                    {{ Auth::user()->unreadNotifications->count() }} Notifications
                </span>
                <div class="dropdown-divider"></div>
                @foreach (Auth::user()->notifications as $notification)
                    @if ($notification->read_at == null)
                        <form action="{{ route('admin.markNotification', $notification->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="fas fa-info-circle mr-2"></i>{{ $notification->data['message'] }}
                                <span
                                    class="float-right text-muted text-sm">{{ $notification->created_at->diffForHumans() }}</span>
                            </button>
                        </form>
                    @endif
                    @if ($loop->last)
                        <div class="dropdown-divider"></div>
                        <form action="{{ route('admin.markAllRead') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item dropdown-footer">Mark as Read</button>
                        </form>
                    @endif
                @endforeach
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
    </ul>
</nav>
