jQuery(document).ready(function($) {
    function setupSizeInputGroup(selector, inputClass, unitClass) {
        $(selector).each(function() {
            var $group = $(this);
            var $tempInput = $group.find(inputClass);
            var $unitSelect = $group.find(unitClass);
            var $realInput = $group.find('input[type="hidden"]');

            function updateField() {
                $realInput.val($tempInput.val() + $unitSelect.val());
            }

            $tempInput.on('input', updateField);
            $unitSelect.on('change', updateField);

            var initialValue = $realInput.val();
            var numberPart = initialValue.replace(/[^0-9.]/g, '');
            var unitPart = initialValue.replace(/[0-9.]/g, '');

            $tempInput.val(numberPart);
            $unitSelect.val(unitPart);
        });
    }

    setupSizeInputGroup('.main-title__size-input-group', '.main-title__input--number', '.main-title__unit-select');
    setupSizeInputGroup('.navbar__size-input-group', '.navbar__input--number', '.navbar__unit-select');
    setupSizeInputGroup('.filters__size-input-group', '.filters__input--number', '.filters__unit-select');
    setupSizeInputGroup('.cards__size-input-group', '.cards__input--number', '.cards__unit-select');
    setupSizeInputGroup('.pagination__size-input-group', '.pagination__input--number', '.pagination__unit-select');
});
