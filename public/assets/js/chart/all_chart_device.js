var updated_at = []; 
var power = [];

var device_name = [];
var total_kwh_perdevice = [];

// Chart Power (ID)
var ctx1 = document.getElementById("all-power-chart").getContext("2d");
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
      borderColor: "#3A416F",
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
        offset: true, // Mengaktifkan offset pada skala sumbu Y
            suggestedMin: Math.min(...power) - 2, // Atur tinggi minimal (minimum height) berdasarkan data power
            suggestedMax: Math.max(...power) + 2, // Atur tinggi maksimal (maximum height) berdasarkan data power
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

// Bar chart horizontal
var ctx6 = document.getElementById("bar-chart-horizontal").getContext("2d");
var kwh_chart_perdevice = new Chart(ctx6, {
  type: "bar",
  data: {
    labels: device_name,
    datasets: [{
      label: "Device",
      weight: 5,
      borderWidth: 0,
      borderRadius: 4,
      backgroundColor: '#3A416F',
      data: total_kwh_perdevice,
      fill: false,
      barPercentage: 0.45, // Atur lebar maksimum batang (0.8 = 80% dari lebar yang tersedia)
    }],
  },
  options: {
    indexAxis: 'y',
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        display: false,
      },
      datalabels: {
        anchor: 'end',
        align: 'end',
        offset: 8, // Adjust the offset to add spacing between the bar and the data labels
        color: '#9ca2b7', // Set the text color to match the axis labels
        font: {
          size: 12, // Set the font size to match the axis labels
          weight: 'normal' // Set the font weight to match the axis labels
        },
        formatter: function(value) {
          return value + ' kWh'; // Append ' kWh' to the label value
        },
        display: function(context) {
          return context.dataset.data[context.dataIndex] > 0; // Display labels only for positive values
        }
      }
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
          color: '#9ca2b7'
        }
      },
      x: {
        grid: {
          drawBorder: false,
          display: false,
          drawOnChartArea: true,
          drawTicks: true,
        },
        ticks: {
          display: true,
          color: '#9ca2b7',
          padding: 10
        }
      },
    },
  },
  plugins: [ChartDataLabels] // Enable the datalabels plugin
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
      updated_at = reducedData.map(item => {
        var dateTime = new Date(item.updated_at);
        var hour = dateTime.getHours().toString().padStart(2, '0');
        var minute = dateTime.getMinutes().toString().padStart(2, '0');
        var second = dateTime.getSeconds().toString().padStart(2, '0');
        return hour + ':' + minute + ':' + second;
      });
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


// Fungsi untuk mengambil data dari server
function fetchDataKwhPerDevice() {
  fetch('/analyze/get/kwhmonth')
    .then(response => response.json())
    .then(data => {
      // Perbarui data grafik
      device_name = data.map(item => item.device_name);
      total_kwh_perdevice = data.map(item => item.total_kwh_perdevice);
      console.log(data)

      // Perbarui data dan label pada grafik Chart.js
      kwh_chart_perdevice.data.labels = device_name;
      kwh_chart_perdevice.data.datasets[0].data = total_kwh_perdevice;
      // Perbarui grafik
      kwh_chart_perdevice.update();
    })
    .catch(error => {
        console.error('Error fetching data from server:', error);
    });
}

fetchDataPowerChart();
fetchDataKwhPerDevice();

setInterval(fetchDataPowerChart, 2000);


$(document).ready(function() {
  var select = $('#tahun-select');
  var currentYear = new Date().getFullYear();
  var monthlyData = []; // Menyimpan data bulanan dari server

  function fetchData() {
      $.ajax({
          url: '/analyze/get/forecast',
          method: 'GET',
          success: function(response) {
              monthlyData = response;

              var availableYears = [];
              for (var i = 0; i < monthlyData.length; i++) {
                  availableYears.push(monthlyData[i].year);
              }
              availableYears = [...new Set(availableYears)];

              select.empty();
              for (var j = 0; j < availableYears.length; j++) {
                  var option = $('<option>', {
                      value: availableYears[j],
                      text: availableYears[j]
                  });
                  select.append(option);
              }

              select.val(currentYear);
              var selectedYear = select.val();
              var selectedData = getSelectedYearData(selectedYear);

              drawChart(selectedData);
          },
          error: function(xhr, status, error) {
              console.error(error);
          }
      });
  }

  function getSelectedYearData(selectedYear) {
      return monthlyData.filter(function(data) {
          return data.year == selectedYear;
      });
  }

  function drawChart(monthlyData) {
      var labels = [];
      var actualData = [];
      var predictedData = [];

      var selectedYear = select.val(); // Ambil tahun yang dipilih dari elemen <select>
      var isFirstYear = isFirstSelectedYear(selectedYear);
      var isLastYear = isLastSelectedYear(selectedYear);

      for (var i = 0; i < monthlyData.length; i++) {
          labels.push(monthlyData[i].month);
          actualData.push(monthlyData[i].actual);

          if (isFirstYear && i === 0) {
              predictedData.push(null); // Data pertama pada tahun pertama menjadi null
          } else {
              predictedData.push(monthlyData[i].predicted);
          }

          if (isLastYear && i === monthlyData.length - 1) {
              predictedData.push(null); // Data terakhir pada tahun terakhir menjadi null
          }
      }

      var ctx = document.getElementById('prediction-chart').getContext('2d');
      var config = {
          type: 'bar',
          data: {
              labels: labels,
              datasets: [{
                  label: 'Actual Cost of Electricity',
                  backgroundColor: '#5e72e4',
                  data: actualData
              }, {
                  label: 'Electricity Cost Prediction',
                  backgroundColor: '#3A416F',
                  data: predictedData
              }]
          },
          options: {
              responsive: true,
              maintainAspectRatio: false,
              scales: {
                  y: {
                      suggestedMin: Math.min(...actualData, ...predictedData) * 0.85, // 85% dari nilai minimum
                      suggestedMax: Math.max(...actualData, ...predictedData) * 1.15, // 115% dari nilai maksimum
                      ticks: {
                          display: true,
                          padding: 10,
                          color: '#9ca2b7'
                      }
                  },
                  x: {
                      ticks: {
                          display: true,
                          color: '#9ca2b7',
                          padding: 10
                      }
                  }
              }
          }
      };

      if (window.myChart) {
          window.myChart.destroy();
      }

      window.myChart = new Chart(ctx, config);
  }

  function isFirstSelectedYear(selectedYear) {
      var firstYear = Math.min(...monthlyData.map(data => data.year));
      return selectedYear == firstYear;
  }

  function isLastSelectedYear(selectedYear) {
      var lastYear = Math.max(...monthlyData.map(data => data.year));
      return selectedYear == lastYear;
  }

  select.on('change', function() {
      var selectedYear = $(this).val();
      var selectedData = getSelectedYearData(selectedYear);

      drawChart(selectedData);
  });

  fetchData();
});

