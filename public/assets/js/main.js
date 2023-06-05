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

$(document).ready(function(){
    setInterval(function(){
        $("#datajam").load('jam');
    },999);
});

$(document).ready(function(){
    setInterval(function(){
        $("#aaa").load('ubahstatus');
    },999);
});