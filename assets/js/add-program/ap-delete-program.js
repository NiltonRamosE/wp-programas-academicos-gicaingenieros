jQuery(document).ready(function($) {
    $('.delete-program').on('click', function(e) {
        e.preventDefault();

        const $btn = $(this);
        const category = $btn.data('category');
        const year = $btn.data('year');
        const index = $btn.data('index');
        const $row = $btn.closest('tr'); // ⬅️ aquí seleccionamos la fila entera

        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post(gica_admin_params.ajax_url, {
                    action: 'delete_academic_program',
                    category: category,
                    year: year,
                    index: index,
                    _ajax_nonce: gica_admin_params.nonce
                }, function(response) {
                    if (response.success) {
                        $row.fadeOut(300, function() {
                            $(this).remove();
                        });

                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Programa eliminado',
                            showConfirmButton: false,
                            timer: 2500,
                            timerProgressBar: true,
                            customClass: {
                                popup: 'swal2-responsive-toast'
                            }
                        });
                    } else {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'error',
                            title: 'Error al eliminar',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            customClass: {
                                popup: 'swal2-responsive-toast'
                            }
                        });
                    }
                });
            }
        });
    });
});
