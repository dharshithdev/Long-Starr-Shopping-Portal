function redirectToOrder(productId, button) {
    button.disabled = true; 
    window.location.href = "view-product.php?id=" + productId;
}