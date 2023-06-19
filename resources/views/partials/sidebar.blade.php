{{--? Start Sidebar --}}

<div class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
    <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand m-0" href="/">
        <img src="{{'/assets/img/logo-ct-dark.png'}}" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold">Monitoring</span>
    </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
            <a class="nav-link" href="/" id="dashboard-link">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Dashboard</span>
            </a>
            </li>
            
            <li class="nav-item">
            <a class="nav-link " href="/alldevice" id="manage-device-link">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Manage Device</span>
            </a>
            </li>
            
            <li class="nav-item">
            <a class="nav-link " href="/analyze" id="analyze-link">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                <i class="ni ni-credit-card text-success text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Analyze</span>
            </a>
            </li>
            
            <hr class="horizontal dark">
            <li class="nav-item">
                <a class="nav-link" href="/sesi/logout" id="logout-link">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-credit-card text-success text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Logout</span>
                </a>
            </li>
            
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Mendapatkan path halaman yang sedang dimuat
                    var currentPath = window.location.pathname;
            
                    // Mendapatkan elemen-elemen menu
                    var dashboardLink = document.getElementById('dashboard-link');
                    var manageDeviceLink = document.getElementById('manage-device-link');
                    var analyzeLink = document.getElementById('analyze-link');
                    var logoutLink = document.getElementById('logout-link');
            
                    // Menghapus kelas 'active' dari semua elemen menu
                    dashboardLink.classList.remove('active');
                    manageDeviceLink.classList.remove('active');
                    analyzeLink.classList.remove('active');
                    logoutLink.classList.remove('active');
            
                    // Menambahkan kelas 'active' pada elemen menu yang sesuai dengan path halaman yang sedang dimuat
                    if (currentPath === '/') {
                        dashboardLink.classList.add('active');
                    } else if (currentPath.startsWith('/alldevice') || currentPath.startsWith('/manage-schedule') || currentPath.startsWith('/manage-status')) {
                        manageDeviceLink.classList.add('active');
                    } else if (currentPath.startsWith('/analyze')) {
                        analyzeLink.classList.add('active');
                    } else if (currentPath.startsWith('/sesi/logout')) {
                        logoutLink.classList.add('active');
                    }
                });
            </script>
            {{-- Logout --}}
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Mendapatkan elemen-elemen yang diperlukan
                    var logoutLink = document.getElementById('logout-link');
                    var sidenav = document.getElementById('sidenav-main');
            
                    // Menambahkan event listener saat logout link ditekan
                    logoutLink.addEventListener('click', function(e) {
                        e.preventDefault();
            
                        // Menonaktifkan sidenav saat SweetAlert ditampilkan
                        sidenav.classList.add('disabled');
            
                        // Menampilkan SweetAlert confirmation
                        Swal.fire({
                            title: 'Logout',
                            text: 'Are you sure you want to logout?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Logout',
                            cancelButtonText: 'Cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Redirect ke halaman logout jika user mengklik "Logout"
                                window.location.href = logoutLink.href;
                            } else {
                                // Mengaktifkan kembali sidenav setelah SweetAlert ditutup
                                sidenav.classList.remove('disabled');
                            }
                        });
                    });
                });
            </script>
            
        </ul>
    </div>
</div>



{{--? End Sidebar --}}