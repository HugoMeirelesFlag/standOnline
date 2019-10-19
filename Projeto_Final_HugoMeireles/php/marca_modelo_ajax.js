document.getElementById("marca").addEventListener("change",function() {
    let valorseleccionado=this.value;
    $.ajax({
    url: 'modelo.php',
    type: 'GET',
    data: {cod_marca : valorseleccionado},
    dataType: "json",
    cache: false,
    success: function(dados){
        console.log(dados);
        select = document.getElementById('modelo');
        while (select.firstChild !== (d= select.lastChild)) { select.removeChild(d); }
        $.each(dados,function(indice,elemento) {
            var opt = document.createElement('option');
            opt.value = elemento.cod_modelo;
            opt.innerHTML = elemento.modelo;
            select.appendChild(opt);
        });
    },
    error: function(jqXHR, textStatus, errorThrown) {
        alert("Error!\nTextStatus="+textStatus+"\nErrorThrown="+errorThrown);
    }
});
},false);

document.getElementById("btsubmit").addEventListener("click",function() {
    cod_marca = document.getElementById('marca');
    cod_modelo = document.getElementById('modelo');
    combustivel = document.getElementById('combustivel');
    window.location.href="index.php?cod_marca="+cod_marca.value+"&cod_modelo="+cod_modelo.value+"&combustivel="+combustivel.value;
},false);