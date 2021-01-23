/*var campiForm = {
    "nome": ["Inserisci il nome del gatto", /^[a-zA-Z]{2}[a-zA-Z\s\']{0,28}$/ ],
    "descrizione" : ["Inserisci una breve descrizione del gatto", /.{10,}/]
	};


function campoDefault(input) {
    input.value = "";
}

function caricamento() {
    for (var key in campiForm) {
        var input = document.getElementById(key);
        campoDefault(input);
    }
}

function mostraErrore(input) {
    var elemento = document.createElement("strong");
    elemento.className = "erroreForm";
    elemento.appendChild(document.createTextNode(campiForm[input.id][0]));
    var p = input.parentNode; 
    p.appendChild(elemento); 
}

function validazioneCampo(input) {
    var parent = input.parentNode; 
    if (parent.children.length == 2) {
        parent.removeChild(parent.children[1]);
    }
    var regex = campiForm[input.id][1]; 
    var text = input.value;
    if (text.search(regex) != 0) { 
        mostraErrore(input);
        return false;
    } else {
        return true;
    }

}


function validateForm() {
    var corretto = true;
    for (var key in campiForm) {
        var input = document.getElementById(key);
        var risultato = validazioneCampo(input);
        corretto = corretto && risultato;
    }
    return corretto;
}


function controlloCheckbox()
{
  var list = document.getElementsByTagName('input');
  var controllo = false;
  for (var i = 0; i < list.length; i++) {
    if (lista[i].type == 'checkbox' && lista[i].checked) { 
        controllo = true;}
  }
  return controllo;
}
*/

function validateForm() {
    var corretto = false;
    var list = document.getElementsByTagName('input');
    for (var i = 0; i < list.length; i++) {
        if (lista[i].type == 'checkbox' && lista[i].checked) { 
            corretto = true;
        }
    }    
    if(corretto) {
        alert("Seleziona almeno una casella");  
    }
    return corretto;
}


    /*

function controlla(x) {
    var scelto = false;
    for (var i=0; i < x.elements.length; i++) {
        if (x.elements[i].type && x.elements[i].type =="checkbox" && x.elements[i].checked) {
            scelto = true;
        }
    }
    if (!scelto){
         alert("Seleziona almeno una casella");
    }
    return scelto;
    }
*/