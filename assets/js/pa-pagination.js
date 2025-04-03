jQuery(document).ready(function($) {
    // Clase para manejar la paginación
    function AcademicPagination(containerId, itemsPerPage) {
        this.container = $('#' + containerId);
        this.itemsPerPage = itemsPerPage || 6;
        this.currentPage = 1;
        this.init();
    }

    AcademicPagination.prototype = {
        init: function() {
            if (this.container.length === 0) return;

            this.programItems = this.container.find('.program-item');
            this.paginationContainer = $('#pagination-' + this.container.attr('id'));

            if (typeof window.registerPaginationInstance === 'function') {
                window.registerPaginationInstance(this.container.attr('id'), this);
            }
            
            // Mostrar primera página al cargar
            this.showPage(this.getUrlPage());
            this.setupEventListeners();
        },

        showPage: function(page) {
            this.currentPage = page;
            var startIndex = (page - 1) * this.itemsPerPage;
            var endIndex = startIndex + this.itemsPerPage;
            
            this.programItems.each(function(index) {
                $(this).toggle(index >= startIndex && index < endIndex);
            });
            
            this.updatePaginationControls();
            this.updateUrl();
        },

        updatePaginationControls: function() {
            var totalPages = Math.ceil(this.programItems.length / this.itemsPerPage);
            this.paginationContainer.empty();
            
            if (totalPages > 1) {
                // Botón Anterior
                if (this.currentPage > 1) {
                    this.paginationContainer.append(
                        this.createPageLink('&laquo; Anterior', this.currentPage - 1, 'prev')
                    );
                }
                
                // Números de página
                var maxVisiblePages = 5;
                var startPage = Math.max(1, this.currentPage - Math.floor(maxVisiblePages / 2));
                var endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);
                
                if (endPage - startPage + 1 < maxVisiblePages) {
                    startPage = Math.max(1, endPage - maxVisiblePages + 1);
                }
                
                if (startPage > 1) {
                    this.paginationContainer.append(this.createPageLink('1', 1));
                    if (startPage > 2) {
                        this.paginationContainer.append(this.createEllipsis());
                    }
                }
                
                for (var i = startPage; i <= endPage; i++) {
                    this.paginationContainer.append(this.createPageLink(i, i));
                }
                
                if (endPage < totalPages) {
                    if (endPage < totalPages - 1) {
                        this.paginationContainer.append(this.createEllipsis());
                    }
                    this.paginationContainer.append(this.createPageLink(totalPages, totalPages));
                }
                
                // Botón Siguiente
                if (this.currentPage < totalPages) {
                    this.paginationContainer.append(
                        this.createPageLink('Siguiente &raquo;', this.currentPage + 1, 'next')
                    );
                }
            }
        },

        createPageLink: function(text, page, className) {
            var link = $('<a>', {
                href: '#',
                'class': 'page-link ' + (className || '') + (page === this.currentPage ? ' active' : ''),
                html: text
            }).on('click', $.proxy(function(e) {
                e.preventDefault();
                this.showPage(page);
            }, this));
            
            return link;
        },

        createEllipsis: function() {
            return $('<span>', {
                'class': 'page-ellipsis',
                text: '...'
            });
        },

        updateUrl: function() {
            var params = new URLSearchParams(window.location.search);
            params.set('page', this.currentPage);
            window.history.pushState({}, '', '?' + params.toString());
        },

        getUrlPage: function() {
            var params = new URLSearchParams(window.location.search);
            return parseInt(params.get('page')) || 1;
        },

        setupEventListeners: function() {
            var self = this;
            $(window).on('popstate', function() {
                self.showPage(self.getUrlPage());
            });
        }
    };

    // Inicialización para cada contenedor
    $('[id^="pagination-"]').each(function() {
        var containerId = $(this).attr('id').replace('pagination-', '');
        new AcademicPagination(containerId, 6);
    });
});