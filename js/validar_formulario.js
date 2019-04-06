function validateForm() {
    var form = document.forms[0];
    var idform = form.id;
    message = "";
    validate = true;
    if(idform == 'form-asignar-requisitos' || idform == 'form-solucionar-requisitos') {
        var checks = document.querySelectorAll('input[type=checkbox]');
        [...checks].forEach(function(element) {
            if(!element.checked) {
                validate = false;
                message = "Debe seleccionar minimo un requisito."
            }
        });

    }

    if(validate) {
        var fields = form.getElementsByClassName('validate-custom');
        [...fields].forEach(function(element) {
            if(element.tagName === 'SELECT') {
                var strSelect = element.options[element.selectedIndex].value;
                if(strSelect == ''){
                    validate = false;
                    message = "Hay campos requeridos sin diligenciar."
                }
            }else{
    
                let strValue = element.value.replace(/\s+/, ''); //Se valida que no sean solo espacios en blanco
                if(strValue == "" || strValue == null) {
                    validate = false;
                    message = "Hay campos requeridos sin diligenciar."
                }
            }
        });
    }

    if(!validate) {
        alert(message);
    }
    return validate;
}