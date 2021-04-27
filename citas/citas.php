<?php
	require_once("index.php");
  $resp=$db->citas_afiliados();
  echo "<div class='container-fluid'>";
	echo "<br><h5>Bitácora de Citas</h5><hr>";
?>
		<div class="content table-responsive table-full-width" >
			<table class="table-sm display compact hover" id="x_lista">
			<thead>
			<th>#</th>
			<th>Estado</th>
			<th>Cita programada</th>
			<th>Tipo</th>
      <th>Observaciones</th>
			</tr>
			</thead>
			<tbody>
			<?php
        foreach($resp as $key){
					echo "<tr id=".$key->id." class='edit-t'>";

					echo "<td>";
  					echo "<div class='btn-group'>";
  					echo "<button class='btn btn-warning btn-sm' id='cita_ver' title='Editar' onclick='ver_cita(".$key->id.")'><i class='fas fa-pencil-alt'></i>Ver</button>";

						$fecha=date("Y-m-d H:i:s");
						$date1 = new DateTime($fecha);
						$date2 = new DateTime($key->fecha);
						$diff = $date1->diff($date2);
						$horas = $diff->h;
						$horas = $horas + ($diff->days*24);
						if($key->realizada==0 and $horas>=24){
							echo "<button class='btn btn-warning btn-sm' id='cita_cancela' onclick='cancela_cita(".$key->id.")'><i class='far fa-times-circle'></i>Cancelar cita</button>";
						}
						if($key->realizada==0){
							echo "<button class='btn btn-warning btn-sm' id='imprimir_cita' title='Imprimir' data-lugar='citas/imprimir' data-tipo='1' type='button'><i class='fas fa-print'></i>Imprimir</button>";
						}
  					echo "</div>";
					echo "</td>";
					echo "<td>";
						if($key->realizada==0){
							echo "Programada";
						}
						if($key->realizada==1){
							echo "Realizada";
						}
						if($key->realizada==2){
							echo "Cancelada";
						}
						if($key->realizada==3){
							echo "No realizada";
						}
					echo "</td>";
					echo "<td>".fecha($key->fecha,3)."</td>";
					echo "<td>";
          if ($key->tipo==1){
            echo "Retiro";
          }
          else{
            echo "Credito";
          }
          echo "</td>";
					echo "<td>".$key->observaciones."</td>";
					echo "</tr>";
				}
			?>
			</tbody>
			</table>
		</div>
	</div>

<script>
	$(document).ready( function () {
		lista("x_lista");
	});
</script>
