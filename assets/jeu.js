document.addEventListener('DOMContentLoaded', function() {
    console.log(' -> Jeu js chargé');

    // => Gestion menu
    let btnMenuBook = document.getElementById('book');
    let btnMenuProfil = document.getElementById('profil');
    let btnMenuInventaire = document.getElementById('inventaire');
    

    btnMenuBook?.addEventListener('click', function(){
        console.log('click');
        window.location.href = '/jeu';
    });

    btnMenuProfil?.addEventListener('click', function(){
        console.log('click');
        window.location.href = '/profil';
    });

    btnMenuInventaire?.addEventListener('click', function(){
        console.log('click');
        window.location.href = '/inventaire';
    });

    // => Gestion des drag&drop
    const objets = document.querySelectorAll(".objet");
    const survivants = document.querySelectorAll(".dropzone");

    // Permet aux objets d'être glissés
    objets.forEach(objet => {
        objet.addEventListener("dragstart", (event) => {
            event.dataTransfer.setData("text/plain", event.target.id);
        });
    });

    // Permet aux survivants d'accepter le drop
    survivants.forEach(survivant => {
        survivant.addEventListener("dragover", (event) => {
            event.preventDefault(); // Nécessaire pour permettre le drop
            console.log('dragover');
        });

        survivant.addEventListener("drop", (event) => {
            event.preventDefault();
        
            const survivantId = survivant.getAttribute('data-id');
            
            // Récupère la faim actuelle
            const faimElement = document.getElementById(`faim-${survivantId}`);
            const faimText = faimElement.textContent.trim();
            
            // Affiche le texte de faim pour débogage
            console.log('Faim text récupéré:', faimText);

            // Extraire la valeur numérique après le texte "Satiété : " ou similaire
            const match = faimText.match(/(\d+)$/); // Recherche le nombre à la fin du texte
            let faim = match ? parseInt(match[1], 10) : NaN;
            
            // Déboguer la valeur de faim
            console.log('Valeur de faim après extraction:', faim);

            if (isNaN(faim)) {
                console.error('Erreur : valeur de faim non valide', faimText);
                return;
            }
            
            if (faim < 5) {  // Assure-toi que la faim n'excède pas 5
                faim += 1;
                faimElement.textContent = `Satiété : ${faim}`;  // Mise à jour du texte avec "Satiété : "
            }
            
            // Envoi de la requête pour mettre à jour la faim sur le serveur
            fetch("/updateFaim", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    survivantId: survivantId,  // Utilisation de l'ID du survivant
                    faim: faim  // Nouvelle valeur de faim
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log("Faim du survivant mise à jour !");
                    // Mise à jour du texte si nécessaire
                    faimElement.textContent = `Satiété : ${faim}`;  // Mise à jour du texte avec "Satiété : "
                } else {
                    console.log("Erreur lors de la mise à jour de la faim", data.message);
                }
            })
            .catch(error => {
                console.error("Erreur lors de la requête:", error);
            });
        });
    });
});
