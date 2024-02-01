document.addEventListener('DOMContentLoaded', () => {
    // Инициализация всплывающих подсказок
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
// Получение элементов модального окна и входного поля
    const deleteModal = document.querySelector('.deleteModal');
    const deleteInput = document.querySelector('.deleteInput');

    // Проверка наличия deleteModal и deleteInput перед добавлением обработчика событий
    if (deleteModal && deleteInput) {
        deleteModal.addEventListener('shown.bs.modal', () => {
            deleteInput.focus();
        });
    }
});
