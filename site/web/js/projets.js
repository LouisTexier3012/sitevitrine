const proj = ["","","-button"]
let projetstart= localStorage.getItem("nomDuProjet");
if (projetstart!=null){
    localStorage.removeItem("nomDuProjet");
    changeprojet(projetstart);
}
function changeprojet(nom) {
    let div = document.getElementById(nom);
    let anciendiv= document.querySelector(".visible");
    anciendiv.classList.remove("visible");
    div.classList.add("visible");
    anciendiv.classList.add("cacher");
    div.classList.remove("cacher");
    let but = document.getElementById(nom+"-button");
    let ancienbut= document.querySelector(".selection");
    but.classList.add("selection");
    ancienbut.classList.remove("selection");
}
