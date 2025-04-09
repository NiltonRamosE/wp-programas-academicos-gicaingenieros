<?php $last_updated = date('d/m/Y H:i'); ?>
<header class="gica-academic-program__header">
    <div class="gica-academic-program__header-img-container">
        <img src="https://www.gicaingenieros.com/email/images/img-gica-2.jpg" alt="GICA Ingenieros" class="gica-academic-program__header-img">
    </div>
    <div class="gica-academic-program__header-content">
        <div>
            <h1 class="gica-academic-program__title">
                Programas Académicos
            </h1>
            <p class="gica-academic-program__subtitle"><?php echo $title_gica; ?></p>
        </div>
        <div class="gica-academic-program__header-badge">
            <span class="gica-academic-program__update"> v<?php echo GICA_PLUGIN_VERSION; ?> • <?php echo $last_updated; ?></span>
        </div>
    </div>
    <div class="gica-academic-program__header-line"></div>
</header>