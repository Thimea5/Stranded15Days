import './bootstrap.js';
import './styles/app.css';
import './styles/menu.css';
import './styles/fonts.css';

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

    //formulaires
    let formConnexion = document.getElementById('form-connexion');
    let formInscription = document.getElementById('form-inscription');
    let divConnexion = document.getElementById('div-connexion')
    let divInscription = document.getElementById('div-inscription');
    tabForms.push(formConnexion);
    tabForms.push(formInscription);
    tabForms.push(divConnexion);
    tabForms.push(divInscription);

    btnConnexion.addEventListener('click', function(){
        event.preventDefault();
        console.log("Bouton connexion cliqué");
        hideForms();
        formConnexion.style.display = 'block';
        divConnexion.style.display = 'block';
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
        divInscription.style.display = 'block';
    });

    redirectConnexion.addEventListener('click', function(){
        event.preventDefault();
        hideForms();
        formConnexion.style.display = 'block';
       divConnexion.style.display = 'block';
    });

    redirectInscription.addEventListener('click', function(){
        event.preventDefault();
        hideForms();
        formInscription.style.display = 'block';
       divInscription.style.display = 'block';
    });

    // Soumission inscription 
    formInscription.addEventListener('submit', async function (event) {
        event.preventDefault(); 
        console.log('click');
    
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
    
            //hideForms();
            //formConnexion.style.display = 'block';
            //divConnexion.style.display = 'block';
    
        } catch (error) {
            console.error('Erreur lors de l\'inscription :', error.response.data);
            alert('Erreur : ' + (error.response.data.message || 'Impossible de s\'inscrire.'));
        }
    });
    

    // Soumission connexion
    formConnexion.addEventListener('submit', async function (event) {
        event.preventDefault();
        const email = formConnexion.querySelector('input[type="email"]').value;
        const password = formConnexion.querySelector('input[type="password"]').value;

        console.log("Tentative de connexion avec : ", { email, password });

        try {
            const response = await axios.post('/api/connexion', { email, password });

            console.log('Connexion réussie :', response.data);
            alert('Connexion réussie ! Bienvenue, ' + response.data.user.nom);

        } catch (error) {
            console.error('Erreur lors de la connexion :', error.response.data);
            alert('Erreur : ' + (error.response.data.message || 'Impossible de se connecter.'));
        }
    });
});


function hideForms(){
    console.log("hideForms");
    for (let form of tabForms) {
        form.style.display = "none";
    }
}