const updateForm = document.getElementById('updateModal')

if (updateForm) {
    updateForm.addEventListener('show.bs.modal', event => {

        const button = event.relatedTarget;

        const getId = button.getAttribute('data-bs-id');

        const idField = document.getElementById('InputIdUpdate');

        idField.value = getId;
    })
}