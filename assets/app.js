import './bootstrap.js';
import './styles/app.css';
import './styles/menu.css';
import './styles/fonts.css';
import './styles/accueil.css';
import './styles/jeu.css';

let tabForms= [];

document.addEventListener('DOMContentLoaded', function() {
    console.log("DOM chargé");

    //btn
    let btnAccueil = document.getElementById('btnAccueil');
    let btnConnexion = document.getElementById('btnConnexion');
    let btnInscription = document.getElementById('btnInscription');
    let btnReglement = document.getElementById('btnReglement');
    let redirectInscription = document.getElementById('redirectInscription');
    let redirectConnexion = document.getElementById('redirectConnexion');
    let btnDeconnexion = document.getElementById('btn-deconnexion');
    let btnRunConnexion = document.getElementById('btnFormConnexion');
    let btnRunInscription = document.getElementById('btnFormInscription');
    let btnRunDeconnexion = document.getElementById('btn-deconnexion');

    //formulaires
    let formConnexion = document.getElementById('form-connexion');
    let formInscription = document.getElementById('form-inscription');
    let divConnexion = document.getElementById('div-connexion')
    let divInscription = document.getElementById('div-inscription');
    tabForms.push(formConnexion);
    tabForms.push(formInscription);
    tabForms.push(divConnexion);
    tabForms.push(divInscription);

    btnDeconnexion?.addEventListener('click', function(){
        event.preventDefault();
        btnRunDeconnexion.classList.add("btn-loading");
        btnRunDeconnexion.disabled = true; 
        axios.get('/api/deconnexion')
        .then(response => {
            btnRunDeconnexion.classList.remove("btn-loading"); 
            btnRunDeconnexion.disabled = false; 
            window.location.href = response.request.responseURL; // Redirection après logout
        })
        .catch(error => {
            console.error("Erreur lors de la déconnexion :", error);
        });
    });

    btnConnexion?.addEventListener('click', function(){
        event.preventDefault();
        console.log("Bouton connexion cliqué");
        hideForms();
        formConnexion.style.display = 'block';
        divConnexion.style.display = 'block';
    });

    btnAccueil?.addEventListener('click', function(){
        event.preventDefault()
        console.log("Bouton accueil cliqué");
        hideForms();
    });

    btnInscription?.addEventListener('click', function(){
        event.preventDefault();
        console.log("Bouton inscription cliqué");
        hideForms();
        formInscription.style.display = 'block';
        divInscription.style.display = 'block';
    });

    redirectConnexion?.addEventListener('click', function(){
        event.preventDefault();
        hideForms();
        formConnexion.style.display = 'block';
       divConnexion.style.display = 'block';
    });

    redirectInscription?.addEventListener('click', function(){
        event.preventDefault();
        hideForms();
        formInscription.style.display = 'block';
       divInscription.style.display = 'block';
    });

    // Soumission inscription 
    formInscription?.addEventListener('submit', async function (event) {
        event.preventDefault(); 
        console.log('click');
        btnRunInscription.classList.add("btn-loading"); // Active l'effet
        btnRunInscription.disabled = true; // Désactive le bouton
    
        const pseudo = formInscription.querySelector('input[name="pseudo"]').value;
        const email = formInscription.querySelector('input[name="email"]').value;
        const password = formInscription.querySelector('input[name="password"]').value;
    
        console.log("Tentative d'inscription avec : ", { pseudo, email, password });
    
        try {
            const response = await axios.post('/api/inscription', { pseudo, email, password });
    
            console.log('Réponse du serveur :', response.data);
    
            if (response.data.message) {
                alert(response.data.message); 
            }
            btnRunInscription.classList.remove("btn-loading"); // Enlève l'effet après chargement
            btnRunInscription.disabled = false; // Réactive le bouton
    
            //hideForms();
            //formConnexion.style.display = 'block';
            //divConnexion.style.display = 'block';
    
        } catch (error) {
            console.error('Erreur lors de l\'inscription :', error.response.data);
            alert('Erreur : ' + (error.response.data.message || 'Impossible de s\'inscrire.'));
        }
    });
    

   // Vérifie que formConnexion existe avant d'ajouter l'event listener
    formConnexion?.addEventListener('submit', async function (event) {
        event.preventDefault();
        btnRunConnexion.classList.add("btn-loading"); // Active l'effet
        btnRunConnexion.disabled = true; // Désactive le bouton
        
        const email = formConnexion.querySelector('input[type="email"]').value;
        const password = formConnexion.querySelector('input[type="password"]').value;

        console.log("Tentative de connexion avec :", { email, password });

        try {
            const response = await axios.post('/api/connexion', { email, password });
            console.log("Connexion réussie :", response.data);
            btnRunConnexion.classList.remove("btn-loading"); // Enlève l'effet après chargement
            btnRunConnexion.disabled = false; // Réactive le bouton
            
            // Redirige après connexion réussie
            window.location.href = '/';
        } catch (error) {
            if (error.response) {
                console.error("Erreur de connexion :", error.response.data);
            } else {
                console.error("Erreur inattendue :", error.message);
            }
        }
    });
});


function hideForms(){
    console.log("hideForms");
    for (let form of tabForms) {
        form.style.display = "none";
    }
}