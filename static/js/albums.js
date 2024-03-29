document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('search_Albums').addEventListener('input', getAlbumsFilter);
    document.getElementById('annee').addEventListener('change', getAlbumsFilter);
    document.getElementById('artiste').addEventListener('change', getAlbumsFilter);
    document.getElementById('genre').addEventListener('change', getAlbumsFilter);
});


function getAlbumsFilter() {
    let artiste = document.getElementById('artiste').value ?? null;
    let recherche = document.getElementById('search_Albums').value == '' ? '' : document.getElementById('search_Albums').value;
    let genre = document.getElementById('genre').value ?? null;
    let annee = document.getElementById('annee').value == '' ? null : document.getElementById('annee').value;
    let url = `majAlbums.php?recherche=${recherche}&artiste=${artiste}&annee=${annee}&genre=${genre}`;
    // let url = `majAlbums.php?recherche=${recherche}&artiste=${artiste}&annee=${annee}`;
    
    fetch(url)
        .then(response => response.json())
        .then(data => {
            let ul = document.getElementById('ul-albums');
            ul.innerHTML = '';
            data.forEach(album => {
                albumJson = JSON.parse(album);
                let li = document.createElement('li');
                let div = document.createElement('div');
                div.setAttribute('class', 'flex');
                let a = document.createElement('a');
                a.setAttribute('href', '#');
                let img = document.createElement('img');
                img.setAttribute('src', 'static/images/' + encodeURIComponent(albumJson.imageAlbum));
                img.setAttribute('alt', albumJson.titre);
                let h2 = document.createElement('h2');
                h2.textContent = albumJson.titre;
                a.appendChild(img);
                div.appendChild(a);
                div.appendChild(h2);
                li.appendChild(div);
                ul.appendChild(li);
            });

        })
        .catch(error => console.error('Erreur lors de la requête AJAX:', error));
}
