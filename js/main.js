function dropDownNav() {
    var x = document.getElementById("navbarSupportedContent");
    if (x.className === "collapse navbar-collapse"){
        x.className += " show";
    }else{
        x.className = "collapse navbar-collapse";
    }
}

function closealert() {
    const alert = document.getElementById("alert");
    alert.parentNode.removeChild(alert);
}