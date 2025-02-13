document.addEventListener('DOMContentLoaded', function() {
    console.log(' -> Jeu js chargé');

    // => Gestion menu
    let btnMenuBook = document.getElementById('book');
    let btnMenuProfil = document.getElementById('profil');
    let btnsChoix = document.querySelectorAll('.choix-description'); // Sélectionne tous les éléments avec la classe

    btnMenuBook?.addEventListener('click', function(){
        console.log('click');
        window.location.href = '/jeu';
    });

    btnMenuProfil?.addEventListener('click', function(){
        console.log('click');

        window.location.href = '/profil';
    });


});
