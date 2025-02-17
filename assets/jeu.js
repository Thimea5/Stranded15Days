document.addEventListener("DOMContentLoaded", function () {
    console.log(" -> Jeu js chargé");

    // Gestion menu
    let btnMenuBook = document.getElementById("book");
    let btnMenuProfil = document.getElementById("profil");
    let btnMenuInventaire = document.getElementById("inventaire");
    let btnReset = document.getElementById('btn-reset');
    let formFinal = document.getElementById("form-final");
    let divFinal = document.getElementById("div-final");
    let btnFormFinal = document.getElementById("btnFormFinal");

    btnReset?.addEventListener('click', function(event){
        event.preventDefault();
        btnReset.classList.add("btn-loading");
        btnReset.disabled = true; 
    
        axios.post('/jeu/reset')
            .then(response => {
                btnReset.classList.remove("btn-loading"); 
                btnReset.disabled = false; 
    
                const data = response.data;
    
                document.getElementById("affichage-jour").innerText = `Jour ${data.jour} sur 15`;
                document.getElementById("affichage-satiete").innerText = `Satiété : ${data.faim}`;
                document.getElementById("affichage-soif").innerText = `Soif : ${data.soif}`;
                document.getElementById("affichage-sante").innerText = `Santé : ${data.sante}`;
    
                // Mise à jour des découvertes
                if (data.decouvertes) {
                    Object.keys(data.decouvertes).forEach(id => {
                        const elem = document.querySelector(`#info-${id}`);
                        if (elem) {
                            elem.innerText = data.decouvertes[id] ? "Découvert" : "Non découvert";
                        }
                    });
                }
            })
            .catch(error => {
                console.error("Erreur lors du reset :", error);
            });
    });
    

    btnMenuBook?.addEventListener("click", function () {
        console.log("click");
        window.location.href = "/jeu";
    });

    btnMenuProfil?.addEventListener("click", function () {
        console.log("click");
        window.location.href = "/profil";
    });

    btnMenuInventaire?.addEventListener("click", function () {
        console.log("click");
        window.location.href = "/inventaire";
    });

    const actions = document.querySelectorAll(".card");

    actions.forEach((action) => {
        action.addEventListener("click", async function () {
            let type = this.getAttribute("data-id");
            try {
                const response = await axios.post('/jeu/action', { type });
        
                console.log('Réponse du serveur :', response.data);
        
                const data = response.data;
                if (data.success) {
                    // Mettre à jour les valeurs affichées dans le DOM
                    if(document.getElementById("affichage-jour")){
                        document.getElementById("affichage-jour").innerText = `Jour ${data.jour} sur 15`;
                    }
                    document.getElementById("affichage-satiete").innerText = `Satiété : ${data.faim}`;
                    document.getElementById("affichage-soif").innerText = `Soif : ${data.soif}`;
                    document.getElementById("affichage-sante").innerText = `Santé : ${data.sante}`;

                    // Si le jour est 15, affiche le formulaire
                    if (data.jour === 15) {
                        document.getElementById("div-final").style.display = "block";
                        document.getElementById("form-final").style.display = "block";
                    }

                    if(data.faim <= 0 || data.soif <= 0 || data.sante <= 0){
                        alert("Vous avez perdu ! Votre personnage est mort...");
                        axios.post('/jeu/reset')
                            .then(response => {
                                btnReset.classList.remove("btn-loading"); 
                                btnReset.disabled = false; 
        
                                const data = response.data;
        
                                document.getElementById("affichage-jour").innerText = `Jour ${data.jour} sur 15`;
                                document.getElementById("affichage-satiete").innerText = `Satiété : ${data.faim}`;
                                document.getElementById("affichage-soif").innerText = `Soif : ${data.soif}`;
                                document.getElementById("affichage-sante").innerText = `Santé : ${data.sante}`;
        
                                // Mise à jour des découvertes
                                if (data.decouvertes) {
                                    Object.keys(data.decouvertes).forEach(id => {
                                        const elem = document.querySelector(`#info-${id}`);
                                        if (elem) {
                                            elem.innerText = data.decouvertes[id] ? "Découvert" : "Non découvert";
                                        }
                                    });
                                }

                                if (data.jour === 15) {
                                    document.getElementById("div-final").style.display = "block";
                                    document.getElementById("form-final").style.display = "block";
                                }
                            })
                            .catch(error => {
                                console.error("Erreur lors du reset :", error);
                            });
                    }
                } else {
                    alert("Action impossible !");
                }
            } catch (error) {
                console.error('Erreur lors de la requête :', error);
            }
        });
    });

    // Vérification du mot de passe
    formFinal?.addEventListener('submit', function (event) {
        event.preventDefault();

        const mot = document.getElementById("mot").value.trim().toLowerCase(); // Récupère et normalise l'input
        const messageElement = document.createElement('div');
        messageElement.classList.add('alert');

        if (mot === "esperance") {
            messageElement.classList.add('alert-success');
            messageElement.innerText = "Félicitations, vous avez trouvé le bon mot de passe ! Vous avez gagné.";
        } else {
            messageElement.classList.add('alert-danger');
            messageElement.innerText = "Désolé, ce n'est pas le bon mot de passe. Vous avez perdu.";
            btnReset.click();
            window.location.href = "/jeu";
        }

        // Affichage du message de résultat
        divFinal.appendChild(messageElement);
        formFinal.style.display = 'none'; // Cacher le formulaire après soumission
    });
});
