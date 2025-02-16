document.addEventListener('DOMContentLoaded', function() {
    console.log(' -> Jeu js chargé');

    // Gestion menu
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

    // Gestion des drag & drop
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

        survivant.addEventListener("drop", async (event) => {  // Ajout de async ici
            event.preventDefault();

            const survivantId = survivant.id.split('-')[1];


            console.log(survivantId);


            // Récupère la faim actuelle
            const faimElement = document.getElementById(`faim-${survivantId}`);
            const faimText = faimElement.textContent.trim();
            const match = faimText.match(/(\d+)$/);
            let faim = match ? parseInt(match[1], 10) : NaN;

            if (isNaN(faim)) {
                console.error('Erreur : valeur de faim non valide', faimText);
                return;
            }

            if (faim < 5) {  // La faim ne peut pas dépasser 5
                faim += 1;
                faimElement.textContent = `Satiété : ${faim}`;
            }

            // Envoi des données au serveur
            try {
                const response = await axios.post('/updateFaim', {
                    survivantId: survivantId,
                    faim: 1
                });

                console.log('Réponse serveur:', response.data);
            } catch (error) {
                console.error('Erreur lors de la requête:', error);
            }
        });
    });
});
