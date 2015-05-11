var FILTRE_IMAGE = {};
var MAX_PAR_PAGE = 20;

function ajax(method, url, success, data) {
    var xhr = new XMLHttpRequest();

    xhr.open(method, url);

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
            success(xhr.responseText);
        }
    };

    console.log('URL', url);
    xhr.send(data);
}

function afficher(rep) {
    var imgDiv = document.getElementById('images');
    imgDiv.innerHTML = "";

    var imagesJSON = JSON.parse(rep);
    var baseUrl = imagesJSON['thumbnails_dir'];

    for (var ind in imagesJSON['results']) {
        var img = imagesJSON['results'][ind];
        var infosSpan = document.createElement('span');
        var imgImg = document.createElement('img');
        var motscles = document.createElement('span');
        infosSpan.innerHTML = img['title'] + ' by ';

        if (img['url_author'].length > 0) {
            var consulterImgAuteur = document.createElement('em');
            consulterImgAuteur.innerHTML = ' ( # ) ';
            consulterImgAuteur.dataset['a'] = img['author'];
            consulterImgAuteur.onclick = function () {
                afficherImages({'author': this.dataset['a']});
            };
            infosSpan.innerHTML += '<a href="' + img['url_author'] + '" target="_blank" >' + img['author'] + '</a>';
            infosSpan.appendChild(consulterImgAuteur);
        }
        else {
            infosSpan.innerHTML += img['author'];
        }
        imgImg.setAttribute('src', baseUrl + '/' + img['thumbnail']);
        imgImg.setAttribute('url', img['url']);
        imgImg.classList.add('vignette');

        for (var m in img['keywords']) {
            motscles.innerHTML += '#' + img['keywords'][m] + ' ';
        }
        var container = document.createElement('div');
        container.appendChild(infosSpan);
        container.appendChild(imgImg);
        container.appendChild(motscles);

        if (img['favorite'] !== undefined) {
            var fav = document.createElement('img');
            fav.setAttribute('src', img['favorite'] ? 'css/fav.png' : 'css/nofav.png');
            fav.onclick = function() {
                var vignette = fav.parentElement.getElementsByClassName('vignette')[0];
                ajax('GET', 'utilisateur/favoris/ajouter?vignette='+vignette, function() {
                    this.setAttribute('src', 'css/fav.png');
                });
            }
            container.appendChild(fav);
        }

        imgDiv.appendChild(container);

        imgImg.onclick = function () {
            window.open(this.getAttribute('url'), 'targetWindow',
                'toolbar=no,location = no,status = no,menubar = no,scrollbars = yes,resizable = yes');
        }
    }

    var suivante = document.getElementById('suivante');
    if (imagesJSON['results'].length < MAX_PAR_PAGE) {
        suivante.classList.add('cache');
    }
    else {
        suivante.classList.remove('cache');
    }

    var precedente = document.getElementById('precedente');
    if (!FILTRE_IMAGE['from']) {
        precedente.classList.add('cache');
    }
    else {
        precedente.classList.remove('cache');
    }
}

function afficherImages(opts) {
    var param = [];
    for (var o in opts) {
        param.push(o + '=' + opts[o]);
    }
    if (!opts || !opts['limit'] || isNaN(opts['limit'])) {
        param.push('limit=' + MAX_PAR_PAGE);
    } else if (opts['limit'] < 0) {
        opts['limit'] = 0;
    }

    if (!opts || !opts['from'] || isNaN(opts['from'])) {
        param.push('from=' + 0);
    } else if (opts['from'] < 0) {
        opts['from'] = 0;
    }

    if (!opts) {
        FILTRE_IMAGE = {};
    }
    else {
        FILTRE_IMAGE = opts;
    }

    ajax('GET', 'ws?' + param.join('&'), afficher);
}

window.onload = function () {

    afficherImages();

    var recherche = document.getElementById('recherche');
    if (recherche) {
        recherche.oninput = function () {
            if (this.value && this.value.length > 2) {
                ajax('GET', 'rechercher?search=' + this.value, afficher);
            }
            else if (this.value.length == 0) {
                afficherImages();
            }
        };
        recherche.onpropertychange = recherche.oninput;
    }

    var menu = document.getElementById('menu');
    if (menu) {
        var categories = menu.getElementsByClassName('categorie');
        if (categories) {
            for (var c in categories) {
                categories[c].onclick = function () {
                    afficherImages({'category': ((!this.dataset['c']) ? '' : this.dataset['c'])});
                }
            }
        }
    }

    var suivante = document.getElementById('suivante');
    if (suivante) {
        suivante.onclick = function () {
            if (!FILTRE_IMAGE['from'] || isNaN(FILTRE_IMAGE['from'])) {
                FILTRE_IMAGE['from'] = 0;
            }
            FILTRE_IMAGE['from'] += MAX_PAR_PAGE;
            afficherImages(FILTRE_IMAGE);
        }
    }

    var precedente = document.getElementById('precedente');
    if (precedente) {
        precedente.onclick = function () {
            if (!FILTRE_IMAGE['from'] || isNaN(FILTRE_IMAGE['from'])) {
                FILTRE_IMAGE['from'] = 0;
            }
            FILTRE_IMAGE['from'] -= MAX_PAR_PAGE;
            afficherImages(FILTRE_IMAGE);
        }
    }
}
;
