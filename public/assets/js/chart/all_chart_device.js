var updated_at = []; // Array untuk menyimpan label waktu
var updated_at_kwh = []; // Array untuk menyimpan label waktu
var power = []; // Array untuk menyimpan data power
var kwh = []; // Array untuk menyimpan label waktu


// Chart Power (ID)
var ctx1 = document.getElementById("all-power-chart").getContext("2d");
var ctx2 = document.getElementById("kwh_chart").getContext("2d");
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


var kwh_chart = new Chart(ctx2, {
  type: "line",
  data: {
    labels: [],
    datasets: [{
      label: "Rp",
      tension: 0.4,
      borderWidth: 0,
      pointRadius: 0,
      borderColor: "#5e72e4",
      backgroundColor: gradientStroke1,
      borderWidth: 3,
      fill: true,
      data: [],
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
        // reverse: true,
      }
    }
  }
});

// Fungsi untuk mengambil data dari server
function fetchDataPowerChart() {
  fetch('/analyze/get/allpowerchart')
    .then(response => response.json())
    .then(data => {
      // Mengurangi data jika ada data dengan variabel yang sama
      var reducedData = data.reduce((accumulator, current) => {
        var existingIndex = accumulator.findIndex(item => item.updated_at === current.updated_at);
        if (existingIndex !== -1) {
          accumulator[existingIndex].power += current.power;
        } else {
          accumulator.push(current);
        }
        return accumulator;
      }, []);

      // Memperbarui data grafik
      updated_at = reducedData.map(item => item.updated_at);
      power = reducedData.map(item => item.power);
      console.log(power);
      // Memperbarui data dan label pada grafik Chart.js
      chart.data.labels = updated_at;
      chart.data.datasets[0].data = power;
      // Memperbarui grafik
      chart.update();
    })
    .catch(error => {
      console.error('Error fetching data from server:', error);
    });
}

function fetchChartKwhCost() {
  fetch('/analyze/get/kwh')
    .then(response => response.json())
    .then(data => {
      const totalKwh = data.total_kwh;
      const created_at = data.created_at;

      kwh_chart.data.labels = created_at.slice(-6);
      kwh_chart.data.datasets[0].data = totalKwh;

      kwh_chart.update();
    })
    .catch(error => {
      console.error('Error fetching data from server:', error);
    });
}



fetchChartKwhCost();
fetchDataPowerChart();

// Perbarui data setiap detik menggunakan setInterval
setInterval(fetchChartKwhCost, 2000);
setInterval(fetchDataPowerChart, 2000);
