document.addEventListener('DOMContentLoaded', function() {
    // Находим все поля ввода и их соответствующие лейблы
    const formInputs = document.querySelectorAll('.form-input');
    const formSelects = document.querySelectorAll('.form-select');
    
    // Функция для скрытия лейбла
    function hideLabel(input) {
        const label = input.previousElementSibling;
        if (label && label.classList.contains('form-label')) {
            label.style.opacity = '0';
        }
    }
    
    // Функция для показа лейбла (если поле пустое)
    function showLabel(input) {
        const label = input.previousElementSibling;
        if (label && label.classList.contains('form-label') && input.value === '') {
            label.style.opacity = '1';
        }
    }
    
    // Обработчики для обычных полей ввода
    formInputs.forEach(input => {
        // При фокусе скрываем лейбл
        input.addEventListener('focus', function() {
            hideLabel(this);
        });
        
        // При потере фокуса показываем лейбл, если поле пустое
        input.addEventListener('blur', function() {
            showLabel(this);
        });
        
        // Также скрываем лейбл если поле уже заполнено при загрузке
        if (input.value !== '') {
            hideLabel(input);
        }
    });
    
    // Обработчики для select полей
    formSelects.forEach(select => {
        // При фокусе скрываем лейбл
        select.addEventListener('focus', function() {
            hideLabel(this);
        });
        
        // При потере фокуса показываем лейбл, если значение не выбрано
        select.addEventListener('blur', function() {
            if (this.value === '') {
                showLabel(this);
            }
        });
        
        // Также скрываем лейбл если значение уже выбрано при загрузке
        if (select.value !== '') {
            hideLabel(select);
        }
        
        // Скрываем лейбл при изменении значения
        select.addEventListener('change', function() {
            if (this.value !== '') {
                hideLabel(this);
            } else {
                showLabel(this);
            }
            
        });
    });
});