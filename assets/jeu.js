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

    const actions = document.querySelectorAll(".card");

    actions.forEach(action => {
        action.addEventListener("click", function () {
            let type = "";
            if (this.querySelector("h5").innerText.includes("nourriture")) type = "faim";
            if (this.querySelector("h5").innerText.includes("eau")) type = "soif";
            if (this.querySelector("h5").innerText.includes("reposer")) type = "sante";

            if (type) {
                fetch("/jeu/action", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-Requested-With": "XMLHttpRequest"
                    },
                    body: JSON.stringify({ type: type })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.querySelector("h2").innerText = "Jour " + data.niveau;
                        document.querySelector("p:nth-child(1)").innerText = "Satiété : " + data.faim;
                        document.querySelector("p:nth-child(2)").innerText = "Soif : " + data.soif;
                        document.querySelector("p:nth-child(3)").innerText = "Santé : " + data.sante;
                    } else {
                        alert("Action impossible !");
                    }
                });
            }
        });
    });

    
});
