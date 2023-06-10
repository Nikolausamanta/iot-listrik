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
    xmlhttp.open("GET", "/manage-status/relay/" + value, true);
    xmlhttp.send();
}


$(document).ready(function() {
    setInterval(function() {
        $.ajax({
            url: '/ubahstatus',
            type: 'GET',
            success: function(response) {
                // Tambahkan logika untuk menangani respons dari server
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }, 999); // Set interval waktu per detik (1000 ms = 1 detik)
});



// $(document).ready(function(){
//     setInterval(function(){
//         $("#refresh-sensor").load('manage-status/sensor');
//     },999);
// });

// Jam
// const hour = document.getElementById('hour');
// const minute = document.getElementById('minute');
// const seconds = document.getElementById('seconds');

// const clock = setInterval(function time() {
//     let dateToday = new Date();
//     let hr = dateToday.getHours(); 
//     let min = dateToday.getMinutes(); 
//     let sec = dateToday.getSeconds(); 

//     if(hr <10){
//         hr = '0' + hr;
//     }
//     if(min <10){
//         min = '0' + min;
//     }
//     if(sec <10){
//         sec = '0' + sec;
//     }

//     hour.textContent = hr;
//     minute.textContent = min;
//     seconds.textContent = sec;
// }, 500);


// MAC Address
$(document).ready(function () {
    $("#triggerButton").click(function (event) {
        event.preventDefault(); // Prevent the default form submission

        // Send an AJAX request to the server
        $.ajax({
            url: "show-mac", // Replace with the actual URL to your controller
            type: "GET",
            success: function (response) {
                // Update the value of the input field with the received Mac Address
                $('input[name="mac_address"]').val(response.mac_address);
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText);
            },
        });
    });
});