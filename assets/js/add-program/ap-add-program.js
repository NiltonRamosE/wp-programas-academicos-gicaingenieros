jQuery(document).ready(function($) {
    $('#add-program-form').on('submit', function(e) {
        e.preventDefault();

        const formData = $(this).serialize();

        $.post('admin-post.php', formData, function(response) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Programa añadido con éxito',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true,
                customClass: {
                    popup: 'swal2-responsive-toast'
                }
            }).then(() => {
                $('#add-program-form')[0].reset();
                location.reload();
            });
            
        }).fail(function() {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: 'Hubo un error al añadir el programa',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                customClass: {
                    popup: 'swal2-responsive-toast'
                }
            });
        });
    });
});
