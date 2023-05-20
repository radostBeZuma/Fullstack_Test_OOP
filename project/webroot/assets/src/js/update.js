const updateModal = document.getElementById('updateModal');

// передача id в форму через событие bootstrap`a

if (updateModal) {
    updateModal.addEventListener('show.bs.modal', event => {

        const button = event.relatedTarget;

        const getId = button.getAttribute('data-bs-id');

        const idField = document.getElementById('InputIdUpdate');

        idField.value = getId;
    })
}

