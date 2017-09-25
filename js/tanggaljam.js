//        Tanggal
//var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
//var myDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum&#39;at', 'Sabtu'];
//var date = new Date();
//var day = date.getDate();
//var month = date.getMonth();
//var thisDay = date.getDay(),
//    thisDay = myDays[thisDay];
//var yy = date.getYear();
//var year = (yy < 1000) ? yy + 1900 : yy;
////batas-->
function showTime() {
    var a_p = "";
    var today = new Date();
    var curr_hour = today.getHours();
    var curr_minute = today.getMinutes();
    var curr_second = today.getSeconds();
    var curr_date = today.getDate();
    var curr_mounth = today.getMonth() + 1;
    var curr_year = today.getFullYear();
    // if (curr_hour < 12) {
    //     a_p = "AM";
    // } else {
    //     a_p = "PM";
    // }
    // if (curr_hour == 0) {
    //     curr_hour = 12;
    // }
    // if (curr_hour > 12) {
    //     curr_hour = curr_hour - 12;
    // }
    curr_hour = checkTime(curr_hour);
    curr_minute = checkTime(curr_minute);
    curr_second = checkTime(curr_second);
    document.getElementById('clock').innerHTML=curr_hour + ":" + curr_minute + ":" + curr_second + " - " + curr_date + "/" + curr_mounth + "/" + curr_year;
}

function checkTime(i) {
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}
setInterval(showTime, 500);


//-->