// dashboard js
// Function to fetch user's orders using AJAX

// Call fetchOrders() when the page loads
/* window.onload = function() {
    fetchOrders();
}; */

// for user dashboard
function logout() {
    // Perform logout actions here
    alert('Logout successful!');
    // Redirect to the logout page or login page if needed
    window.location.href = 'logout.php';
}

document.getElementById('btnTrack').addEventListener('click', function() {
    // Handle 'Track Order' button click
    alert('Tracking order...');
});

document.getElementById('btnCancel').addEventListener('click', function() {
    // Handle 'Cancel Order' button click
    alert('Canceling order...');
});

document.getElementById('btnInTransit').addEventListener('click', function() {
    // Handle 'In Transit' button click
    alert('Order in transit...');
});

document.getElementById('btnDelivered').addEventListener('click', function() {
    // Handle 'Delivered' button click
    alert('Order delivered!');
});

document.getElementById('btnUnsuccessful').addEventListener('click', function() {
    // Handle 'Unsuccessful Delivery' button click
    alert('Unsuccessful delivery!');
});
