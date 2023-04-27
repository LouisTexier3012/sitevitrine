let projet="Site-Vitrine";
if (window.innerWidth > 768 && window.location.href !== "http://localhost/sitevitrine/site/web/projet.html") {
    let imageprojet =1;
    const nbpage = 4;
    const pages=["Accueil","Projet","ExpetEtu","Contact"];
    const nompages=["Accueil","Projets","Expériences","Contact"];
    let opacityfond =6;
    boutonpage(0);
    // window.addEventListener("wheel", function(event) {
    //     if (event.deltaY < 0) {
    //         // L'utilisateur fait défiler vers le haut
    //         pagehaut();
    //     } else if (event.deltaY > 0) {
    //         // L'utilisateur fait défiler vers le bas
    //         pagebas();
    //     }
    // });
    document.body.addEventListener('wheel', function(event) {});
    function boutonpage(iactu){
        let div = document.getElementById("pages")
        div.innerText="";
        let derniei =nbpage-1;
        if (iactu === derniei){
            derniei--;
        }
        for (let i=0; i<nbpage;i++){
            if (i!==iactu) {
                let bout = document.createElement("button");
                bout.innerText = nompages[i];
                bout.id = pages[i]+"bout";
                bout.classList.add("textfooter");
                bout.addEventListener("click", function (){miseajouurpage(i+1,iactu+1); boutonpage(i);});
                div.appendChild(bout);
            }
        }
    }

    function pagehaut(){
        let ancienindis = parseInt(window.getComputedStyle(document.body).getPropertyValue("background-image").split("fond-")[1].split(".")[0]);
        let nouveaufond = ancienindis-1;
        if (nouveaufond<1){
            nouveaufond=nbpage;
        }
        boutonpage(nouveaufond-1);
        miseajouurpage(nouveaufond,ancienindis);
    }

    function pagebas(){
        let ancienindis = parseInt(window.getComputedStyle(document.body).getPropertyValue("background-image").split("fond-")[1].split(".")[0]);
        let nouveaufond = ancienindis+1;
        if (nouveaufond>nbpage){
            nouveaufond=1;
        }
        boutonpage(nouveaufond-1);
        miseajouurpage(nouveaufond, ancienindis);

    }

    function miseajouurpage(nouveaufond, ancienfond){
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
        let divpage = document.getElementById("contenue");
        let chb= setInterval(function (){
            opacityfond=opacityfond+1;
            divpage.style.backgroundColor="rgb(0 0 0 / 0"+opacityfond+"%)";
            if (opacityfond>=100){
                clearInterval(chb);
                console.log()
                document.body.style.backgroundImage="url('./img/fond/fond-"+nouveaufond+".jpg')";
                rendrevidsible(false,document.getElementById(pages[ancienfond - 1]));
                rendrevidsible(true,document.getElementById(pages[nouveaufond - 1]));
                if (pages[nouveaufond - 1]==="Projet"){
                    survole();
                }
                let chbplus= setInterval(function (){
                    opacityfond=opacityfond-1;
                    divpage.style.backgroundColor="rgb(0 0 0 / 0"+opacityfond+"%)";
                    if (opacityfond<=6){
                        clearInterval(chbplus);
                    }
                },2)
            }
        },2);
    }

    function rendrevidsible(bool, element){
        if (bool===false){
            element.classList.add("cacher");
            element.classList.remove("page");
        }
        if (bool===true){
            element.classList.add("page");
            element.classList.remove("cacher");
        }
    }

    function survole(){
        const images = document.querySelectorAll('#projetimage img');
        images.forEach((image) => {
            const texteSurvol = image.nextElementSibling;
            image.addEventListener('mouseover', () => {
                texteSurvol.style.display = 'flex';
            });
            image.addEventListener('mouseout', () => {
                texteSurvol.style.display = 'none';
            });
        });
    }

    function prochainprojet(suivant){
        const imageactuel = document.getElementById("Projet-" + imageprojet);
        imageactuel.classList.add("cacher");
        imageactuel.style.display= 'none';
        console.log(imageactuel.classList)
        if (suivant === true) {
            imageprojet++;
            if (imageprojet > 4) {
                imageprojet = 1;
            }
            console.log(imageprojet)
            const newimage = document.getElementById("Projet-" + imageprojet);
            imageactuel.classList.remove("cacher");
            newimage.style.display= 'flex';
        }else{
            imageprojet--;
            if (imageprojet < 1) {
                imageprojet = 4;
            }
            console.log(imageprojet)
            const newimage = document.getElementById("Projet-" + imageprojet);
            imageactuel.classList.remove("cacher");
            newimage.style.display= 'flex ';
        }
    }

    function passageProjet(page = null){
        if (page!=null){
            projet=page;
        }
        localStorage.setItem("nomDuProjet", projet);
        window.location.href = "projet.html"
    }

}else if (window.innerWidth <= 768){
    window.location.href = "tel.html";
}