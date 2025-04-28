function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}
  
async function redirectToOrder(productId, button) {
      button.disabled = true; 
      window.location.href = "view-product.php?id=" + productId;
} 