jQuery(document).ready(function($) {
    const navButtons = $('.pa-nav__btn');
    const programasSections = $('.programas-academicos-section');

    navButtons.on('click', function() {
        const programCategory = $(this).data('program-category');
        programasSections.each(function() {
            $(this).toggle($(this).attr('id') === programCategory);
        });
    });
});
