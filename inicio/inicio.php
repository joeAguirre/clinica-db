<div class="titulo">
        <h2>Bienvenido al Panel de Control</h2>
        <a style="position: absolute; right: 0; top:0; margin-top:10px; margin-right:10px" 
        href="./sesiones/cerrar_sesion.php" 
        class="btn btn-danger btn-cerrar">
        Cerrar sesión
       </a>
        </div>
<div class="button-container">
        <form action="./pacientes/generar_informe.php" method="post">
            <button type="submit" class="btn-custom">Generar Informe de Citas Medicas</button>
        </form>
        <form action="./medicos/consulta_especialidad.php" method="post">
            <button type="submit" class="btn-custom">Generar Informe de Especialidad</button>
        </form>
</div>