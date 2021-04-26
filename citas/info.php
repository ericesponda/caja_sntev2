<?php
	require_once("db_.php");
  $id=$_REQUEST['id'];
  $resp=$db->cita_ver($id);
  $tipo="";
  if($resp->tipo==1){
    $tipo="Retiro";
  }
  if($resp->tipo==2){
    $tipo="Credito";
  }
 ?>
  <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title">Cita</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body">
        <div class='row'>
          <div class='col-2'>
            <label>Cita</label>
            <input id='id' name='id' class='form-control form-control-sm' value='<?php echo $resp->id; ?>' readonly>
          </div>
          <div class='col-2'>
            <label>Filiación</label>
            <input id='id' name='id' class='form-control form-control-sm' value='<?php echo $resp->Filiacion; ?>' readonly>
          </div>
          <div class='col-2'>
            <label>Nombre</label>
            <input id='id' name='id' class='form-control form-control-sm' value='<?php echo $resp->nombre; ?>' readonly>
          </div>
          <div class='col-3'>
            <label>A. Paterno</label>
            <input id='id' name='id' class='form-control form-control-sm' value='<?php echo $resp->ape_pat; ?>' readonly>
          </div>
          <div class='col-3'>
            <label>A. Materno</label>
            <input id='id' name='id' class='form-control form-control-sm' value='<?php echo $resp->ape_mat; ?>' readonly>
          </div>
          <div class='col-3'>
            <label>Cita</label>
            <input id='id' name='id' class='form-control form-control-sm' value='<?php echo fecha($resp->fecha,3); ?>' readonly>
          </div>
          <div class='col-3'>
            <label>Movimiento</label>
            <input id='id' name='id' class='form-control form-control-sm' value='<?php echo $tipo; ?>' readonly>
          </div>
          <div class='col-12'>
            <label>Observaciones</label>
            <input id='id' name='id' class='form-control form-control-sm' value='<?php echo $resp->observaciones; ?>' readonly>
          </div>
        </div>
     </div>
     <div class="modal-footer">
       <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
     </div>
   </div>
