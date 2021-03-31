function calculateLoss(){
    var borrowamount = document.getElementsByName('quantity')[0].value;
    var returnamount = document.getElementsByName('returnamount')[0].value;
    var loss = borrowamount - returnamount;
    document.getElementsByName('loss')[0].value = loss;
}