<?php
session_start();
require 'config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout</title>

  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css' />
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css' />
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">

</head>

<body>
  <nav class="navbar navbar-expand-md bg-dark navbar-dark">
    <!-- Brand -->
    <a class="navbar-brand" href="index.php"><i class="fas fa-wallet"></i>&nbsp;&nbsp;Cold Wallet Store</a>

    <!-- Toggler/collapsibe Button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar links -->
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav ml-auto">
        <!-- 是否登入? -->
        <?php if (!isset($_SESSION['username'])) { ?>
          <li class="nav-item text-white">
            <a href="Login.php" class="nav-link">Login</a>
          </li>
        <?php
        } else { ?>
          <li class="nav-item text-white">
            <a href="home.php" class="nav-link"><?php echo "Welcome " . $_SESSION['username'] . "</h1>"; ?></a>
          </li>
        <?php
        }
        ?>
        <!-- ------------ -->
        <li class="nav-item">
          <a class="nav-link" href="index.php">Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="Checkout.php">Checkout</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="cart.php"><i class="fas 
          fa-shopping-cart"></i><span id="cart-item" class="badge badge-danger">1</span>
          </a>
        </li>
        <!-- Logout -->
        <?php if (!isset($_SESSION['username'])) { ?>

        <?php
        } else { ?>
          <li class="nav-item text-white">
            <a href="logout.php" class="nav-link">Logout</a>
          </li>
        <?php
        }
        ?>
        <!-- ------------ -->
      </ul>
    </div>
  </nav>
  <!-- Navbar end -->

  <div class="container">
    <?php
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $products = $_POST['products'];
    $grand_total = $_POST['grand_total'];
    $address = $_POST['address'];
    $pmode = $_POST['pmode'];

    $data = '';

    $stmt = $conn->prepare('INSERT INTO orders (name,email,phone,address,pmode,products,amount_paid)VALUES(?,?,?,?,?,?,?)');
    $stmt->bind_param('sssssss', $name, $email, $phone, $address, $pmode, $products, $grand_total);
    $stmt->execute();
    $data .= '<div class="text-center">
								<h1 class="display-4 mt-2 text-danger">Thank You!</h1>
								<h2 class="text-success">Your Order Placed Successfully!</h2>
								<h4 class="bg-danger text-light rounded p-2">Items Purchased : ' . $products . '</h4>
								<h4>Your Name : ' . $name . '</h4>
								<h4>Your E-mail : ' . $email . '</h4>
								<h4>Your Phone : ' . $phone . '</h4>
								<h4>Total Amount Paid : ' . number_format($grand_total, 3) . '</h4>
								<h4>Payment Mode : ' . $pmode . '</h4>
						  </div>';
    echo $data;
    $stmt = $conn->prepare("DELETE FROM cart");
    $stmt->execute();
    ?>
  </div>

  <!-- Displaying Products End -->
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js'></script>

  <script type="text/javascript">
    $(document).ready(function() {

      /*$("#placeOrder").submit(function(e) {
        e.preventDefault();
        $.ajax({
          url: 'action.php',
          method: 'post',
          data: $('form').serialize() + "&action=order",
          success: function(response) {
            $("#order").html(response);
          }
        });
      });*/

      load_card_item_number();

      function load_card_item_number() {
        $.ajax({
          url: 'action.php',
          method: 'get',
          data: {
            cartItem: "cart_item"
          },
          success: function(response) {
            $("#cart-item").html(response);
          }
        });
      }
    });
  </script>
</body>

</html>