jQuery(document).ready(function($) {
    const navButtons = $('.pa-nav__btn');
    const programasSections = $('.programas-academicos-section');

    function setInitialActiveButton() {
        const visibleSection = programasSections.filter(':visible');
        if (visibleSection.length) {
            const activeCategory = visibleSection.attr('id');
            navButtons.removeClass('pa-nav__btn--active')
                     .filter(`[data-program-category="${activeCategory}"]`)
                     .addClass('pa-nav__btn--active');
        }
    }

    navButtons.on('click', function() {
        const programCategory = $(this).data('program-category');
        
        navButtons.removeClass('pa-nav__btn--active');
        $(this).addClass('pa-nav__btn--active');
        
        programasSections.each(function() {
            $(this).toggle($(this).attr('id') === programCategory);
        });
    });

    setInitialActiveButton();
});