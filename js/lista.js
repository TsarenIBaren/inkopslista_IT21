serverurl='php/'

window.onload = function(){
    getProducts();
    document.getElementById("varabutton").onclick = function(){
        saveProduct();
    }
    document.getElementById("allabutton").onclick = function(){
        deleteAllProducts();
    }
    document.getElementById("valdabutton").onclick = function(){
        deleteCheckedProducts();
    }
}

function getProducts(){
    fetch(serverurl+'hamtaAlla.php')
        .then(function (response) {
            if (response.status == 200) {
                return response.json();
            }
        })
        .then(function(data) {
            appendProducts(data);
        })
}

function appendProducts(data){
    console.log(data);
    tabell=document.getElementById("varaTable");
    tabell.innerHTML="";

    for(let i=0;i<data.length;i++){
        let rad=document.createElement("tr");

        let checkboxtd=document.createElement("td");
        let checkbox=document.createElement("input");
        checkbox.setAttribute("type", "checkbox");
        if (data[i].checked) {
            checkbox.checked=1;
        }
        checkbox.onclick=function(){
            checkProduct(data[i].id);
            console.log(data[i]);
            // data.id är inte ett ID
        }
        checkboxtd.appendChild(checkbox);

        let texttd=document.createElement("td");
        texttd.id="vara"+data[i].id;
        texttd.innerHTML=data[i].namn;
        
        let redigeratd=document.createElement("td");
        let redigeraicon=document.createElement("i");
        redigeraicon.classList.add("material-icons");
        redigeraicon.innerHTML="edit";
        redigeraicon.onclick=function(){
            editVaraForm(data[i].id);
        }
        redigeratd.appendChild(redigeraicon);

        let raderatd=document.createElement("td");
        let raderaicon=document.createElement("i");
        raderaicon.classList.add("material-icons");
        raderaicon.innerHTML="delete";
        raderaicon.onclick=function(){
            deleteProduct(data[i].id, data[i].namn);
        }
        raderatd.appendChild(raderaicon);

        rad.appendChild(checkboxtd);
        rad.appendChild(texttd);
        rad.appendChild(redigeratd);
        rad.appendChild(raderatd);
        tabell.appendChild(rad);

    }
} 