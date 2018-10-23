<?php
include 'header.php';
?>
      <table class="highlight">
        <thead>
          <tr>
              <th>ID</th>
              <th>Actividad</th>
              <th>Cantidad de Personas</th>
              <th>Precio por Persona</th>
              <th>Total</th>
          </tr>
        </thead>

        <tbody id="cuerpo">
        </tbody>
      </table>

      
    </div>
  </div>

<script>
$(document).ready(function()
{
  $.ajax({
    url: "/denomades/api/reservas/",
    dataType: "JSON",
    success: function(data){
      var tot = '';
      for(var i=0;i<data['reservas'].length;i++){
            tot += '<tr>';
            tot += '<td>'+data['reservas'][i].id+'</td>';
            tot += '<td>'+data['reservas'][i].activity_id+'</td>';
            tot += '<td>'+data['reservas'][i].people_number+'</td>';
            tot += '<td>'+data['reservas'][i].total_price/data['reservas'][i].people_number+'</td>';
            tot += '<td>'+data['reservas'][i].total_price+'</td>';
            tot += '</tr>';
        }
    
       $('#cuerpo').html( tot);
    
    }
});
});
</script>


</body>
</html>
