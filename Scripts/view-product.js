function changeImage(element) {
    document.getElementById('mainImage').src = element.src;
}

function redirectToOrder(productId) {
  const button = document.getElementById("buy-now-button");
  button.disabled = true; 
  location.reload();
  window.location.href = "confirm-order.php?id=" + productId;
}