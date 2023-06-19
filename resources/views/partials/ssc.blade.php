 {{--? Start Judul Atas --}}
 <div class="row mt-3">
    <div class="col-lg-7">
        <div class="top-title">
            <h2 class="">{{$device_name}}</h2>
            <p>Have a nice day</p>
        </div>
    </div>
    <script>
        // Fungsi untuk mengubah kelas tombol berdasarkan halaman yang sedang dimuat
        function setButtonClass() {
            var countdownButton = document.getElementById('countdown');
            var scheduleButton = document.getElementById('schedule');
            var statusButton = document.getElementById('status');
    
            var currentPath = window.location.pathname; // Mendapatkan path halaman yang sedang dimuat
    
            // Mengatur kelas tombol berdasarkan halaman yang sedang dimuat
            if (currentPath.includes('/timers')) {
                countdownButton.className = 'kanan btn btn-secondary me-2';
                scheduleButton.className = 'kanan btn btn-outline-success me-2';
                statusButton.className = 'kanan btn btn-outline-primary me-2';
            } else if (currentPath.includes('/manage-schedule')) {
                countdownButton.className = 'kanan btn btn-outline-secondary me-2';
                scheduleButton.className = 'kanan btn btn-success me-2';
                statusButton.className = 'kanan btn btn-outline-primary me-2';
            } else if (currentPath.includes('/manage-status')) {
                countdownButton.className = 'kanan btn btn-outline-secondary me-2';
                scheduleButton.className = 'kanan btn btn-outline-success me-2';
                statusButton.className = 'kanan btn btn-primary me-2';
            }
        }
    
        // Memanggil fungsi setButtonClass saat halaman selesai dimuat
        document.addEventListener('DOMContentLoaded', setButtonClass);
    </script>
    
    
    <div class="col-lg-5 mt-3">
        <a href="/timers/{{$device_id}}">
            <button id="countdown" type="button" class="kanan btn btn-outline-secondary me-2">Countdown</button>
        </a>
        <a href="/manage-schedule/{{$device_id}}">
            <button id="schedule" type="button" class="kanan btn btn-outline-success me-2">Schedule</button>
        </a>
        <a href="/manage-status/{{$device_id}}">
            <button id="status" type="button" class="kanan btn btn-outline-primary me-2">Status</button>
        </a>
    </div>
    
    
</div>
{{--? End Judul Atas --}}