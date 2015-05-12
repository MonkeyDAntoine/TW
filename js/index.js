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

    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    if (data) {
        xhr.send(data.join('&'));
    }
    else {
        xhr.send();
    }
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
        infosSpan.innerHTML = img['title'] + ' (' + img['size'] + ')';

        if (img['url_author'].length > 0) {
            var consulterImgAuteur = document.createElement('em');
            consulterImgAuteur.innerHTML = ' ( # ) ';
            consulterImgAuteur.dataset['a'] = img['author'];
            consulterImgAuteur.onclick = function () {
                afficherImages({'author': this.dataset['a']});
            };
            infosSpan.innerHTML += ' by <a href="' + img['url_author'] + '" target="_blank" >' + img['author'] + '</a>';
            infosSpan.appendChild(consulterImgAuteur);
        }
        else {
            infosSpan.innerHTML += img['author'];
        }
        imgImg.setAttribute('src', baseUrl + '/' + img['thumbnail']);
        imgImg.setAttribute('url', img['url']);
        imgImg.classList.add('vignette');

        if (img['keywords'] && img['keywords'].length > 0) {
            for (var m in img['keywords']) {
                if (img['keywords'][m].length > 0) {
                    motscles.innerHTML += '#' + img['keywords'][m] + ' ';
                }
            }
        }

        var licence = document.createElement('span');
        licence.classList.add('licence');

        if (img['licence'] && img['licence'].length > 0) {
            var types = img['licence'].toLowerCase().split('-');
            for (var t in types) {
                var cc = document.createElement('img');
                cc.classList.add('cc');
                cc.setAttribute('src', 'css/' + types[t] + '.png');
                licence.appendChild(cc);
            }
        }

        var container = document.createElement('div');

        container.appendChild(infosSpan);
        container.appendChild(imgImg);
        container.appendChild(licence);
        container.appendChild(motscles);

        if (img['favorite'] !== undefined) {
            var fav = document.createElement('img');
            fav.setAttribute('src', img['favorite'] ? 'css/fav.png' : 'css/nofav.png');
            fav.onclick = function () {
                var $this = this;
                var vignette = this.parentElement.getElementsByClassName('vignette')[0];
                if ($this.getAttribute('src') == 'css/fav.png') {
                    ajax('GET', 'utilisateur/favoris/supprimer?vignette=' + vignette.getAttribute('src'), function () {
                        $this.setAttribute('src', 'css/nofav.png');
                    });
                }
                else {
                    ajax('GET', 'utilisateur/favoris/ajouter?vignette=' + vignette.getAttribute('src'), function () {
                        $this.setAttribute('src', 'css/fav.png');
                    });
                }
            }
            container.insertBefore(fav, infosSpan);
        }

        imgDiv.appendChild(container);

        imgImg.onclick = function () {
            window.open(this.getAttribute('url'), 'targetWindow',
                'toolbar=no,location = yes,status = no,menubar = no,scrollbars = yes,resizable = yes');
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

var MAX_LOGIN_PAR_PAGE = 10;
function afficherLogins(page_login) {
    if (page_login == undefined || isNaN(page_login || page_login < 0)) {
        page_login = 0;
    }
    var listeLogins = document.getElementById('utilisateurs');
    var logins_suivants = document.getElementById('logins_suivants');
    var logins_precedents = document.getElementById('logins_precedents');

    ajax('GET', 'utilisateur/?limit=' + MAX_LOGIN_PAR_PAGE + '&from=' + (page_login * MAX_LOGIN_PAR_PAGE), function (resp) {
        var logins = JSON.parse(resp);
        var liste = document.createElement('ul');
        for (var i in logins) {
            var li = document.createElement('li');
            li.innerHTML = logins[i];
            liste.appendChild(li);
            li.onclick = function () {
                afficherImages({'collection': this.innerHTML});
            }
        }
        listeLogins.innerHTML = '';
        listeLogins.appendChild(liste);

        if (logins.length < MAX_LOGIN_PAR_PAGE) {
            logins_suivants.classList.add('cache');
        }
        else {
            logins_suivants.classList.remove('cache');
        }
        if (page_login == 0) {
            logins_precedents.classList.add('cache');
        }
        else {
            logins_precedents.classList.remove('cache');
        }
    });
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

    var connectionForm = document.forms['connectionForm'];
    var inscriptionForm = document.forms['inscriptionForm'];
    var $messages = document.getElementById('messages');

    if (connectionForm) {
        connectionForm.addEventListener('submit', function (e) {
            e.preventDefault();
            var $param = new Array();
            $param.push('login=' + connectionForm.login.value);
            $param.push('mdp=' + connectionForm.mdp.value);
            ajax(connectionForm.method, connectionForm.action, function (resp) {
                    var $rep = JSON.parse(resp);
                    if ($rep['erreurs'].length == 0) {
                        document.location.reload();
                    }
                    else {
                        $messages.innerHTML = '';
                        for (var m in $rep['erreurs']) {
                            $messages.innerHTML += $rep['erreurs'][m] + '<br>';
                        }
                    }
                }, $param
            );
            return false;
        });
    }

    if (inscriptionForm) {
        inscriptionForm.addEventListener('submit', function (e) {
            e.preventDefault();
            var $param = new Array();
            $param.push('login=' + inscriptionForm.login.value);
            $param.push('mdp=' + inscriptionForm.mdp.value);
            $param.push('mdpbis=' + inscriptionForm.mdpbis.value);
            ajax(inscriptionForm.method, inscriptionForm.action, function (resp) {
                    var $rep = JSON.parse(resp);
                    if ($rep['erreurs'].length == 0) {
                        $messages.innerHTML = 'inscription résussie veuillez vous connecter !';
                        connectionForm.login.value = inscriptionForm.login.value;
                        inscriptionForm.login.value = '';
                        inscriptionForm.mdp.value = '';
                        inscriptionForm.mdpbis.value = '';
                    }
                    else {
                        $messages.innerHTML = '';
                        for (var m in $rep['erreurs']) {
                            $messages.innerHTML += $rep['erreurs'][m] + '<br>';
                        }
                    }
                }, $param
            );
            return false;
        });
    }

    var deconnectionForm = document.forms['deconnectionForm'];
    if (deconnectionForm) {
        deconnectionForm.addEventListener('submit', function (e) {
            e.preventDefault();
            ajax(deconnectionForm.method, deconnectionForm.action, function (resp) {
                    document.location.reload();
                }
            );
            return false;
        });
    }


    var PAGE_LOGIN = 0;

    var listeLogins = document.getElementById('utilisateurs');
    var logins_suivants = document.getElementById('logins_suivants');
    var logins_precedents = document.getElementById('logins_precedents');
    if (listeLogins) {
        afficherLogins();
        if (logins_suivants) {
            logins_suivants.onclick = function () {
                PAGE_LOGIN++;
                afficherLogins(PAGE_LOGIN);
            }
        }

        if (logins_precedents) {
            logins_precedents.onclick = function () {
                PAGE_LOGIN--;
                afficherLogins(PAGE_LOGIN);
            }
        }
    }

    document.getElementById('afficherConnection').onclick = function(e) {
        e.preventDefault();
        document.getElementById('connection').classList.remove('cache');
        document.getElementById('inscription').classList.add('cache');
        return false;
    }


    document.getElementById('afficherInscription').onclick = function(e) {
        e.preventDefault();
        document.getElementById('connection').classList.add('cache');
        document.getElementById('inscription').classList.remove('cache');
        return false;
    }
};
