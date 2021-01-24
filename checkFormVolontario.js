var campiForm = {
	"nome": ["Inserisci il tuo nome", /^[a-zA-Z]{2}[a-zA-Z\s\']{0,28}$/ ],
	"cognome": ["Inserisci il tuo cognome", /^[a-zA-Z]{2}[a-zA-Z\s\']{0,28}$/],
	"dataNascita": ["Inserisci la tua data di nascita in formato GG/MM/AAAA", /^(0[1-9]|[12][0-9]|3[01])[\/](0[1-9]|1[012])[\/](19\d{2}|20\d{2})$/],
    "citta": ["Inserisci il nome della città in cui risiedi", /^[a-zA-Z]{2}[a-zA-Z\s\']{0,28}$/],
	"telefono": ["Inserisci il tuo numero di telefono (cellulare o fisso)", /\d{9,10}/],
	"oreVol": ["Inserisci in formato numerico il numero di ore che puoi dedicare al volontariato", /^[1-9]{1}[0-9]{0,2}$/],
	"motivazione": ["Spiega per quale motivo vorresti diventare volontario presso il Rifugio U.E.P.A.", /.{30,}/]
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
    elemento.className = "errore";
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

