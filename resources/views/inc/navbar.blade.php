<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-light border-bottom" id="navbar">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
        </li>
        
    </ul><!-- SEARCH FORM -->
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!--Check if the User is Employee-->
        @if(Auth()->user()->user_type_id == 4)
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" id="announcement"><i class="fa fa-bullhorn"></i> <span class="badge badge-danger navbar-badge" id="notif"></span></a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="announcementdesc">
                <a class="dropdown-item" href="#"><!-- Message Start -->
                    <div class="dropdown-divider"></div><a class="dropdown-item dropdown-footer" href="#">No Announcement</a>
            </div>
        </li>
        @endif
        <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                {{ Auth::user()->name }} <span class="caret"></span>
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                    <i class="icon ion-md-log-out"></i>
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>       
    </ul>
</nav><!-- /.navbar -->