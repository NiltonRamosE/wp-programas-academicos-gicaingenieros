jQuery(document).ready(function($) {
    // Objeto para almacenar instancias de paginación
    const paginationInstances = {};

    // Función principal para manejar los filtros
    function setupFilters() {
        $('.programas-academicos-section').each(function() {
            const section = $(this);
            const sectionId = section.attr('id');
            const programItems = section.find('.program-item');
            const filterYearBtns = section.find('.pa-filter__btn-year');
            const filterStateBtns = section.find('.pa-filter__btn-state');
            
            // Registrar la sección en las instancias de paginación
            paginationInstances[sectionId] = null;
            
            // Manejar clic en botones de año
            filterYearBtns.on('click', function() {
                const year = $(this).data('year');
                
                // Actualizar estado activo de los botones
                filterYearBtns.removeClass('active');
                $(this).addClass('active');
                
                // Filtrar programas
                filterPrograms(section, year, getCurrentState());
            });
            
            // Manejar clic en botones de estado
            filterStateBtns.on('click', function() {
                const state = $(this).data('state');
                
                // Actualizar estado activo de los botones
                filterStateBtns.removeClass('active');
                $(this).addClass('active');
                
                // Filtrar programas
                filterPrograms(section, getCurrentYear(), state);
            });
            
            // Función para obtener el año actual seleccionado
            function getCurrentYear() {
                return section.find('.pa-filter__btn-year.active').data('year') || 'all';
            }
            
            // Función para obtener el estado actual seleccionado
            function getCurrentState() {
                return section.find('.pa-filter__btn-state.active').data('state') || 'all';
            }
            
            // Activar el primer botón de año y "Todos" por defecto
            filterYearBtns.first().addClass('active');
            filterStateBtns.first().addClass('active');
        });
    }
    
    // Función para filtrar los programas
    function filterPrograms(section, year, state) {
        const sectionId = section.attr('id');
        const programItems = section.find('.program-item');
        
        // Mostrar todos los elementos temporalmente para el filtrado
        programItems.show();
        
        // Aplicar filtros
        programItems.each(function() {
            const item = $(this);
            const itemYear = item.data('year');
            const isActive = item.data('active') === 'true';
            const isUpdated = item.data('updated') === 'true';
            
            let yearMatch = (year === 'all' || year === itemYear);
            let stateMatch = true;
            
            // Aplicar filtro de estado
            if (state !== 'all') {
                if (state === 'active') {
                    stateMatch = isActive;
                } else if (state === 'inactive') {
                    stateMatch = !isActive;
                } else if (state === 'updated') {
                    stateMatch = isUpdated;
                }
            }
            
            // Mostrar u ocultar según los filtros
            item.toggle(yearMatch && stateMatch);
        });
        
        // Actualizar la paginación
        updatePagination(section);
    }
    
    // Función para actualizar la paginación
    function updatePagination(section) {
        const sectionId = section.attr('id');
        const visibleItems = section.find('.program-item:visible');
        
        // Si ya existe una instancia de paginación para esta sección
        if (paginationInstances[sectionId]) {
            const paginationInstance = paginationInstances[sectionId];
            
            // Actualizar los items y resetear a la página 1
            paginationInstance.programItems = visibleItems;
            paginationInstance.showPage(1);
        }
    }
    
    // Inicializar los filtros
    setupFilters();
    
    // Exponer función para registrar instancias de paginación
    window.registerPaginationInstance = function(sectionId, instance) {
        paginationInstances[sectionId] = instance;
    };
});