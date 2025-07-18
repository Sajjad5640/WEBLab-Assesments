// Optional: simulate cart count from localStorage
document.addEventListener("DOMContentLoaded", () => {
  const count = localStorage.getItem("cartCount") || "2";
  document.querySelector(".cart-count").textContent = count;
});
