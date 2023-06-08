function ubahstatus3(value)
{
    if(value==true) value="on";
    else value= "off";
    document.getElementById('status3').innerHTML = value;

    // ajax merubah nilai status relaynya
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function()
    {
        if(xmlhttp.readyState == 4 && xmlhttp.status3 == 200)
        {
            // ambil respon dari web setelah berhasil merubah nilai
            document.getElementById('status3').innerHTML = xmlhttp.responseText;
            
        }
    }
    //execute file PHP untuk merubah nilai di database
    // xmlhttp.open("GET", "/manage-switch/" + value, true);
    xmlhttp.open("GET", "/manage-relay/relay/" + value, true);
    xmlhttp.send();
}

// $(document).ready(function(){
//     setInterval(function(){
//         $("#datajam").load('jam');
//     },999);
// });

$(document).ready(function(){
    setInterval(function(){
        $("#aaa").load('ubahstatus/{device_id}');
    },100);
});

// $(document).ready(function(){
//     setInterval(function(){
//         $("#refresh-sensor").load('manage-status/sensor');
//     },999);
// });

// Jam
const hour = document.getElementById('hour');
const minute = document.getElementById('minute');
const seconds = document.getElementById('seconds');

const clock = setInterval(function time() {
    let dateToday = new Date();
    let hr = dateToday.getHours(); 
    let min = dateToday.getMinutes(); 
    let sec = dateToday.getSeconds(); 

    if(hr <10){
        hr = '0' + hr;
    }
    if(min <10){
        min = '0' + min;
    }
    if(sec <10){
        sec = '0' + sec;
    }

    hour.textContent = hr;
    minute.textContent = min;
    seconds.textContent = sec;
}, 500);


// get mac address
$('#triggerButton').click(function() {
    // Kirim permintaan AJAX ke controller
    $.ajax({
      url: 'show-mac', // Ganti dengan URL sebenarnya ke controller Anda
      type: 'GET',
      success: function(response) {
        // Tampilkan data dari respons di dalam elemen HTML yang sesuai
        var html = '';
  
        // Buat tampilan data sesuai kebutuhan Anda
        html += response.mac_address
        // Tampilkan data dari respons di dalam elemen HTML yang sesuai
        $('#dataContainer').html(html);
      },
      error: function(xhr, status, error) {
        console.log(xhr.responseText);
      }
    });
  });


  