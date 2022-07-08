<h1>Seccion de Candidatos / Examen II Parcial</h1>
<section>

</section>
<section>
  <table>
    <thead>
      <tr>
        <th>Id</th>
        <th>Identidad</th>
        <th>Nombre</th>
        <th>Edad</th>
        <th><a href="index.php?page=Mnt-Candidato&mode=INS">Nuevo</a></th>
      </tr>
    </thead>
    <tbody>
      {{foreach Candidatos}}
      <tr>
        <td>{{idCandidato}}</td>
        <td>{{identidadCand}}</td>
        <td> <a href="index.php?page=Mnt-Candidato&mode=DSP&id={{idCandidato}}">{{nombreCand}}</a></td>
        <td>{{edadCand}}</td>
        <td>
          <a href="index.php?page=Mnt-Candidato&mode=UPD&id={{idCandidato}}">Editar</a>
          &NonBreakingSpace;
          <a href="index.php?page=Mnt-Candidato&mode=DEL&id={{idCandidato}}">Eliminar</a>
        </td>
      </tr>
      {{endfor Candidatos}}
    </tbody>
  </table>
</section>