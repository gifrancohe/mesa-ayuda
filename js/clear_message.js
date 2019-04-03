 /**
 * Función para ocultar el mensaje que llegué al crear una notificación
 */
function clearMessage() {
    var s = document.getElementById('card-response-message').style;
    s.opacity = 1;
    removeParam();
    (function fade(){(s.opacity-=.1)<0?s.display="none":setTimeout(fade,40)})();
    return true;
}
/**
 * Función para remover los parametro que lleguen por url
 */
function removeParam()
{
    var url = document.location.href;
    var urlparts = url.split('?');
    if (urlparts.length >= 1) {
        var urlBase = urlparts.shift(); 
        var queryString = urlparts.join("?"); 
        window.history.pushState('',document.title,urlBase); //Se agrega la url base a la url del navegador
    }
    return true;
}