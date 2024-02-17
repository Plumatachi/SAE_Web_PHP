document.addEventListener("DOMContentLoaded", function (e) {
    document.getElementById("btn-modifier").addEventListener("click", function (e) {
        ModifierAlbum();
    });
    document.getElementById("btn-supprimer").addEventListener("click", function (e) {
        SupprimerAlbum();
    });
    document.getElementById('annee').setAttribute('disabled', 'true');
    document.getElementById('titre').setAttribute('disabled', 'true');
    artiste = document.getElementById("artiste");
    artiste.setAttribute("disabled", "true");
    for( let option of artiste.options){
        if(option.value == document.getElementById("idChanteur").value){
            option.selected = true;
        }
    }
});

function SupprimerAlbum() {
    let idAlbum = document.getElementById("idAlbum").value;
    fetch("deleteAlbum.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "idAlbum=" + idAlbum
    }).then(function (response) {
        if (response.ok) {
            return response.json();
        }
        else {
            throw new Error("Erreur de requête");
        }
    }).then(function (data) {
        console.log(data);
        if (data.status == "OK") {
            alert("Suppression effectuée");
            window.location.href = "index.php";
        }
        else {
            alert("Erreur lors de la suppression");
        }
    }).catch(function (error) {
        console.error(error);
    });
}

function ModifierAlbum() {
    let btnModifier = document.getElementById("btn-modifier");
    if (!document.getElementById("btn-valider")) {
        let div = btnModifier.parentElement;
        let btn = document.createElement("button");
        btn.innerHTML = "Valider";
        btn.id = "btn-valider";
        btn.setAttribute("href", "detailAlbum.php?id=" + document.getElementById("idAlbum").value);
        btn.addEventListener("click", function (e) {
            EnregistrerAlbum();
        });
        div.appendChild(btn);
    }
    else{
        let btn = document.getElementById("btn-valider");
        btn.remove();
    }
    switchInput();
}

function EnregistrerAlbum() {
    let idAlbum = document.getElementById("idAlbum").value;
    let idChanteur = document.getElementById("artiste").value;
    let annee = document.getElementById("annee").value;
    let titre = document.getElementById("titre").value;
    console.log(idAlbum, idChanteur, annee);
    fetch("updateAlbum.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "idAlbum=" + idAlbum + "&idChanteur=" + idChanteur + "&annee=" + annee + "&titre=" + titre
    }).then(function (response) {
        if (response.ok) {
            return response.json();
        }
        else {
            throw new Error("Erreur de requête");
        }
    }).then(function (data) {
        console.log(data);
        if (data.status == "OK") {
            alert("Modification effectuée");
            window.location.href = "detailAlbum.php?id=" + idAlbum;
        }
        else {
            alert("Erreur lors de la modification");
        }
    }).catch(function (error) {
        console.error(error);
    });
    }


function switchInput() {
    let artiste = document.getElementById("artiste");
    // let genres = document.getElementById("Genres");
    let annee = document.getElementById("annee");
    let titre = document.getElementById("titre");

    if (artiste.disabled == false) {
        artiste.disabled = true;
        artiste.style.border = "none";
        // genres.disabled = true;
        // genres.style.border = "none";
        annee.disabled = true;
        annee.style.border = "none";
        titre.disabled = true;
    }
    else {
        artiste.disabled = false;
        artiste.style.border = "2px solid #FFF";
        // genres.disabled = false;
        // genres.style.border = "2px solid #FFF";
        annee.disabled = false;
        annee.style.border = "2px solid #FFF";
        titre.disabled = false;
    }
}