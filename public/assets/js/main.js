function ubahstatus3(value)
{
    if(value==true) value="on";
    else value= "off";

    // ajax merubah nilai status relaynya
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.open("GET", "/manage-status/relay/" + value, true);
    xmlhttp.send();
}


$(document).ready(function() {
    if ($('#schedule-refresh').length > 0) {
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
    }
});



// $(document).ready(function(){
//     setInterval(function(){
//         $("#refresh-sensor").load('manage-status/sensor');
//     },999);
// });


const hour = document.getElementById('hour');
const minute = document.getElementById('minute');
const seconds = document.getElementById('seconds');

const clock = setInterval(function time() {
  let dateToday = new Date();
  let hr = dateToday.getHours();
  let min = dateToday.getMinutes();
  let sec = dateToday.getSeconds();

  if (hour !== null) {
    hour.textContent = hr < 10 ? "0" + hr : hr;
  }
  if (minute !== null) {
    minute.textContent = min < 10 ? "0" + min : min;
  }
  if (seconds !== null) {
    seconds.textContent = sec < 10 ? "0" + sec : sec;
  }
}, 999);



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


// Once or Repeat
const optionToday = document.getElementById('option_today');
const optionRepeat = document.getElementById('option_repeat');
const repeatDays = document.getElementById('repeat_days');
const repeatWeekly = document.getElementById('repeat_weekly');

optionToday.addEventListener('change', function() {
    if (this.checked) {
        repeatDays.style.display = 'none';
        repeatWeekly.style.display = 'none';
    }
});

optionRepeat.addEventListener('change', function() {
    if (this.checked) {
        repeatDays.style.display = 'block';
        repeatWeekly.style.display = 'block';
    }
});

