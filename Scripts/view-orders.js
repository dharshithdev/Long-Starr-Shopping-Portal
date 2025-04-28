function redirectToOrder(productId, button) {
    button.disabled = true;
    window.location.href = "view-product.php?id=" + productId;
}

function redirectToDetails(button) {
    button.disabled = true;
    window.location.href = "order-details.php";
}

function openPopup(trackId) {
    document.getElementById('popupTrackId').value = trackId;
    document.getElementById('cancelPopup').classList.remove('hidden');
}

function closePopup() {
    document.getElementById('cancelPopup').classList.add('hidden');
}