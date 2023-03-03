const fonctions = [miseajour1, miseajour2];
const actualité ="Étudiant en 2 ème année de BUT informatique, je recherche un stage\n de 12 semaine à partir du 17 avril, dans le développement WEB.";
const desc ="Je suis une personne capable d'apprendre assez rapidement et de m'adapté\n" +
            " dans des situation complexe ou en manque de temps.\n " +
            "Je suis passionné par le développement WEB et cherche a en apprendre plus.\n" +
            "je suis tres autonome mais sais faire de mon mieux en travaillant en groupe.";
const nbpage = 2;
const page=["Accueil","Projet"];
let opacityfond =6;
miseajour(1);
boutonpage(0);
window.addEventListener("wheel", function(event) {
    if (event.deltaY < 0) {
        // L'utilisateur fait défiler vers le haut
        pagehaut();
    } else if (event.deltaY > 0) {
        // L'utilisateur fait défiler vers le bas
        pagebas();
    }
});
function boutonpage(iactu){
    let div = document.getElementById("pages")
    div.innerText="";
    for (let i=0; i<nbpage;i++){
        if (i!==iactu) {
            let bout = document.createElement("button");
            bout.innerText = page[i];
            bout.id = page[i];
            bout.addEventListener("click", function (){miseajouurpage(i+1); boutonpage(i);});
            div.appendChild(bout);
        }
    }
}

function miseajour(i){// tableau des fonctions à appeler
    const index = i - 1; // ajustement de l'index pour correspondre à la position du tableau
    document.title=page[index];
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
    let titredescr =document.createElement("p");
    titredescr.innerText="Description:";
    titredescr.id="tdesc";
    titredescr.style.fontWeight="bold";
    main.appendChild(titredescr);
    adaptertext(titredescr.id,450,80,50,'#362d2d');
    let descr =document.createElement("p");
    descr.innerText=desc;
    descr.id="desc";
    descr.style.fontWeight="bold";
    main.appendChild(descr);
    adaptertext(descr.id,525,85,30, '#362d2d');
    let titreactu =document.createElement("p");
    titreactu.innerText="Actualité:";
    titreactu.id="tactu";
    titreactu.style.fontWeight="bold";
    main.appendChild(titreactu);
    adaptertext(titreactu.id,700,80,50,'#362d2d');
    let actu =document.createElement("p");
    actu.innerText=actualité;
    actu.id="actu";
    actu.style.fontWeight="bold";
    main.appendChild(actu);
    adaptertext(actu.id,775,85,30, '#362d2d');
    let intitule =document.createElement("p");
    intitule.innerText="Etudiant en BUT informatique";
    intitule.id="intitule";
    main.appendChild(intitule);
    adaptertext(intitule.id,220,80,70,'#1c1717');
    let language =document.createElement("p");
    language.innerText="Langage maîtrisé:";
    language.id="language";
    language.style.fontWeight="bold";
    main.appendChild(language);
    adaptertext(language.id,250,1500,50,'#362d2d');
    const nomlang=["HTML","PHP","CSS","Java Script"];
    for (let i=0; i<4; i++) {
        let image = document.createElement("img");
        image.src="./img/langage/langage ("+i+").png";
        image.style.position="absolute";
        image.style.top="380px";
        const left = 1550+(120*i);
        image.style.left=left+"px";
        image.style.height="120px";
        image.style.width="120px";
        image.title=nomlang[i];
        main.appendChild(image);
    }
    let logiciel =document.createElement("p");
    logiciel.innerText="Logiciel Utilisé:";
    logiciel.id="logiciel";
    logiciel.style.fontWeight="bold";
    main.appendChild(logiciel);
    adaptertext(logiciel.id,500,1500,50,'#362d2d');
    const nomlog=["PhpStorm","intellij"];
    for (let i=0; i<2; i++) {
        let imagelog = document.createElement("img");
        imagelog.src="./img/langage/logiciel ("+i+").png";
        imagelog.style.position="absolute";
        imagelog.style.top="620px";
        const left = 1560+(120*(i));
        imagelog.style.left=left+"px";
        imagelog.style.height="120px";
        imagelog.style.width="120px";
        imagelog.title=nomlog[i];
        main.appendChild(imagelog);
    }
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
    addImage();
}

function adaptertext(id, top, left, size, color= '#f5e9e9'){
    let element = document.getElementById(id);
    element.style.top=top+"px";
    element.style.left=left+"px";
    element.style.fontSize=size+"px";
    element.style.position="absolute";
    element.style.color=color;
}

function pagehaut(){
    let ancienindis = parseInt(window.getComputedStyle(document.body).getPropertyValue("background-image").split("fond-")[1].split(".")[0]);
    let nouveaufond = ancienindis-1;
    if (nouveaufond<1){
        nouveaufond=nbpage;
    }
    boutonpage(nouveaufond-1);
    miseajouurpage(nouveaufond);
}

function pagebas(){
    let ancienindis = parseInt(window.getComputedStyle(document.body).getPropertyValue("background-image").split("fond-")[1].split(".")[0]);
    let nouveaufond = ancienindis+1;
    if (nouveaufond>nbpage){
        nouveaufond=1;
    }
    boutonpage(nouveaufond-1);
    miseajouurpage(nouveaufond);

}

function miseajouurpage(nouveaufond){
    if (nouveaufond>=nbpage){
        let bt = document.getElementById("bas");
        bt.classList.add("cacher");
        bt.classList.remove("visible");
    }else{
        let bt = document.getElementById("bas");
        bt.classList.add("visible");
        bt.classList.remove("cacher");
    }
    if (nouveaufond<=1){
        let bt = document.getElementById("haut");
        bt.classList.add("cacher");
        bt.classList.remove("visible");
    }else{
        let bt = document.getElementById("haut");
        bt.classList.add("visible");
        bt.classList.remove("cacher");
    }
    let page = document.getElementById("page");
    let chb= setInterval(function (){
        opacityfond=opacityfond+1;
        page.innerText="";
        page.style.backgroundColor="rgb(0 0 0 / 0"+opacityfond+"%)";
        if (opacityfond>=100){
            document.body.style.backgroundImage="url('img/fond/fond-"+nouveaufond+".jpg')";
            miseajour(nouveaufond);
            clearInterval(chb);
            let chbplus= setInterval(function (){
                opacityfond=opacityfond-1;
                page.style.backgroundColor="rgb(0 0 0 / 0"+opacityfond+"%)";
                if (opacityfond<=6){
                    clearInterval(chbplus);
                }
            },2)
        }
    },2);
}