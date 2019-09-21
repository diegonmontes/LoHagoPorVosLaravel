$(document).ready(function(){
  var valorInicial = $('select#idProvincia').val();
  cargarLocalidades(valorInicial);

    $("#idProvincia").change(function(){
      var idProvincia = $(this).val();
      cargarLocalidades(idProvincia);
    });

    $('#borrarCampos').click(function() {
        $('input[type="text"]').val('');
        $('select[name="idProvincia"]').val('20');
        cargarLocalidades(20);
    });
});

function cargarLocalidades(idProvincia){
  $.get('../localidad/buscar/'+idProvincia, function(data){
    //esta el la peticion get, la cual se divide en tres partes. ruta,variables y funcion
      var opcionLocalidad = ''
      for (var i=0; i<data.length;i++)
      opcionLocalidad+='<option value="'+data[i].idLocalidad+'">'+data[i].nombreLocalidad+'</option>';

      $("#idLocalidad").html(opcionLocalidad);
  });
}


