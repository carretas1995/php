//detecto el click del boton grabar con jquery y lanzo la funcion php de grabar datos
$(document).ready(function () {
  $("#botonGrabar").click(function () {
    $.ajax({
      url: "programa.php",
      method: "POST",
      async: false,
      data: {
        funcion: 1, //valor para ejecutar accion del switch
        //paso los valores del formulario
        nombre: $("#nombreLibro").val(),
        isbn: $("#isbn").val(),
        año: $("#año").val(),
        autor: $("#autor").val()
      },
      success: function(response) {
        alert(response); //manejar respuesta
      }
    });
  });
  $("#botonImprimir").click(function () {
    $.ajax({
      url: "programa.php",
      method: "POST",
      async: false,
      data: {
        funcion: 2 //valor para ejecutar accion del switch
      },
      success: function (response) {
        //falta sacar los echo de devolucion del ph
        
        $("#respuesta").html(response); //manejar respuesta
      }
    });
  });
});
