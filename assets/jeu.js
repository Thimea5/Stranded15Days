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

});
