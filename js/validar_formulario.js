function validateForm() {
    var form = document.forms[0];
    var fields = form.getElementsByClassName('validate-custom');
    validate = true;
    [...fields].forEach(function(element) {
        if(element.tagName === 'SELECT') {
            var strSelect = element.options[element.selectedIndex].value;
            if(strSelect == '')
                validate = false;
        }else{

            let strValue = element.value.replace(/\s+/, ''); //Se valida que no sean solo espacios en blanco
            if(strValue == "" || strValue == null) {
                validate = false;
            }
        }
    });
    if(!validate) {
        alert("Hay campos requeridos sin diligenciar.")
    }
    return validate;
}