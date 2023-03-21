function addimg() {
    let nb = document.getElementById("nbimg");
    if (nb.value<3){
        nb.value = 1 + Number(nb.value);
        let input = document.createElement("input");
        input.type = "file";
        input.name = "fileToUpload";
        input.id = "fileToUpload" + nb.value;
        document.getElementById("imgs").insertAdjacentElement("afterend", input);
    }
}