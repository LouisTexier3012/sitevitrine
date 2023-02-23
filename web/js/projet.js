miseajour(1);
let nbpage = 2;
window.addEventListener("wheel", function(event) {
    let opacity =6;
    if (event.deltaY < 0) {
        // L'utilisateur fait défiler vers le haut
        let page = document.getElementById("page");
        let ancienindis = parseInt(window.getComputedStyle(document.body).getPropertyValue("background-image").split("fond-")[1].split(".")[0]);
        let nouveaufond = ancienindis-1;
        if (nouveaufond<1){
            nouveaufond=2;
        }
        let chb= setInterval(function (){
            opacity=opacity+1;
            page.innerText="";
            page.style.backgroundColor="rgb(0 0 0 / 0"+opacity+"%)";
            if (opacity>=100){
                document.body.style.backgroundImage="url('img/fond/fond-"+nouveaufond+".jpg')";
                miseajour(nouveaufond);
                clearInterval(chb);
                let chbplus= setInterval(function (){
                    opacity=opacity-1;
                    page.style.backgroundColor="rgb(0 0 0 / 0"+opacity+"%)";
                    if (opacity<=6){
                        clearInterval(chbplus);
                    }
                },2)
            }
        },2);
    } else if (event.deltaY > 0) {
        // L'utilisateur fait défiler vers le bas
        let ancienindis = parseInt(window.getComputedStyle(document.body).getPropertyValue("background-image").split("fond-")[1].split(".")[0]);
        let nouveaufond = ancienindis+1;
        if (nouveaufond>nbpage){
            nouveaufond=1;
        }
        let chb= setInterval(function (){
            opacity=opacity+1;
            page.innerText="";
            page.style.backgroundColor="rgb(0 0 0 / 0"+opacity+"%)";
            if (opacity>=100){
                document.body.style.backgroundImage="url('img/fond/fond-"+nouveaufond+".jpg')";
                miseajour(nouveaufond);
                clearInterval(chb);
                let chbplus= setInterval(function (){
                    opacity=opacity-1;
                    page.style.backgroundColor="rgb(0 0 0 / 0"+opacity+"%)";
                    if (opacity<=6){
                        clearInterval(chbplus);
                    }
                },2)
            }
        },2);
    }
});

function miseajour(i){
    const fonctions = [miseajour1, miseajour2];// tableau des fonctions à appeler
    const index = i - 1; // ajustement de l'index pour correspondre à la position du tableau

    if (fonctions[index]) {
        fonctions[index](); // appel de la fonction correspondante
    } else {
        console.log("La fonction correspondante n'a pas été trouvée !");
    }
}

function miseajour1(){
    let main = document.getElementById("page");
    main.innerHTML="";
    let nom =document.createElement("p");
    nom.innerText="Louis TEXIER";
    nom.id="nom";
    nom.style.fontWeight="bold";
    main.appendChild(nom);
    adaptertext(nom.id,100,80,100, '#362d2d');
    let intitule =document.createElement("p");
    intitule.innerText="Etudiant en BUT informatique";
    intitule.id="intitule";
    main.appendChild(intitule);
    adaptertext(intitule.id,220,80,70,'#1c1717');
}

function miseajour2(){
    let main = document.getElementById("page");
    main.innerHTML="";
    let nom =document.createElement("p");
    nom.innerText="Projets";
    nom.id="proj";
    nom.style.fontWeight="bold";
    main.appendChild(nom);
    adaptertext(nom.id,100,80,100);
}

function adaptertext(id, top, left, size, color= '#f5e9e9'){
    let element = document.getElementById(id);
    element.style.top=top+"px";
    element.style.left=left+"px";
    element.style.fontSize=size+"px";
    element.style.position="absolute";
    element.style.color=color;
}