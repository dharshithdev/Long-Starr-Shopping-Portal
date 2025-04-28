function redirectToOrder(productId, button) {
    button.disabled = true;
    window.location.href = "view-product.php?id=" + productId;
}

function openPopup(trackId) {
    document.getElementById('popupTrackId').value = trackId;
    document.getElementById('cancelPopup').classList.remove('hidden');
}

function closePopup() {
    document.getElementById('cancelPopup').classList.add('hidden');
} 