document.addEventListener("DOMContentLoaded", function () {
    console.log(" -> Jeu js chargé");

    // Gestion menu
    let btnMenuBook = document.getElementById("book");
    let btnMenuProfil = document.getElementById("profil");
    let btnMenuInventaire = document.getElementById("inventaire");

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
                    document.getElementById("affichage-jour").innerText = `Jour ${data.jour} sur 15`;
                    document.getElementById("affichage-satiete").innerText = `Satiété : ${data.faim}`;
                    document.getElementById("affichage-soif").innerText = `Soif : ${data.soif}`;
                    document.getElementById("affichage-sante").innerText = `Santé : ${data.sante}`;
                } else {
                    alert("Action impossible !");
                }
            } catch (error) {
                console.error('Erreur lors de la requête :', error);
            }
        });
    });
});
