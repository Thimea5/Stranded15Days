import './bootstrap.js';
import './styles/app.css';
import './styles/menu.css';


console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');

;

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');

document.addEventListener('DOMContentLoaded', function() {
    //btn
    let btnShowConnexion = document.getElementById('btnConnexion');
    let btnAccueil = document.getElementById('btnAccueil');

    //formulaires
    let formConnexion = document.getElementById('form-connexion');

    btnShowConnexion.addEventListener('click', function(){
        event.preventDefault();
        formConnexion.style.display = 'block';
        document.getElementById("div-connexion").style.display = "block";
    });

    btnAccueil.addEventListener('click', function(){
        event.preventDefault()
        formConnexion.style.display = 'none';
        document.getElementById("div-connexion").style.display = "none";
    });
});
