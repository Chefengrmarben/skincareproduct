$(document).ready(function(){
    $(".add-to-cart").click(function(){
        var productId = $(this).data("product-id");
        var productName = $(this).data("product-name");
        var productPrice = $(this).data("product-price");

        // AJAX request to add product to cart
        $.ajax({
            url: "addToCart.php",
            type: "POST",
            data: { productId: productId, productName: productName, productPrice: productPrice },
            success: function(response){
                Swal.fire(
                    'Added to Cart!',
                    'Your item has been added to the cart.',
                    'success'
                );
            },
            error: function(xhr, status, error){
                console.error(xhr.responseText);
                Swal.fire(
                    'Error!',
                    'There was an error adding the item to the cart.',
                    'error'
                );
            }
        });
    });
});