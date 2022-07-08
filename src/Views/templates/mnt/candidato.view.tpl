<h1>{{mode_desc}}</h1>
<section>
  <form action="index.php?page=mnt_candidato" method="post">
    <input type="hidden" name="mode" value="{{mode}}" />
    <input type="hidden" name="crsf_token" value="{{crsf_token}}" />
    <input type="hidden" name="idCandidato" value="{{idCandidato}}" />
    <fieldset>
      <label for="identidadCand">Identidad</label>
      <input {{if readonly}}readonly{{endif readonly}} type="text" id="identidadCand" name="identidadCand" placeholder="Identidad" value="{{identidadCand}}" />
      {{if error_identidadCand}}
        {{foreach error_identidadCand}}
          <div class="error">{{this}}</div>
        {{endfor error_identidadCand}}
      {{endif error_identidadCand}}
    </fieldset>
    <fieldset>
      <label for="nombreCand">Nombre</label>
      <input {{if readonly}}readonly{{endif readonly}} type="text" id="nombreCand" name="nombreCand" placeholder="Nombre" value="{{nombreCand}}" />
      {{if error_nombreCand}}
        {{foreach error_nombreCand}}
          <div class="error">{{this}}</div>
        {{endfor error_nombreCand}}
      {{endif error_nombreCand}}
    </fieldset>
    <fieldset>
      <label for="edadCand">Edad</label>
      <input {{if readonly}}readonly{{endif readonly}} type="text" id="edadCand" name="edadCand" placeholder="Edad" value="{{edadCand}}" />
      {{if error_edadCand}}
        {{foreach error_edadCand}}
          <div class="error">{{this}}</div>
        {{endfor error_edadCand}}
      {{endif error_edadCand}}
    </fieldset>
    
    <fieldset>
      {{if showBtn}}
        <button type="submit" name="btnEnviar">{{btnEnviarText}}</button>
        &nbsp;
      {{endif showBtn}}
      <button name="btnCancelar" id="btnCancelar">Cancelar</button>
    </fieldset>
  </form>
</section>
<script>
  document.addEventListener('DOMContentLoaded', function(){
    document.getElementById('btnCancelar').addEventListener('click', function(e){
      e.preventDefault();
      e.stopPropagation();
      window.location.href = 'index.php?page=mnt_candidatos';
    });
  });
</script>