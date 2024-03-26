// var sidebarOpen = false;

// function toggleSidebar() {
//     var sidebar = document.getElementById("sidebar");
//     if (!sidebarOpen) {
//         sidebar.classList.add("animated");
//         sidebar.style.right = "0";
//         sidebarOpen = true;
//     } else {
//         sidebar.classList.remove("animated");
//         sidebar.style.right = "-350px";
//         sidebarOpen = false;
//     }
// }
$(document).ready(function() {
  // Open cart modal when the cart icon is clicked
  $('#openCartModal').click(function(e) {
      e.preventDefault();
      $('#cartModal').modal('show');
      // You can use AJAX here to fetch and display the cart items dynamically
  });
  
  // Checkout button click handler
  $('#checkoutButton').click(function() {
      // Redirect to the checkout page or perform checkout logic
      window.location.href = 'checkout.php'; // Change the URL to your checkout page
  });
  
  // View Cart button click handler
  $('#viewCartButton').click(function() {
      // Redirect to the view cart page or perform view cart logic
      window.location.href = 'viewCart.php'; // Change the URL to your view cart page
  });
});
