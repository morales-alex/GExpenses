const actividad = document.querySelector('.caja-boton-actividad');



actividad.addEventListener("click", function (e) {
    e.preventDefault();

    const actividadId = actividad.parentElement.parentElement.id;

    window.location.href= '/GExpenses/vista/Actividad.php?id=' + actividadId;
  });


