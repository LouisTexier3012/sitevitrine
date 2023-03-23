$bouton = document.getElementById("remove");
document.getElementById("img-container").removeChild($bouton);

function addimg() {
    console.log("izpij")
    let nb = document.getElementById("nb-img");
    if (nb.value<3){
        nb.value = 1 + Number(nb.value);
        let input = document.createElement("input");
        input.type = "file";
        input.name = "fileToUpload"+ nb.value;
        input.id = "fileToUpload" + nb.value;
        document.getElementById("imgs").append(input);
    }
    if (Number(nb.value)===1){
        document.getElementById("img-container").insertBefore($bouton, document.getElementById("add"));
    }
}

function remove() {
    let nb = document.getElementById("nb-img");
    console.log(nb.value)
    if (nb.value>0){
        // document.getElementById("imgs").removeChild(document.getElementById("fileToUpload"+nb.value));
        document.getElementById("imgs").removeChild(document.getElementById("fileToUpload" + nb.value));
        nb.value = Number(nb.value) - 1;
    }if (nb.value<1){
        console.log(document.getElementById("img-container"))
        document.getElementById("img-container").removeChild($bouton);
    }
}