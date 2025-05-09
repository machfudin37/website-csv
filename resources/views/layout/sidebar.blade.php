@section('sidebar')
    <section class="sidebar hide">
        <a href="{{ route('dasboard') }}" class="logo">
            <i><img src="{{ asset('assets/img/logos/lambang.png') }}" class="logokominfotik" alt="logo" width="24px"
                    height="24px" /></i>
            <span class="text">Kominfotik</span>
        </a>

        <ul class="side-menu top">  
            <li>
                <a href="{{ route('dasboard') }}" class="nav-link">
                    <i class="fas fa-home"></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            @if (auth()->user()->role === 'admin')
                <li>
                    <a href="{{ route('daerah.index') }}" class="nav-link">
                        <i class="far fa-map"></i>
                        <span class="text">Daerah</span>
                    </a>
                </li>
            @endif
            <li>
                <a href="{{ route('penyakit') }}" class="nav-link">
                    <i class="fas fa-book-medical"></i>
                    <span class="text">Form Penyakit</span>
                </a>
            </li>
            <li>
                <a href="{{ route('tanaman') }}" class="nav-link">
                    <i class="fas fa-tree"></i>
                    <span class="text">Form Tanaman</span>
                </a>
            </li>
            <li>
                <a href="{{ route('chartpenyakit') }}" class="nav-link">
                    <i class="fas fa-chart-area"></i>
                    <span class="text">Chart Penyakit</span>
                </a>
            </li>
            <li>
                <a href="{{ route('charttanaman') }}" class="nav-link">
                    <i class="fas fa-chart-bar"></i>
                    <span class="text">Chart Tanaman</span>
                </a>
            </li>
            <li>
                <a href="{{ route('actionlogout') }}" class="logout">
                    <i class="fas fa-right-from-bracket"></i>
                    <span class="text">Logout</span>
                </a>
            </li>
        </ul>
    </section>
@endsection
