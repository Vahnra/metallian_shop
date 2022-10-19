/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';

// Début JS pour le hover des dropdown bootstrap

// $(document).ready(function(){
//     $(".dropdown").hover(function(){
//         var dropdownMenu = $(this).children(".dropdown-menu");
//         if(dropdownMenu.is(":visible")){
//             dropdownMenu.parent().toggleClass("open");
//         }
//     });
    
// });

// document.getElementsByClassName('dropdown').addEventListener('mouseover', () => {
//     var dropdownMenu = document.getElementsByClassName('dropdown').children('dropdown-menu');
//     dropdownMenu.parentNode().classList.toggle('open');
// })

document.showDescription = function () {
    if(document.getElementById('description').style.cssText == 'display: none;'){
        document.getElementById('description').style.cssText = 'display: inline;';
        document.getElementById('fleche').classList.add('fa-minus');
        document.getElementById('fleche').classList.remove('fa-plus');
    }
    else {
        document.getElementById('description').style.cssText = 'display: none;';
        document.getElementById('fleche').classList.add('fa-plus');
        document.getElementById('fleche').classList.remove('fa-minus');
    }
}

document.imageSwap = function imageSwap(smallImg) {
    var fullImg = document.getElementById("imageBox");
    fullImg.src = smallImg.src;
}

// Bijoux filter
document.showColorFilterBijoux = function() {
    if(document.getElementById('bijoux_filter_form_Couleur').style.cssText == 'display: none;'){
        document.getElementById('bijoux_filter_form_Couleur').style.cssText = 'display: block; height: 10em; overflow-y: scroll';
        document.getElementById('flecheCouleur').classList.add('fa-minus');
        document.getElementById('flecheCouleur').classList.remove('fa-plus');    
    }
    else {
        document.getElementById('bijoux_filter_form_Couleur').style.cssText = 'display: none;';
        document.getElementById('flecheCouleur').classList.add('fa-plus');
        document.getElementById('flecheCouleur').classList.remove('fa-minus');
    }
}

// Chausures filter
document.showColorFilterChaussures = function() {
    if(document.getElementById('chaussures_filter_form_Couleur').style.cssText == 'display: none;'){
        document.getElementById('chaussures_filter_form_Couleur').style.cssText = 'display: block; height: 10em; overflow-y: scroll';
        document.getElementById('flecheCouleur').classList.add('fa-minus');
        document.getElementById('flecheCouleur').classList.remove('fa-plus');    
    }
    else {
        document.getElementById('chaussures_filter_form_Couleur').style.cssText = 'display: none;';
        document.getElementById('flecheCouleur').classList.add('fa-plus');
        document.getElementById('flecheCouleur').classList.remove('fa-minus');
    }
}

document.showSizeFilterChaussures = function() {
    if(document.getElementById('chaussures_filter_form_Size').style.cssText == 'display: none;'){
        document.getElementById('chaussures_filter_form_Size').style.cssText = 'display: block; height: 10em; overflow-y: scroll';
        document.getElementById('flecheSize').classList.add('fa-minus');
        document.getElementById('flecheSize').classList.remove('fa-plus');    
    }
    else {
        document.getElementById('chaussures_filter_form_Size').style.cssText = 'display: none;';
        document.getElementById('flecheSize').classList.add('fa-plus');
        document.getElementById('flecheSize').classList.remove('fa-minus');
    }
}

document.showMaterialFilterChaussures = function() {
    if(document.getElementById('chaussures_filter_form_material').style.cssText == 'display: none;'){
        document.getElementById('chaussures_filter_form_material').style.cssText = 'display: block; height: 10em; overflow-y: scroll';
        document.getElementById('flecheMaterial').classList.add('fa-minus');
        document.getElementById('flecheMaterial').classList.remove('fa-plus');    
    }
    else {
        document.getElementById('chaussures_filter_form_material').style.cssText = 'display: none;';
        document.getElementById('flecheMaterial').classList.add('fa-plus');
        document.getElementById('flecheMaterial').classList.remove('fa-minus');
    }
}

// Accessories filter
document.showColorFilterAccessoires = function() {
    if(document.getElementById('accessoires_filter_form_Couleur').style.cssText == 'display: none;'){
        document.getElementById('accessoires_filter_form_Couleur').style.cssText = 'display: block; height: 10em; overflow-y: scroll';
        document.getElementById('flecheCouleur').classList.add('fa-minus');
        document.getElementById('flecheCouleur').classList.remove('fa-plus');    
    }
    else {
        document.getElementById('accessoires_filter_form_Couleur').style.cssText = 'display: none;';
        document.getElementById('flecheCouleur').classList.add('fa-plus');
        document.getElementById('flecheCouleur').classList.remove('fa-minus');
    }
}

document.showMaterialFilterAccessoires = function() {
    if(document.getElementById('accessoires_filter_form_material').style.cssText == 'display: none;'){
        document.getElementById('accessoires_filter_form_material').style.cssText = 'display: block; height: 10em; overflow-y: scroll';
        document.getElementById('flecheMaterial').classList.add('fa-minus');
        document.getElementById('flecheMaterial').classList.remove('fa-plus');    
    }
    else {
        document.getElementById('accessoires_filter_form_material').style.cssText = 'display: none;';
        document.getElementById('flecheMaterial').classList.add('fa-plus');
        document.getElementById('flecheMaterial').classList.remove('fa-minus');
    }
}

// Accessories merchandising filter
document.showColorFilterAccessoiresMerchandising = function() {
    if(document.getElementById('accessoires_merchandising_filter_form_Couleur').style.cssText == 'display: none;'){
        document.getElementById('accessoires_merchandising_filter_form_Couleur').style.cssText = 'display: block; height: 10em; overflow-y: scroll';
        document.getElementById('flecheCouleur').classList.add('fa-minus');
        document.getElementById('flecheCouleur').classList.remove('fa-plus');    
    }
    else {
        document.getElementById('accessoires_merchandising_filter_form_Couleur').style.cssText = 'display: none;';
        document.getElementById('flecheCouleur').classList.add('fa-plus');
        document.getElementById('flecheCouleur').classList.remove('fa-minus');
    }
}

document.showMaterialFilterAccessoiresMerchandising = function() {
    if(document.getElementById('accessoires_merchandising_filter_form_material').style.cssText == 'display: none;'){
        document.getElementById('accessoires_merchandising_filter_form_material').style.cssText = 'display: block; height: 10em; overflow-y: scroll';
        document.getElementById('flecheMaterial').classList.add('fa-minus');
        document.getElementById('flecheMaterial').classList.remove('fa-plus');    
    }
    else {
        document.getElementById('accessoires_merchandising_filter_form_material').style.cssText = 'display: none;';
        document.getElementById('flecheMaterial').classList.add('fa-plus');
        document.getElementById('flecheMaterial').classList.remove('fa-minus');
    }
}

// Vetement filter
document.showColorFilterVetement = function() {
    if(document.getElementById('vetement_filter_form_Couleur').style.cssText == 'display: none;'){
        document.getElementById('vetement_filter_form_Couleur').style.cssText = 'display: block; height: 10em; overflow-y: scroll';
        document.getElementById('flecheCouleur').classList.add('fa-minus');
        document.getElementById('flecheCouleur').classList.remove('fa-plus');    
    }
    else {
        document.getElementById('vetement_filter_form_Couleur').style.cssText = 'display: none;';
        document.getElementById('flecheCouleur').classList.add('fa-plus');
        document.getElementById('flecheCouleur').classList.remove('fa-minus');
    }
}

document.showSizeFilterVetement = function() {
    if(document.getElementById('vetement_filter_form_Size').style.cssText == 'display: none;'){
        document.getElementById('vetement_filter_form_Size').style.cssText = 'display: block; height: 10em; overflow-y: scroll';
        document.getElementById('flecheSize').classList.add('fa-minus');
        document.getElementById('flecheSize').classList.remove('fa-plus');    
    }
    else {
        document.getElementById('vetement_filter_form_Size').style.cssText = 'display: none;';
        document.getElementById('flecheSize').classList.add('fa-plus');
        document.getElementById('flecheSize').classList.remove('fa-minus');
    }
}

document.showMaterialFilterVetement = function() {
    if(document.getElementById('vetement_filter_form_material').style.cssText == 'display: none;'){
        document.getElementById('vetement_filter_form_material').style.cssText = 'display: block; height: 10em; overflow-y: scroll';
        document.getElementById('flecheMaterial').classList.add('fa-minus');
        document.getElementById('flecheMaterial').classList.remove('fa-plus');    
    }
    else {
        document.getElementById('vetement_filter_form_material').style.cssText = 'display: none;';
        document.getElementById('flecheMaterial').classList.add('fa-plus');
        document.getElementById('flecheMaterial').classList.remove('fa-minus');
    }
}

document.showMarqueFilterVetement = function() {
    if(document.getElementById('vetement_filter_form_marque').style.cssText == 'display: none;'){
        document.getElementById('vetement_filter_form_marque').style.cssText = 'display: block; height: 10em; overflow-y: scroll';
        document.getElementById('flecheMarque').classList.add('fa-minus');
        document.getElementById('flecheMarque').classList.remove('fa-plus');    
    }
    else {
        document.getElementById('vetement_filter_form_marque').style.cssText = 'display: none;';
        document.getElementById('flecheMarque').classList.add('fa-plus');
        document.getElementById('flecheMarque').classList.remove('fa-minus');
    }
}

// Vetement mechandising filter
document.showColorFilterVetementMerchandising = function() {
    if(document.getElementById('vetement_merchandising_filter_form_Couleur').style.cssText == 'display: none;'){
        document.getElementById('vetement_merchandising_filter_form_Couleur').style.cssText = 'display: block; height: 10em; overflow-y: scroll';
        document.getElementById('flecheCouleur').classList.add('fa-minus');
        document.getElementById('flecheCouleur').classList.remove('fa-plus');    
    }
    else {
        document.getElementById('vetement_merchandising_filter_form_Couleur').style.cssText = 'display: none;';
        document.getElementById('flecheCouleur').classList.add('fa-plus');
        document.getElementById('flecheCouleur').classList.remove('fa-minus');
    }
}

document.showSizeFilterVetementMerchandising = function() {
    if(document.getElementById('vetement_merchandising_filter_form_Size').style.cssText == 'display: none;'){
        document.getElementById('vetement_merchandising_filter_form_Size').style.cssText = 'display: block; height: 10em; overflow-y: scroll';
        document.getElementById('flecheSize').classList.add('fa-minus');
        document.getElementById('flecheSize').classList.remove('fa-plus');    
    }
    else {
        document.getElementById('vetement_merchandising_filter_form_Size').style.cssText = 'display: none;';
        document.getElementById('flecheSize').classList.add('fa-plus');
        document.getElementById('flecheSize').classList.remove('fa-minus');
    }
}

document.showMaterialFilterVetementMerchandising = function() {
    if(document.getElementById('vetement_merchandising_filter_form_material').style.cssText == 'display: none;'){
        document.getElementById('vetement_merchandising_filter_form_material').style.cssText = 'display: block; height: 10em; overflow-y: scroll';
        document.getElementById('flecheMaterial').classList.add('fa-minus');
        document.getElementById('flecheMaterial').classList.remove('fa-plus');    
    }
    else {
        document.getElementById('vetement_merchandising_filter_form_material').style.cssText = 'display: none;';
        document.getElementById('flecheMaterial').classList.add('fa-plus');
        document.getElementById('flecheMaterial').classList.remove('fa-minus');
    }
}

document.showMarqueFilterVetementMerchandising = function() {
    if(document.getElementById('vetement_merchandising_filter_form_marque').style.cssText == 'display: none;'){
        document.getElementById('vetement_merchandising_filter_form_marque').style.cssText = 'display: block; height: 10em; overflow-y: scroll';
        document.getElementById('flecheMarque').classList.add('fa-minus');
        document.getElementById('flecheMarque').classList.remove('fa-plus');    
    }
    else {
        document.getElementById('vetement_merchandising_filter_form_marque').style.cssText = 'display: none;';
        document.getElementById('flecheMarque').classList.add('fa-plus');
        document.getElementById('flecheMarque').classList.remove('fa-minus');
    }
}

// Media form type
document.showMusicTypeFilterMedia = function() {
    if(document.getElementById('media_filter_form_musicType').style.cssText == 'display: none;'){
        document.getElementById('media_filter_form_musicType').style.cssText = 'display: block; height: 10em; overflow-y: scroll';
        document.getElementById('flecheMusicType').classList.add('fa-minus');
        document.getElementById('flecheMusicType').classList.remove('fa-plus');    
    }
    else {
        document.getElementById('media_filter_form_musicType').style.cssText = 'display: none;';
        document.getElementById('flecheMusicType').classList.add('fa-plus');
        document.getElementById('flecheMusicType').classList.remove('fa-minus');
    }
}

// Function pour le formtype al
document.showColorFilterAllFormFilter = function() {
    if(document.getElementById('all_filter_form_Couleur').style.cssText == 'display: none;'){
        document.getElementById('all_filter_form_Couleur').style.cssText = 'display: block; height: 10em; overflow-y: scroll';
        document.getElementById('flecheCouleur').classList.add('fa-minus');
        document.getElementById('flecheCouleur').classList.remove('fa-plus');    
    }
    else {
        document.getElementById('all_filter_form_Couleur').style.cssText = 'display: none;';
        document.getElementById('flecheCouleur').classList.add('fa-plus');
        document.getElementById('flecheCouleur').classList.remove('fa-minus');
    }
}

document.showSizeFilterAllFormFilter = function() {
    if(document.getElementById('all_filter_form_Size').style.cssText == 'display: none;'){
        document.getElementById('all_filter_form_Size').style.cssText = 'display: block; height: 10em; overflow-y: scroll';
        document.getElementById('flecheSize').classList.add('fa-minus');
        document.getElementById('flecheSize').classList.remove('fa-plus');    
    }
    else {
        document.getElementById('all_filter_form_Size').style.cssText = 'display: none;';
        document.getElementById('flecheSize').classList.add('fa-plus');
        document.getElementById('flecheSize').classList.remove('fa-minus');
    }
}

document.showMaterialFilterAllFormFilter = function() {
    if(document.getElementById('all_filter_form_material').style.cssText == 'display: none;'){
        document.getElementById('all_filter_form_material').style.cssText = 'display: block; height: 10em; overflow-y: scroll';
        document.getElementById('flecheMaterial').classList.add('fa-minus');
        document.getElementById('flecheMaterial').classList.remove('fa-plus');    
    }
    else {
        document.getElementById('all_filter_form_material').style.cssText = 'display: none;';
        document.getElementById('flecheMaterial').classList.add('fa-plus');
        document.getElementById('flecheMaterial').classList.remove('fa-minus');
    }
}

document.showMusicTypeFilterAllFormFilter = function() {
    if(document.getElementById('all_filter_form_musicType').style.cssText == 'display: none;'){
        document.getElementById('all_filter_form_musicType').style.cssText = 'display: block; height: 10em; overflow-y: scroll';
        document.getElementById('flecheMusicType').classList.add('fa-minus');
        document.getElementById('flecheMusicType').classList.remove('fa-plus');    
    }
    else {
        document.getElementById('all_filter_form_musicType').style.cssText = 'display: none;';
        document.getElementById('flecheMusicType').classList.add('fa-plus');
        document.getElementById('flecheMusicType').classList.remove('fa-minus');
    }
}

document.showMarqueFilterAllFormFilter = function() {
    if(document.getElementById('all_filter_form_marque').style.cssText == 'display: none;'){
        document.getElementById('all_filter_form_marque').style.cssText = 'display: block; height: 10em; overflow-y: scroll';
        document.getElementById('flecheMarque').classList.add('fa-minus');
        document.getElementById('flecheMarque').classList.remove('fa-plus');    
    }
    else {
        document.getElementById('all_filter_form_marque').style.cssText = 'display: none;';
        document.getElementById('flecheMarque').classList.add('fa-plus');
        document.getElementById('flecheMarque').classList.remove('fa-minus');
    }
}

// Fin JS pour le hover des dropdown bootstrap
