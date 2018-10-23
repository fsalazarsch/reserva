<?php
include 'header.php';
?>


  <div class="row">
    <div class="col s12">
      <div class="card blue darken-1">
        <div class="card-content white-text">
          <span class="card-title" id="titulo"></span>
          <p id="descripcion"></p>
        </div>
        <div class="card-action">
          <a id="precio"></a>
          
        </div>
      </div>
    </div>
  </div>


<div class="row">
    <form class="col s12" method="POST" action="../api/agendar/" onsubmit="return validar()">
      <div class="row">

          <input type="hidden" class="hidden" name="nro_actividad" id="nro_actividad">
          <input type="hidden" class="hidden" name="form_precio" id="form_precio">

        <div class="input-field col s6">
            <input type="date" id="fecha" name="fecha" class="validate">
          <label for="fecha">Fecha</label>
        </div>
        <div class="input-field col s6">
          <input id="numero" name="numero" type="number">
          <label for="numero">Numero de Personas</label>
        </div>
      </div>
      <button class="btn waves-effect waves-light" type="submit" name="action">Agendar
    <i class="material-icons right">send</i>
  </button>


    </form>
  </div>


  <script>

function validar(){
  if ($("#numero").val() <= 0 ){
      alert("Número debe ser mayor a cero");
      return false;
    }

  if ($("#numero").val() == '' ){
      alert("Número debe ser válido");
      return false;
    }

  if ($("#fecha").val() == '' ){
      alert("Fecha debe ser válida");
      return false;
    }

  var hoy = new Date();
  if ( new Date($("#fecha").val()).getTime() < hoy.getTime() ){
      alert("Fecha debe ser después al día de hoy");
      return false;
    }
    

  
  }

$(document).ready(function(){
  $.ajax({
    url: "/denomades/api/actividades/<?= $nombre; ?>",
    dataType: "JSON",
    success: function(data){

       $('#titulo').html( data['actividad'][0].name);
       $('#descripcion').html( data['actividad'][0].description);
       $('#precio').html( "Precio: "+data['actividad'][0].price);
       $('#form_precio').val(data['actividad'][0].price);
       $('#nro_actividad').val(data['actividad'][0].id);
    
    }
})



});
</script>

</body>
</html>
