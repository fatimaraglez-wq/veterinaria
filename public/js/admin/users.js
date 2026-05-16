function toggleVeterinarioFields() {
    var rol = document.getElementById('rol').value;
    var vetFields = document.getElementById('veterinario_fields');
    if (rol === 'veterinario') {
        vetFields.style.display = 'block';
    } else {
        vetFields.style.display = 'none';
    }
}
