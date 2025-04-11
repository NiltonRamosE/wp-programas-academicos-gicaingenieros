jQuery(document).ready(function($) {
    $('.delete-category').on('click', function(e) {
        e.preventDefault();

        const $btn = $(this);
        const index = $btn.data('index');
        const $row = $btn.closest('tr');

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
                $.post(gica_category_admin_params.ajax_url, {
                    action: 'delete_category_program',
                    index: index,
                    _ajax_nonce: gica_category_admin_params.nonce
                }, function(response) {
                    if (response.success) {
                        $row.fadeOut(300, function() {
                            $(this).remove();
                        });

                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Categoría eliminada',
                            showConfirmButton: false,
                            timer: 1500,
                            timerProgressBar: true,
                            customClass: {
                                popup: 'swal2-responsive-toast'
                            },
                            didClose: () => {
                                location.reload();
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
