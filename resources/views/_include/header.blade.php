<header class="header">
    <div class="container cf">
        <a href="{{ route('home') }}">
            <img class="header-logo" src="{{ asset('assets/img/logo-header.png') }}" alt="">
        </a>
        
        <ul class="header-list cf">
            <li>
                <a class="notif text-grey" href="#">
                    <div class="notif__icon">
                        <span class="fa fa-bell"></span>
                    </div>
                    <span class="notif__count">2</span>
                </a>
                <div class="dropdown-menu notif-list">
                    <!-- empty state -->
                    <!-- <span class="empty-state">You have no notification.</span> -->
                    <a href="#">
                        Testing #20 on Suitcoda Project has done tested.
                    </a>
                    <a href="#">
                        Testing #20 on Suitcoda Project has done tested.
                    </a>
                    <a href="#">
                        Testing #20 on Suitcoda Project has done tested.
                    </a>
                    <a class="more" href="notification.php">
                        <b>See More</b>
                    </a>
                </div>
            </li>
            @if (!is_null($user))
            <li>
                <a class="user-avatar" href="#">
                    <span>{{ $user->getInitials() }}</span>
                </a>
                <div class="dropdown-menu user-menu">
                @if ($user->isAdmin())
                    <a href="{{ route('user.index') }}">Manage Account</a>
                @endif
                    <a href="{{ action('Auth\AuthController@getLogout') }}">Logout</a>
                </div>
            </li>
            @endif
        </ul>
    </div>
</header>