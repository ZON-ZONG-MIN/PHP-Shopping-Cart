<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shopping Cart</title>

  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css' />
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css' />
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">

</head>

<body style="background:url('home.jpg');">
  <nav class="navbar navbar-expand-md bg-dark navbar-dark">
    <!-- Brand -->
    <a class="navbar-brand" href="home.php"><i class="fas fa-wallet"></i>&nbsp;&nbsp;Cold Wallet Store</a>

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
            <a href="Login.php" class="nav-link active">Login</a>
          </li>
        <?php
        } else { ?>
          <li class="nav-item text-white">
            <a href="home.php" class="nav-link active"><?php echo "Welcome " . $_SESSION['username'] . "</h1>"; ?></a>
          </li>
        <?php
        }
        ?>
        <!-- ------------ -->
        <li class="nav-item">
          <a class="nav-link" href="index.php">Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="Checkout.php">Checkout</a>
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
    <button class=" btn btn-warning " style="display:flex;
      position:fixed;
      top:70%;
      right:20%;">
      <a href="index.php" style="color:black; "><b>Shop Now</b></a></button>
  </div>

  <!-- Displaying Products End -->
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js'></script>
  <script type="text/javascript">
    $(document).ready(function() {

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