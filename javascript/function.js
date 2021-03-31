function showNotification(){
    if(document.getElementsByClassName('message-content')[0].style.display == "block"){
        document.getElementsByClassName('message-content')[0].style.display = "none";
    }else{
        document.getElementsByClassName('message-content')[0].style.display = "block";
    }
    document.getElementsByName('click-enable')[0].value = "click";
}

window.onclick = function(event){ 

    if (!event.target.matches('.message-button')) {
        if(document.getElementsByClassName('message-content')[0].style.display == "block"){
            document.getElementsByClassName('message-content')[0].style.display = "none";
        }
    }
}
