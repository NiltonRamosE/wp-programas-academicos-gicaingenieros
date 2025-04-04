jQuery(document).ready(function ($) {
    const clipboard = new ClipboardJS('.gica-dashboard__copy-btn');

    clipboard.on('success', function (e) {
        const $btn = $(e.trigger);
        $btn.text('¡Copiado!');
        setTimeout(() => $btn.text('Copiar Shortcode'), 1500);
        e.clearSelection();
    });

    clipboard.on('error', function (e) {
        alert('No se pudo copiar automáticamente. Usa Ctrl+C');
    });
});
