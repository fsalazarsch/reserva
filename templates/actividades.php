<?php
include 'header.php';
?>

      <div class="collection" id="coleccion">
      </div>    
    </div>
  </div>


<script>
$(document).ready(function()
{
  $.ajax({
    url: "/denomades/api/actividades/",
    dataType: "JSON",
    success: function(data){
      var tot = '';
      for(var i=0;i<data['actividades'].length;i++){
            tot += '<a href="'+data['actividades'][i].slug+'" class="collection-item">'+data['actividades'][i].name+'</a>';
        }
    
       $('#coleccion').html( tot);
    
    }
  });
});
</script>
</body>
</html>
