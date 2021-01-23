var campiForm = {
    "nome": ["Inserisci il nome del gatto", /^[a-zA-Z]{2}[a-zA-Z\s\']{0,28}$/ ],
    "descrizione" : ["Inserisci una breve descrizione del gatto", /.{10,}/]
	};


    /*
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
  for (var i = 0; controllo == false && i < list.length; i++) {
    if (lista[i].type == 'checkbox') {
       if (lista[i].checked) {
           controllo = true;}
    }
  }
  return controllo;
}

function validateForm()
{
    var corretto = true;

    for (var key in campiForm) {
        var input = document.getElementsByTagName(input)
        var risultato = validazioneCampo(input);
        corretto = corretto && risultato;
    }
    return corretto;


    if(!controlloCheckbox())
    {
        alert("Seleziona almeno una casella");  
        return false;
    }
    return true;
}
*/

function controllo() {
    var scelto = false;
    for (i=0; i < document.formEliminaGatti.delete.length; i++) {
        if (document.formEliminaGatti.delete[i].checked) {
            scelto = true;
        }
    }
    if (!scelto) {
        alert("Selezionare almeno un'opzione");
        return (false);
    }
    return (true);
}