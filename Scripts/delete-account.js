function showConfirmation() {
    document.getElementById("confirmationModal").classList.remove("hidden");
}

function hideConfirmation() {
    document.getElementById("confirmationModal").classList.add("hidden");
}

function submitForm() {
    document.getElementById("deleteForm").submit();
} 