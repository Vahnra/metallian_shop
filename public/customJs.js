// Bijoux filter
function showColorFilterBijoux() {
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
function showColorFilterChaussures() {
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

function showSizeFilterChaussures() {
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

function showMaterialFilterChaussures() {
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
function showColorFilterAccessoires() {
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

function showMaterialFilterAccessoires() {
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
function showColorFilterAccessoiresMerchandising() {
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

function showMaterialFilterAccessoiresMerchandising() {
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
function showColorFilterVetement() {
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

function showSizeFilterVetement() {
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

function showMaterialFilterVetement() {
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

function showMarqueFilterVetement() {
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
function showColorFilterVetementMerchandising() {
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

function showSizeFilterVetementMerchandising() {
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

function showMaterialFilterVetementMerchandising() {
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

function showMarqueFilterVetementMerchandising() {
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
function showMusicTypeFilterMedia() {
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
function showColorFilterAllFormFilter() {
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

function showSizeFilterAllFormFilter() {
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

function showMaterialFilterAllFormFilter() {
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

function showMusicTypeFilterAllFormFilter() {
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

function showMarqueFilterAllFormFilter() {
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

function showDescription() {
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

function imageSwap(smallImg) {
    var fullImg = document.getElementById("imageBox");
    fullImg.src = smallImg.src;
}
