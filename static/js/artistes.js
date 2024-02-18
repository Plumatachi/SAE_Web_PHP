document.addEventListener("DOMContentLoaded", function(e) {
    document.getElementById("search_Artistes").oninput = getArtisteFilter;
});

function getArtisteFilter() {
    let recherche = document.getElementById('search_Artistes').value == '' ? '' : document.getElementById('search_Artistes').value;
    let url = `majArtistes.php?recherche=${recherche}`;

    fetch(url)
        .then(response => response.json())
        .then(data => {
            let ul = document.getElementById('ul-artistes');
            ul.innerHTML = '';
            data.forEach(artiste => {
                let artisteJson = JSON.parse(artiste);
                let li = document.createElement('li');
                let div = document.createElement('div');
                div.setAttribute('class', 'flex');
                let a = document.createElement('a');
                a.setAttribute('href', '#');
                let img = document.createElement('img');
                img.setAttribute('src', 'https://picsum.photos/100');
                img.setAttribute('alt', artisteJson.nom);
                let h2 = document.createElement('h2');
                h2.textContent = artisteJson.nom;
                a.appendChild(img);
                div.appendChild(a);
                div.appendChild(h2);
                li.appendChild(div);
                ul.appendChild(li);
            });

        })
        .catch(error => console.error('Erreur lors de la requête AJAX:', error));
}