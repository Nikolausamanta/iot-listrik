var updated_at = []; // Array untuk menyimpan label waktu
    var power = []; // Array untuk menyimpan data power

    // Inisialisasi grafik
    var ctx1 = document.getElementById("power-chart").getContext("2d");
    var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

    gradientStroke1.addColorStop(1, 'rgba(94, 114, 228, 0.2)');
    gradientStroke1.addColorStop(0.2, 'rgba(94, 114, 228, 0.0)');
    gradientStroke1.addColorStop(0, 'rgba(94, 114, 228, 0)');
    
    var chart = new Chart(ctx1, {
      type: "line",
      data: {
        labels: updated_at,
        datasets: [{
          label: "Power",
          tension: 0.4,
          borderWidth: 0,
          pointRadius: 0,
          borderColor: "#5e72e4",
          backgroundColor: gradientStroke1,
          borderWidth: 3,
          fill: true,
          data: power,
          maxBarThickness: 6
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false
          }
        },
        interaction: {
          intersect: false,
          mode: 'index'
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              padding: 10,
              color: '#ccc',
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              }
            }
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
                
              display: true,
              color: '#ccc',
              padding: 20,
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              }
            },
            reverse: true,
          }
        }
      }
    });

    // Fungsi untuk mengambil data dari server
    function fetchDataPowerChart() {
      fetch('/manage-status/get/powerchart')
        .then(response => response.json())
        .then(data => {
            console.log(data)
          // Perbarui data grafik
          updated_at = data.map(item => item.updated_at);
          power = data.map(item => item.power);

          // Perbarui data dan label pada grafik Chart.js
          chart.data.labels = updated_at;
          chart.data.datasets[0].data = power;
          // Perbarui grafik
          chart.update();
        })
        .catch(error => {
            console.error('Error fetching data from server:', error);
        });
    }

    function fetchCardSensor() {
        fetch('/manage-status/get/cardsensor')
        .then(response => response.json())
        .then(data => {
            console.log(data)
            document.getElementById('voltage').textContent = data.voltage || 'N/A';
            document.getElementById('current').textContent = data.current || 'N/A';
            document.getElementById('power').textContent = data.power || 'N/A';
            document.getElementById('energy').textContent = data.energy || 'N/A';
            document.getElementById('frequency').textContent = data.frequency || 'N/A';
            document.getElementById('powerfactor').textContent = data.powerfactor || 'N/A';
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
      }

    // Ambil data pertama kali saat halaman dimuat
    fetchCardSensor();
    fetchDataPowerChart();

    // Perbarui data setiap detik menggunakan setInterval
    setInterval(fetchCardSensor, 2000);
    setInterval(fetchDataPowerChart, 2000);



    

    