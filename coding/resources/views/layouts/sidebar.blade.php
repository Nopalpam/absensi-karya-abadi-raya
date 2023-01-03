<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ url(auth()->user()->foto ?? '') }}" class="img-circle img-profil" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ auth()->user()->name }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li>
                <a href="{{ route('dashboard') }}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            @if (auth()->user()->level == 'admin')
            <li class="header">MASTER</li>
            <li>
                <a href="{{ route('user.index') }}">
                    <i class="fa fa-users"></i> <span>Pengguna</span>
                </a>
            </li>
            <li>
                <a href="{{ route('area.index') }}">
                    <i class="fa fas fa-address-book"></i> <span>Data Area</span>
                </a>
            </li>
            <li>
                <a href="{{ route('jadwal.index') }}">
                    <i class="fa fas fa-address-book"></i> <span>Jadwal Area Karyawan</span>
                </a>
            </li>
            <li>
                <a href="{{ route('sik_karyawan') }}">
                    <i class="fa fas fa-address-book"></i> <span>Sakit/Ijin/Cuti</span>
                </a>
            </li>
            <li>
                <a href="{{ route('rekap_absen.index') }}">
                    <i class="fa fas fa-address-book"></i> <span>Rekap Absen</span>
                </a>
            </li>
            <li>
                <a href="{{ route('rekap_absen.bulanan') }}">
                    <i class="fa fas fa-address-book"></i> <span>Rekap Absen Bulanan</span>
                </a>
            </li>
            <li>
                <a href="{{ route('dealer.index') }}">
                    <i class="fa fas fa-address-book"></i> <span>Customer</span>
                </a>
            </li>
            <li>
                <a href="{{ route('jenis_pekerjaan.index') }}">
                    <i class="fa fas fa-address-book"></i> <span>Jenis Pekerjaan</span>
                </a>
            </li>
            <li class="header">SYSTEM</li>
            <li>
                <a href="{{ route('setting.index') }}">
                    <i class="fa fa-cogs"></i> <span>Pengaturan</span>
                </a>
            </li>
            @elseif (auth()->user()->level == 'karyawan')
            <li class="treeview">
                <a href="#">
                    <i class="fa fas fa-address-book"></i> <span>Absensi</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="{{ route('karyawan_area') }}">
                            <i class="fa fas fa-arrow-right"></i> <span>Jadwal Area</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('check_in') }}">
                            <i class="fa fa-long-arrow-right"></i> <span>Check IN</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('check_out') }}">
                            <i class="fa fa-long-arrow-right"></i> <span>Check OUT</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('sik.index') }}">
                            <i class="fa fa-long-arrow-right"></i> <span>Sakit/Ijin/Cuti</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('absensi_karyawan') }}">
                            <i class="fa fas fa-address-book"></i> <span>Data Absen</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('rekap_karyawan') }}">
                            <i class="fa fas fa-address-book"></i> <span>Rekap Absen Bulanan</span>
                        </a>
                    </li>
                </ul>
            </li>
            @else
            @endif
            <li class="header">Customer</li>
            <li>
                <a href="{{ route('transaksi_service.index') }}">
                    <i class="fa fas fa-address-book"></i> <span>Transaksi Service</span>
                </a>
            </li>
            @if(auth()->user()->level == 'admin' || auth()->user()->level == 'admininvoice')
            <li class="header">INVOICE MENU</li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fas fa-address-book"></i> <span>INVOICE</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="{{ route('invoice.index') }}">
                            <i class="fa fas fa-address-book"></i> <span>List invoice</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('settlement.index') }}">
                            <i class="fa fas fa-address-book"></i> <span>Settlement</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
