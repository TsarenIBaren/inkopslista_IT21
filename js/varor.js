function saveProduct(){
    let varanode = document.getElementById('varainput');
    let vara = varanode.value;

    if(vara.trim() !=""){
        let FD = new FormData();
        FD.append("vara", vara);

        fetch(serverurl+'sparaVara.php',
        {
            method: 'POST',
            body: FD
        })
        .then(function(response){
            if (response.status == 200) {
                return response.json();
            }
        })
        .then(function (data) {
            getProducts();
        })
    }

    varanode.value="";

function editVaraForm(id){
    document.getElementById("varainput").value = document.getElementById("vara" + id).innerHTML;
    document.getElementById("varabutton"),onclick=function () {
        editProduct(id);
    }
    document.getElementById("varabutton").innerHTML="spara"
}

function editProduct(id){
    console.log("vara"+id);
}

function editProduct(){
    let varanode = document.getElementById('varainput');
    let vara = varanode.value;

    if(vara.trim() !=""){
        let FD = new FormData();
        FD.append("vara", vara);
        FD.append("id", id)

        fetch(serverurl+'uppdateraVara.php',
        {
            method: 'POST',
            body: FD
        })
        .then(function(response){
            if (response.status == 200) {
                return response.json();
            }
        })
        .then(function (data) {
            getProducts();
        })
    }

        varanode.value="";
    document.getElementById("varabutton").onclick=function () {
        saveProduct();
    }
    document.getElementById("varabutton").innerHTML= "Lägg till"
}
}

function deleteProduct(id,namn){
    if(confirm("Vill du radera "+namn+"?")){

    let FD = new FormData();
    FD.append("id", id);

    fetch (serverurl+'raderaVara.php',
        {
            method: 'POST',
            body: FD
        })
        .then (function(response) {
            if (response.status == 200) {
                return response.json();
            }
        })
        .then(function (data) {
            getProducts();
        })
    }
}

function deleteAllProducts(){

    if(confirm("Vill du radera alla varor?")){

    fetch (serverurl+'raderaAllaVaror.php',
        {
            method: 'POST',
        })
        .then (function(response) {
            if (response.status == 200) {
                return response.json();
            }
        })
        .then(function (data) {
            getProducts();
        })
    }
}

function deleteCheckedProducts(){

    if(confirm("Vill du radera alla valda varor?")){

    fetch (serverurl+'raderaValda.php',
        {
            method: 'POST',
        })
        .then (function(response) {
            if (response.status == 200) {
                return response.json();
            }
        })
        .then(function (data) {
            getProducts();
        })
    }
}

function checkProduct(id){

    let FD = new FormData();
    FD.append("id", id);

    fetch (serverurl+'kryssaVara.php',
        {
            method: 'POST',
            body: FD
        })
        .then (function(response) {
            if (response.status == 200) {
                return response.json();
            }
        })
        .then(function (data) {
            getProducts();
        })
}
