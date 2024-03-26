<?php
@include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];
if(!isset($user_id)){
   header('location:login.php');
   exit();
};

if(isset($_POST['add_to_wishlist'])){

   $pid = $_POST['pid'];
   $pid = filter_var($pid, FILTER_SANITIZE_STRING);
   $p_name = $_POST['p_name'];
   $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
   $p_price = $_POST['p_price'];
   $p_price = filter_var($p_price, FILTER_SANITIZE_STRING);
   $p_image = $_POST['p_image'];
   $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);

   $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
   $check_wishlist_numbers->execute([$p_name, $user_id]);

   $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
   $check_cart_numbers->execute([$p_name, $user_id]);

   if($check_wishlist_numbers->rowCount() > 0){
      $message[] = 'already added to wishlist!';
   }elseif($check_cart_numbers->rowCount() > 0){
      $message[] = 'already added to cart!';
   }else{
      $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES(?,?,?,?,?)");
      $insert_wishlist->execute([$user_id, $pid, $p_name, $p_price, $p_image]);
      $message[] = 'added to wishlist!';
   }

}
// Define constants for table names and column names
define('CART_TABLE', 'cart');
define('PRODUCTS_TABLE', 'products');
define('QUANTITY_COLUMN', 'quantity');
define('NAME_COLUMN', 'name');
define('PRICE_COLUMN', 'price');
define('IMAGE_COLUMN', 'image');
define('PID_COLUMN', 'pid');
/* define('ID_COLUMN', 'id');
 */
// Function to add a product to the cart
function addProductToCart($user_id, $pid, $p_name, $p_price, $p_image, $conn) {
    // Sanitize input data
    $pid = filter_var($pid, FILTER_SANITIZE_STRING);
    $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
    $p_price = filter_var($p_price, FILTER_SANITIZE_STRING);
    $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);

    // Retrieve the quantity of the product from the database
    $check_quantity = $conn->prepare("SELECT `" . QUANTITY_COLUMN . "` FROM `" . PRODUCTS_TABLE . "` WHERE `" . NAME_COLUMN . "` = ?");
    $check_quantity->execute([$p_name]);
    $quantity_result = $check_quantity->fetch(PDO::FETCH_ASSOC);
    $available_quantity = $quantity_result[QUANTITY_COLUMN];

    if ($available_quantity > 0) {
        // Update the available quantity in the database
        $new_quantity = $available_quantity - 1;
        $update_quantity = $conn->prepare("UPDATE `" . PRODUCTS_TABLE . "` SET `" . QUANTITY_COLUMN . "` = ? WHERE `" . NAME_COLUMN . "` = ?");
        $update_quantity->execute([$new_quantity, $p_name]);

        // Add the product to the cart
        $insert_cart = $conn->prepare("INSERT INTO `" . CART_TABLE . "`(user_id, `" . PID_COLUMN . "`, `" . NAME_COLUMN . "`, `" . PRICE_COLUMN . "`, `" . IMAGE_COLUMN . "`) VALUES(?,?,?,?,?)");
        $insert_cart->execute([$user_id, $pid, $p_name, $p_price, $p_image]);
        $message[] = 'Product added to cart!';
    } else {
        $message[] = 'Product is out of stock!';
    }
}

// Check if the "add_to_cart" button has been clicked
if (isset($_POST['add_to_cart'])) {
    // Retrieve the input data from the form
    /* $id = $_POST['id']; */
    $pid = $_POST['pid'];
    $p_name = $_POST['p_name'];
    $p_price = $_POST['p_price'];
    $p_image = $_POST['p_image'];

    // Call the function to add the product to the cart
    addProductToCart($user_id, $pid, $p_name, $p_price, $p_image, $conn);
}

/* dont delete this it is important */
/* if(isset($_POST['add_to_cart'])){

   $pid = $_POST['pid'];
   $pid = filter_var($pid, FILTER_SANITIZE_STRING);
   $p_name = $_POST['p_name'];
   $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
   $p_price = $_POST['p_price'];
   $p_price = filter_var($p_price, FILTER_SANITIZE_STRING);
   $p_image = $_POST['p_image'];
   $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);
   $p_qty = $_POST['p_qty'];
   $p_qty = filter_var($p_qty, FILTER_SANITIZE_STRING);

   $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
   $check_cart_numbers->execute([$p_name, $user_id]);

   if($check_cart_numbers->rowCount() > 0){
      $message[] = 'already added to cart!';
   }else{

      $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
      $check_wishlist_numbers->execute([$p_name, $user_id]);

      if($check_wishlist_numbers->rowCount() > 0){
         $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE name = ? AND user_id = ?");
         $delete_wishlist->execute([$p_name, $user_id]);
      }

      $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES(?,?,?,?,?,?)");
      $insert_cart->execute([$user_id, $pid, $p_name, $p_price, $p_qty, $p_image]);
      $message[] = 'added to cart!';
   }

} */

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shop</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

  
</head>
<body>

<?php include 'header.php'; ?>

<div class="shop-bg">

<div class="headingshop">
   <h3>OUR SHOP</h3>
   <p> <a href="home.php">Home</a> / SHOP </p>
</div>

</div>

<section class="p-category">

   <a href="category.php?category=avosmooth">AVOSMOOTH</a>
   <a href="category.php?category=avomelt">AVOMELT</a>
   <a href="category.php?category=marbled soap">MARBLED SOAP</a>
   <a href="category.php?category=avo ice cream scrub">AVO ICE CREAM SCRUB</a>
</section>
<br><br>

<section class="products">

   <h1 class="title">latest products</h1>

   <div class="box-containerrr">

<?php
   $totalProducts = 0;

   $select_products = $conn->prepare("SELECT * FROM `products`");
   $select_products->execute();

   if($select_products->rowCount() > 0){
      while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
         $totalProducts++;
?>
<form action="" class="box" method="POST">
      <div class="price">&#8369;<span><?= $fetch_products['price']; ?></span></div>
      <a href="view_page.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
      <img src="images/<?= $fetch_products['image']; ?>" alt="">
      <div class="name"><?= $fetch_products['name']; ?></div>
      <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
      <input type="hidden" name="p_name" value="<?= $fetch_products['name']; ?>">
      <input type="hidden" name="p_price" value="<?= $fetch_products['price']; ?>">
      <input type="hidden" name="p_image" value="<?= $fetch_products['image']; ?>">
      <!-- <input type="number" min="1" value="1" name="p_qty" class="qty"> -->
      <input type="submit" value="❤" class="readbtnne" name="add_to_wishlist">
      <input type="submit" value="add to cart" class="proceed-btn" name="add_to_cart">
   </form>
<?php
   }
} else {
   echo '<p class="empty">no products added yet!</p>';
}

// Display the total number of products
echo '<p>Total number of products: ' . $totalProducts . '</p>';
?>
</div>


</section>








<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>