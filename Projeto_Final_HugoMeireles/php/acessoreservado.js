$(document).ready(function() {
    $('table').DataTable( {
        responsive: true,
        "pageLength": 10
    } );
} );




$("select").change(function () {
    if (confirm('Tens a certeza que pretendes alterar o estado?')) {
        console.log($(this).find(':selected').data('id'));
        console.log($(this).val());
        window.location.href = 'acesso_reservado.php?alterarutilizador='+$(this).find(':selected').data('id')+'&estado='+$(this).val();
    }
    
});