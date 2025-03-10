<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/backoffice/dashboard" class="brand-link">
        <div class="d-flex ">
            <div class="">
                <img src="{{ asset('images/backoffice/lpsk.png') }}" alt="AdminLTE Logo" class="brand-image"
                    style="opacity: .8; width: 100%">
            </div>
            {{-- <div class="ml-2">
                <span class="brand-text" style="text-transform: uppercase"> <b></b> </span>
            </div> --}}
        </div>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 mb-3 text-center">

            <div class="info">
                <p style="text-transform: uppercase">
                    <b>{{ auth()->user()->role->name }}</b>
                </p>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a href="/backoffice/dashboard"
                        class="nav-link {{ request()->is('backoffice/dashboard', 'backoffice/dashboard/*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-home"></i>
                        <p>
                            Beranda
                        </p>
                    </a>
                </li>

                @if (auth()->user()->role_id == 1)
                    <li class="nav-item">
                        <a href="/backoffice/application"
                            class="nav-link {{ request()->is('backoffice/application', 'backoffice/application/*') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-desktop"></i>
                            <p>
                                Aplikasi
                            </p>
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a href="/backoffice/service"
                            class="nav-link {{ request()->is('backoffice/service', 'backoffice/service/*') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-handshake"></i>
                            <p>
                                Layanan
                            </p>
                        </a>
                    </li> --}}
                    <li class="nav-item">
                        <a href="/backoffice/profile"
                            class="nav-link {{ request()->is('backoffice/profile', 'backoffice/profile/*') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-user"></i>
                            <p>
                                Profil
                            </p>
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a href="/backoffice/roadmap"
                            class="nav-link {{ request()->is('backoffice/roadmap', 'backoffice/roadmap/*') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-road"></i>
                            <p>
                                Peta Jalan
                            </p>
                        </a>
                    </li> --}}
                    <li class="nav-item">
                        <a href="/backoffice/highlight"
                            class="nav-link {{ request()->is('backoffice/highlight', 'backoffice/highlight/*') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-chalkboard"></i>
                            <p>
                                Sorot
                            </p>
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a href="/backoffice/report"
                            class="nav-link {{ request()->is('backoffice/report', 'backoffice/report/*') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-clipboard"></i>
                            <p>
                                Laporan
                            </p>
                        </a>
                    </li> --}}
                    {{-- <li class="nav-item">
                        <a href="/backoffice/setting"
                            class="nav-link {{ request()->is('backoffice/setting', 'backoffice/setting/*') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-gear"></i>
                            <p>
                                Peraturan
                            </p>
                        </a>
                    </li> --}}
                @endif

                @if (auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
                    <li class="nav-item">
                        <a href="/backoffice/publication"
                            class="nav-link {{ request()->is('backoffice/publication', 'backoffice/publication/*') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-edit"></i>
                            <p>
                                Publikasi
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/backoffice/news"
                            class="nav-link {{ request()->is('backoffice/news', 'backoffice/news/*') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-newspaper"></i>
                            <p>
                                Berita
                            </p>
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a href="/backoffice/information"
                            class="nav-link {{ request()->is('backoffice/information', 'backoffice/information/*') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-circle-info"></i>
                            <p>
                                Informasi
                            </p>
                        </a>
                    </li> --}}
                @endif

                @if (auth()->user()->role_id == 1)
                    <li class="nav-header">DATA MASTER</li>
                    <li class="nav-item has-treeview {{ request()->is('backoffice/user-data/*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('backoffice/user-data/*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chalkboard-user"></i>
                            <p>
                                Data Pengguna
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/backoffice/user-data/role"
                                    class="nav-link {{ request()->is('backoffice/user-data/role', 'backoffice/user-data/role/*') ? 'active' : '' }}">
                                    <i class="fa fa-circle fa-regular nav-icon"></i>
                                    <p>Peran</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/backoffice/user-data/user"
                                    class="nav-link {{ request()->is('backoffice/user-data/user', 'backoffice/user-data/user/*') ? 'active' : '' }}">
                                    <i class="fa fa-circle fa-regular nav-icon"></i>
                                    <p>Pengguna</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview {{ request()->is('backoffice/category-data/*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('backoffice/category-data/*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-list"></i>
                            <p>
                                Data Kategori
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/backoffice/category-data/application"
                                    class="nav-link {{ request()->is('backoffice/category-data/application', 'backoffice/category-data/application/*') ? 'active' : '' }}">
                                    <i class="fa fa-circle fa-regular nav-icon"></i>
                                    <p>Aplikasi</p>
                                </a>
                            </li>
                            {{-- <li class="nav-item">
                                <a href="/backoffice/category-data/service"
                                    class="nav-link {{ request()->is('backoffice/category-data/service', 'backoffice/category-data/service/*') ? 'active' : '' }}">
                                    <i class="fa fa-circle fa-regular nav-icon"></i>
                                    <p>Layanan</p>
                                </a>
                            </li> --}}
                            {{-- <li class="nav-item">
                                <a href="/backoffice/category-data/profile"
                                    class="nav-link {{ request()->is('backoffice/category-data/profile', 'backoffice/category-data/profile/*') ? 'active' : '' }}">
                                    <i class="fa fa-circle fa-regular nav-icon"></i>
                                    <p>Profil</p>
                                </a>
                            </li> --}}
                            <li class="nav-item">
                                <a href="/backoffice/category-data/publication"
                                    class="nav-link {{ request()->is('backoffice/category-data/publication', 'backoffice/category-data/publication/*') ? 'active' : '' }}">
                                    <i class="fa fa-circle fa-regular nav-icon"></i>
                                    <p>Publikasi</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/backoffice/category-data/news"
                                    class="nav-link {{ request()->is('backoffice/category-data/news', 'backoffice/category-data/news/*') ? 'active' : '' }}">
                                    <i class="fa fa-circle fa-regular nav-icon"></i>
                                    <p>Berita</p>
                                </a>
                            </li>
                            {{-- <li class="nav-item">
                                <a href="/backoffice/category-data/information"
                                    class="nav-link {{ request()->is('backoffice/category-data/information', 'backoffice/category-data/information/*') ? 'active' : '' }}">
                                    <i class="fa fa-circle fa-regular nav-icon"></i>
                                    <p>Informasi</p>
                                </a>
                            </li> --}}
                            <li class="nav-item">
                                <a href="/backoffice/category-data/highlight"
                                    class="nav-link {{ request()->is('backoffice/category-data/highlight', 'backoffice/category-data/highlight/*') ? 'active' : '' }}">
                                    <i class="fa fa-circle fa-regular nav-icon"></i>
                                    <p>Sorot</p>
                                </a>
                            </li>
                            {{-- <li class="nav-item">
                                <a href="/backoffice/category-data/setting"
                                    class="nav-link {{ request()->is('backoffice/category-data/setting', 'backoffice/category-data/setting/*') ? 'active' : '' }}">
                                    <i class="fa fa-circle fa-regular nav-icon"></i>
                                    <p>Peraturan</p>
                                </a>
                            </li> --}}
                        </ul>
                    </li>
                @endif

            </ul>
        </nav>
        
    </div>
    
</aside>
