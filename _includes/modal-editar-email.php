<div class="modal fade custom-modal" id="modal-editar-email" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="title-1 mb-0">Editar email</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="usuario-nuevo-email">
        <div class="modal-body">
          <p class="body-copy-bold">Recibirás información de tu póliza y resumen mensual a la casilla de email que ingreses.</p>
          <div class="form-group line-input-text email-form">
            <input type="email" class="form-control" height="56" name="email" placeholder="Ingresar nuevo email">
            
          </div>
          <div class="error"><!-- aqui mostramos mensaje de error, si corresponde --></div>
          <?php /*
          <div class="form-group line-input-text form-email-input-error email-form">
            <input type="email" class="form-control" name="" placeholder="Ingresar nuevo email">
            <span class="label error-validation">La información ingresada no es correcta</span>
          </div>
          */ ?>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" data-dismiss="modal" >Guardar cambios</button> <!-- Para deshabilitar el botón colocar disabled en el tag-->
        </div>
      </form>
    </div>
  </div>
</div>