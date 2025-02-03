import './bootstrap.js';
import './styles/app.css';
import './styles/menu.css';
import './styles/fonts.css';

let tabForms= [];

document.addEventListener('DOMContentLoaded', function() {
    //btn
    let btnShowConnexion = document.getElementById('btnConnexion');
    let btnShowInscription = document.getElementById('btninscription');
    let btnAccueil = document.getElementById('btnAccueil');

    //formulaires
    let formConnexion = document.getElementById('form-connexion');
    let formInscription = document.getElementById('form-inscription');
    let divConnexion = document.getElementById('div-connexion')
    tabForms.push(formConnexion);
    tabForms.push(formInscription);
    tabForms.push(divConnexion)

    btnShowConnexion.addEventListener('click', function(){
        event.preventDefault();
        hideForms();
        formConnexion.style.display = 'block';
        divConnexion.style.display = "block";
    });

    btnAccueil.addEventListener('click', function(){
        event.preventDefault()
        hideForms();
    });

    btnShowInscription.addEventListener('click', function(){
        event.preventDefault();
        hideForms();
        formInscription.style.display = 'block';
        document.getElementById("div-inscription ").style.display = "block";
    });
});


function hideForms(){
    for (form of tabForms) {
        form.style.display = "none";
    }
}