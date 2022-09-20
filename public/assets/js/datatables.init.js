$(function () {
    $("#table-list").DataTable({
        // dom: "Bfrtip",
        responsive: true,
            language: {
                search:         "Busqueda&nbsp;:",
                lengthMenu:     "Mostrar _MENU_ elementos",
                info:           "Mostrando de _START_ a _END_ de _TOTAL_ elementos",
                paginate: {
                    first:      "Primero",
                    previous:   "Aterior",
                    next:       "Siguiente",
                    last:       "Ultimo"
                }
            },
            // buttons: ["excel", "pdf"]
    });
});

function FunDataTable(name) {
    $("#"+name).DataTable({
        responsive: true,
            language: {
                search:         "Busqueda&nbsp;:",
                lengthMenu:     "Mostrar _MENU_ elementos",
                info:           "Mostrando de _START_ a _END_ de _TOTAL_ elementos",
                paginate: {
                    first:      "Primero",
                    previous:   "Aterior",
                    next:       "Siguiente",
                    last:       "Ultimo"
                }
            }
    });
}