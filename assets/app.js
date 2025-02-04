import './bootstrap.js';
import './styles/app.css';
import './styles/menu.css';
import './styles/fonts.css';

const axios = require('axios').default;

let tabForms= [];

document.addEventListener('DOMContentLoaded', function() {
    console.log("DOM chargé");

    //btn
    let btnAccueil = document.getElementById('btnAccueil');
    let btnConnexion = document.getElementById('btnConnexion');
    let btnInscription = document.getElementById('btnInscription');
    let btnReglement = document.getElementById('btnReglement');

    //formulaires
    let formConnexion = document.getElementById('form-connexion');
    let formInscription = document.getElementById('form-inscription');
    let divConnexion = document.getElementById('div-connexion')
    tabForms.push(formConnexion);
    tabForms.push(formInscription);
    tabForms.push(divConnexion)

    btnConnexion.addEventListener('click', function(){
        event.preventDefault();
        console.log("Bouton connexion cliqué");
        hideForms();
        formConnexion.style.display = 'block';
        divConnexion.style.display = "block";
    });

    btnAccueil.addEventListener('click', function(){
        event.preventDefault()
        console.log("Bouton accueil cliqué");
        hideForms();
    });

    btnInscription.addEventListener('click', function(){
        event.preventDefault();
        console.log("Bouton inscription cliqué");
        hideForms();
        formInscription.style.display = 'block';
        document.getElementById("div-inscription").style.display = "block";
    });
});


function hideForms(){
    console.log("hideForms");
    for (let form of tabForms) {
        console.log(form)
        form.style.display = "none";
    }
}