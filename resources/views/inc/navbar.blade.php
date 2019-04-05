<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-dark border-bottom" style="background-color:#3C8DBC">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
        </li>
        
    </ul><!-- SEARCH FORM -->
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#"><i class="fa fa-comments-o"></i> <span class="badge badge-danger navbar-badge">3</span></a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a class="dropdown-item" href="#"><!-- Message Start -->
                <div class="media">
                    <img alt="User Avatar" class="img-size-50 mr-3 img-circle" src="../dist/img/user1-128x128.jpg">
                    <div class="media-body">
                        <h3 class="dropdown-item-title">Brad Diesel <span class="float-right text-sm text-danger"><i class="fa fa-star"></i></span></h3>
                        <p class="text-sm">Call me whenever you can...</p>
                        <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> 4 Hours Ago</p>
                    </div>
                </div><!-- Message End --></a>
                <div class="dropdown-divider"></div><a class="dropdown-item" href="#"><!-- Message Start -->
                <div class="media">
                    <img alt="User Avatar" class="img-size-50 img-circle mr-3" src="../dist/img/user8-128x128.jpg">
                    <div class="media-body">
                        <h3 class="dropdown-item-title">John Pierce <span class="float-right text-sm text-muted"><i class="fa fa-star"></i></span></h3>
                        <p class="text-sm">I got your message bro</p>
                        <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> 4 Hours Ago</p>
                    </div>
                </div><!-- Message End --></a>
                <div class="dropdown-divider"></div><a class="dropdown-item" href="#"><!-- Message Start -->
                <div class="media">
                    <img alt="User Avatar" class="img-size-50 img-circle mr-3" src="../dist/img/user3-128x128.jpg">
                    <div class="media-body">
                        <h3 class="dropdown-item-title">Nora Silvester <span class="float-right text-sm text-warning"><i class="fa fa-star"></i></span></h3>
                        <p class="text-sm">The subject goes here</p>
                        <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> 4 Hours Ago</p>
                    </div>
                </div><!-- Message End --></a>
                <div class="dropdown-divider"></div><a class="dropdown-item dropdown-footer" href="#">See All Messages</a>
            </div>
        </li><!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#"><i class="fa fa-bell-o"></i> <span class="badge badge-warning navbar-badge">15</span></a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">15 Notifications</span>
                <div class="dropdown-divider"></div><a class="dropdown-item" href="#"><i class="fa fa-envelope mr-2"></i> 4 new messages <span class="float-right text-muted text-sm">3 mins</span></a>
                <div class="dropdown-divider"></div><a class="dropdown-item" href="#"><i class="fa fa-users mr-2"></i> 8 friend requests <span class="float-right text-muted text-sm">12 hours</span></a>
                <div class="dropdown-divider"></div><a class="dropdown-item" href="#"><i class="fa fa-file mr-2"></i> 3 new reports <span class="float-right text-muted text-sm">2 days</span></a>
                <div class="dropdown-divider"></div><a class="dropdown-item dropdown-footer" href="#">See All Notifications</a>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                {{ Auth::user()->name }} <span class="caret"></span>
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>       
    </ul>
</nav><!-- /.navbar -->