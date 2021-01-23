function mostraErrore(target) {
    var p = target.parentNode; 
    if (p.children.length == 2) {
        p.removeChild(p.children[1]);
    }
    var newAvviso = document.createElement("strong");
    newAvviso.className = "erroreForm";
    var newContenuto = document.createTextNode("Seleziona almeno una casella per proseguire");
    newAvviso.appendChild(newContenuto);
    p.appendChild(newAvviso);
    

}

function controlla(x) {
    var scelto = false;
    for (var i=0; i < x.elements.length; i++) {
        if (x.elements[i].type && x.elements[i].type =="checkbox" && x.elements[i].checked) {
            scelto = true;
        }
    }
    var target = x;
    if (!scelto) {
         mostraErrore(target);
    }
    return scelto;
    }
