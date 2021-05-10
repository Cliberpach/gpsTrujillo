function isNumber(e) {
    return (e.charCode == 8 || e.charCode == 0 || e.charCode == 13) ? null : e.charCode >= 48 && e.charCode <= 57;
}

function isNroCuenta(e) {
    var keynum = (!Window.event) ? e.which : e.keyCode;
    return !((keynum === 8 || keynum === undefined || e.which === 0) ? null : String.fromCharCode(keynum).match(/[^0-9\-]/g));
}

function mayus(e) {
    // alert(e.value)
    e.value = e.value.toUpperCase();
}

function emailIsValid (email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)
}

function filterFloat(evt,input, peso = false){
    // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
    var key = window.Event ? evt.which : evt.keyCode;
    var chark = String.fromCharCode(key);
    var tempValue = input.value+chark;
    if(key >= 48 && key <= 57){
        if (peso) {
            filterPeso(tempValue);
        } else {
            filter(tempValue)
        }
    }else{
        if(key == 8 || key == 13 || key == 0) {
            return true;
        }else if(key == 46){
            if (peso) {
                return filterPeso(tempValue);
            } else {
                return filter(tempValue);
            }
        }else{
            return false;
        }
    }
}

function filter(__val__){
    var preg = /^([0-9]+\.?[0-9]{0,2})$/;
    return preg.test(__val__);
}

function filterPeso(__val__){
    var preg = /^([0-9]+\.?[0-9]{0,6})$/;
    return preg.test(__val__);
}

function getCurrentDate() {
    var today = new Date();
    return today.getDate()+'/'+(today.getMonth()+1)+'/'+today.getFullYear();
}
