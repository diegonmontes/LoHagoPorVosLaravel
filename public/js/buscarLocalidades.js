
function cargarLocalidades(idProvincia, localidadActual){
  $.get('/LoHagoPorVosLaravel/public/localidad/buscarporid/'+idProvincia, function(data){
    //esta el la peticion get, la cual se divide en tres partes. ruta,variables y funcion
      var opcionLocalidad = ''
      for (var i=0; i<data.length;i++)
      if (data[i].idLocalidad==localidadActual){
        opcionLocalidad+='<option value="'+data[i].idLocalidad+'" selected>'+data[i].nombreLocalidad+'</option>';
      } else {
        opcionLocalidad+='<option value="'+data[i].idLocalidad+'">'+data[i].nombreLocalidad+'</option>';
      }
      $("#idLocalidad").html(opcionLocalidad);
  });
}


