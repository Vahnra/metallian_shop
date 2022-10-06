function showColorFilter() {
    if(document.getElementById('form_Couleur').style.cssText == 'display: none;'){
        document.getElementById('form_Couleur').style.cssText = 'display: block; height: 10em; overflow-y: scroll';
        document.getElementById('flecheCouleur').classList.add('fa-minus');
        document.getElementById('flecheCouleur').classList.remove('fa-plus');    
    }
    else {
        document.getElementById('form_Couleur').style.cssText = 'display: none;';
        document.getElementById('flecheCouleur').classList.add('fa-plus');
        document.getElementById('flecheCouleur').classList.remove('fa-minus');
    }
}

function showSizeFilter() {
    if(document.getElementById('form_Size').style.cssText == 'display: none;'){
        document.getElementById('form_Size').style.cssText = 'display: block; height: 10em; overflow-y: scroll';
        document.getElementById('flecheSize').classList.add('fa-minus');
        document.getElementById('flecheSize').classList.remove('fa-plus');    
    }
    else {
        document.getElementById('form_Size').style.cssText = 'display: none;';
        document.getElementById('flecheSize').classList.add('fa-plus');
        document.getElementById('flecheSize').classList.remove('fa-minus');
    }
}

function showMaterialFilter() {
    if(document.getElementById('form_material').style.cssText == 'display: none;'){
        document.getElementById('form_material').style.cssText = 'display: block; height: 10em; overflow-y: scroll';
        document.getElementById('flecheMaterial').classList.add('fa-minus');
        document.getElementById('flecheMaterial').classList.remove('fa-plus');    
    }
    else {
        document.getElementById('form_material').style.cssText = 'display: none;';
        document.getElementById('flecheMaterial').classList.add('fa-plus');
        document.getElementById('flecheMaterial').classList.remove('fa-minus');
    }
}

function showMusicTypeFilter() {
    if(document.getElementById('form_musicType').style.cssText == 'display: none;'){
        document.getElementById('form_musicType').style.cssText = 'display: block; height: 10em; overflow-y: scroll';
        document.getElementById('flecheMusicType').classList.add('fa-minus');
        document.getElementById('flecheMusicType').classList.remove('fa-plus');    
    }
    else {
        document.getElementById('form_musicType').style.cssText = 'display: none;';
        document.getElementById('flecheMusicType').classList.add('fa-plus');
        document.getElementById('flecheMusicType').classList.remove('fa-minus');
    }
}

function showMarqueFilter() {
    if(document.getElementById('form_marque').style.cssText == 'display: none;'){
        document.getElementById('form_marque').style.cssText = 'display: block; height: 10em; overflow-y: scroll';
        document.getElementById('flecheMarque').classList.add('fa-minus');
        document.getElementById('flecheMarque').classList.remove('fa-plus');    
    }
    else {
        document.getElementById('form_marque').style.cssText = 'display: none;';
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
