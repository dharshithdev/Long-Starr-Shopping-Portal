function showPopup() {
    const selectedMode = document.querySelector("input[name='payMode']:checked");
    document.getElementById("modeInput").value = selectedMode.value;
    document.getElementById("popup").classList.remove("hidden");
}

function hidePopup() {
   document.getElementById("popup").classList.add("hidden");
}

function placeOrder() {
   hidePopup();
   document.getElementById("successPopup").classList.remove("hidden");
}

function hideSuccess() {
   document.getElementById("successPopup").classList.add("hidden");
   window.location.href = "index.php";
}