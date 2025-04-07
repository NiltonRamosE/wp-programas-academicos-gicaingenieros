jQuery(document).ready(function($) {
    $('.main-title__size-input-group').each(function() {
        var $group = $(this);
        var $tempInput = $group.find('.main-title__input--number');
        var $unitSelect = $group.find('.main-title__unit-select');
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
});