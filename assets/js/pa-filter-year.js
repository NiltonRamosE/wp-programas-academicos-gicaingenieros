jQuery(document).ready(function($) {
    
    const paginationInstances = {};

    function setupFilters() {
        $('.programas-academicos-section').each(function() {
            const section = $(this);
            const sectionId = section.attr('id');
            const filterYearBtns = section.find('.pa-filter__btn-year');
            
            paginationInstances[sectionId] = null;
            
            filterYearBtns.on('click', function() {
                const year = $(this).data('year');
                
                filterYearBtns.removeClass('active');
                $(this).addClass('active');
                
                filterProgramsByYear(section, year);
            });
            
            filterYearBtns.first().addClass('active');
        });
    }
    
    function filterProgramsByYear(section, year) {
        const programItems = section.find('.program-item');
        
        programItems.show();
        
        if (year !== 'all') {
            programItems.each(function() {
                const item = $(this);
                const itemYear = item.data('year');
                item.toggle(itemYear === year);
            });
        }
        
        updatePagination(section);
    }
    
    function updatePagination(section) {
        const sectionId = section.attr('id');
        const visibleItems = section.find('.program-item:visible');
        
        if (paginationInstances[sectionId]) {
            const paginationInstance = paginationInstances[sectionId];
            
            paginationInstance.programItems = visibleItems;
            paginationInstance.showPage(1);
        }
    }
    
    setupFilters();
    
    window.registerPaginationInstance = function(sectionId, instance) {
        paginationInstances[sectionId] = instance;
    };
});