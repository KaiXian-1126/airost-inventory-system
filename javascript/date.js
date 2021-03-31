var d = new Date();
function getFullYear(){
    return d.getFullYear();
}
function getMonth(){
    return d.getMonth() + 1;
}
function getDate(){
    return d.getDate();
}
function getHours(){
    return d.getHours();
}
function getMinutes(){
    return d.getMinutes();
}
function getSecond(){
    return d.getSeconds
}
function getCurrentDate(){
    var month;
    if(getMonth() <= 9){
        month = "0" + getMonth();
    }else{
        month = getMonth();
    }
    if (getDate() <= 9){
        day = "0" + getDate();
    }else{
        day = getDate();
    }
    var currentDate = getFullYear() + "-" + month + "-" + day;
    return currentDate;
}