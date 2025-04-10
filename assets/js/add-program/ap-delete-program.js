jQuery(document).ready(function($) {
    $('.delete-program').on('click', function(e) {
        e.preventDefault();
        var category = $(this).data('category');
        var year = $(this).data('year');
        var index = $(this).data('index');

        if (confirm('¿Estás seguro de que deseas eliminar este programa?')) {
            $.post(gica_admin_params.ajax_url, {
                action: 'delete_academic_program',
                category: category,
                year: year,
                index: index,
                _ajax_nonce: gica_admin_params.nonce
            }, function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert('Ocurrió un error al eliminar el programa.');
                }
            });
        }
    });
});
