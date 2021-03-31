function signUpValidation(){
    
    if(document.getElementsByName('username')[0].value == ''){
        alert("Name field cannot be blanked.");
        return false;
    }
    else{
        var emailRegularExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
        if(emailRegularExp.test(document.getElementsByName('email')[0].value)){
            var numRegularExp = /^[0-9]+$/;
            if(numRegularExp.test(document.getElementsByName('phone')[0].value)){
                if(document.getElementsByName('password')[0].value == ''){
                    alert("Invalid Password");
                    return false;
                }
                else{
                    if(document.getElementsByName('confirmPassword')[0].value != document.getElementsByName('password')[0].value){
                        alert("Password is not same.");
                        return false;
                    }else{
                        return true;
                    }
                }
            }else{
                alert("Invalid Phone Number");
                return false;
            }
        }else{
            alert("Invalid Email.");
            return false;
        }
    }
}
function borrowFormValidation(){
    var borrowdate = document.getElementsByName('borrowdate')[0].value;
    var returndate = document.getElementsByName('returndate')[0].value;
    if(document.getElementsByName('quantity')[0].value < 1 || document.getElementsByName('quantity')[0].value > 999){
        alert("Quantity need to have minimun of 1 unit or maximun of 999.");
        return false;
    }else{
        if(document.getElementsByName('itemborrow')[0].value == ""){
            alert("Item field cannot be empty.");
            return false;
        }else{
            if(borrowdate== "" || returndate == ""){
                alert("Date range need to be clearly specify.");
                return false;
            }else{
                if(borrowdate > returndate){
                    alert("Invalid borrow date range.");
                    return false;
                }else{
                    document.getElementsByName('action')[0].value = "submit";
                    return true;
                }
            }
        }
    }
}
function returnFormValidation(){
    var borrowamount = document.getElementsByName('quantity')[0].value;
    var returnamount = document.getElementsByName('returnamount')[0].value;
    var lossreason = document.getElementsByName('lossreason')[0].value;
    if(returnamount < 0){
        alert("Return amount need to have a number minimun of 0.");
        
        return false;
    }else{
        if(returnamount > borrowamount){
            alert("Return amount greater than borrow amount");
            return false;
        }else{
            if(document.getElementsByName('loss')[0].value != borrowamount - returnamount){
                alert("Loss item amount is incorrect.");
                return false;
            }else{
                if(document.getElementsByName('loss')[0].value > 0 && lossreason == ""){
                    alert("Loss item reason must stated.")
                    return false;
                }else{
                    return true;
                }
            }
            
        }
    }
}
function applicationFormValidation(){
    var currentitem = document.getElementsByName('currentamount')[0].value;
    var borrowitem = document.getElementsByName('quantity')[0].value;
        if( borrowitem > currentitem){
            alert('Insufficient borrow amount.');
            return false;
        }else{
            return true;
        }
}
function chkreason(){
    if(document.getElementsByName('reason')[0].value == ""){
        alert("Reject reason must be stated.");
        return false;
    }else{
        return true;
    }
}
function deleteAction(){
    document.getElementsByName('action')[0].value = "delete";
}
function updateAction(){
    document.getElementsByName('action')[0].value = "update";
}
function searchAction(){
    document.getElementsByName('action')[0].value = "search";
}
