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
}