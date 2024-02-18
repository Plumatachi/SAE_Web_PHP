document.addEventListener("DOMContentLoaded", function(e) {
    let genre = document.getElementById('genre');
    let divGenre = document.getElementById('genre-ajoute');
    
    genre.onchange = function(e) {
        let val = genre.value;
        if (val != -1){
            console.log('rien')
            let div = document.createElement('div');
            let p = document.createElement('p');
            let button = document.createElement('button');
            button.setAttribute('type', 'button');
            button.onclick = function(e) {
                div.remove();
                updateHiddenInput();
            }
            button.innerHTML = 'Supprimer';
            p.innerText = genre.options[genre.selectedIndex].text;
            div.appendChild(p);
            div.appendChild(button);
            divGenre.appendChild(div);
            updateHiddenInput();
        }
    };

    function updateHiddenInput() {
        let hiddenInput = document.getElementById("genres");
        let selectedGenres = divGenre.querySelectorAll("p");
        hiddenInput.value = Array.from(selectedGenres).map(p => p.innerText).join(",");
        console.log(hiddenInput.value);
    }
});
