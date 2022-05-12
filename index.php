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

<body>
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
          <a class="nav-link active" href="index.php" id="Products">Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="Checkout.php" id="Checkout">Checkout</a>
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
  <!--跑一個迴圈，列出表格中的資料-->
  <div class="container">
    <div id="message"></div>
    <div class="row mt-4 pb-3">
      <?php
      include 'config.php';
      $stmt = $conn->prepare("SELECT * FROM product");
      $stmt->execute();
      $result = $stmt->get_result();
      /*
      $row['...']
      array(
    　　[id] => '1'
    　　[product_name] => 'CryptoStarterPack
    　　[product_price] => '950'
    　　[product_image] => 'image/CryptoStarterPack.webp'
        [product_code] => 'p1000'
      )
      */
      //_______________(while Loop)___________________
      while ($row = $result->fetch_assoc()) :
      ?>
        <div class="col-sm-6 col-md-4 col-lg-3 mb-2">
          <div class="card-deck">
            <div class="card p-2 border-secondary mb-2">
              <img src="<?= $row['product_image'] ?>" class="card-img-top" height="250">
              <div class="card-body p-1">
                <h4 class="card-title text-center text-info"><?= $row['product_name'] ?></h4>
                <h5 class="card-text text-center text-danger">
                  <i class="fab fa-ethereum text-secondary"></i>&nbsp;
                  <?= number_format($row['product_price'], 3) ?>
                </h5>
              </div>
              <div class="card-footer p-1">
                <form action="" class="form-submit">
                  <input type="hidden" class="pid" value="<?= $row['id'] ?>">
                  <input type="hidden" class="pname" value="<?= $row['product_name'] ?>">
                  <input type="hidden" class="pprice" value="<?= $row['product_price'] ?>">
                  <input type="hidden" class="pimage" value="<?= $row['product_image'] ?>">
                  <input type="hidden" class="pcode" value="<?= $row['product_code'] ?>">
                  <button class="btn btn-info btn-block addItemBtn">
                    <i class="fas fa-cart-plus">&nbsp;&nbsp;Add to cart</i></button>
                </form>
              </div>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
      <!--_______________(while End)___________________-->
    </div>
  </div>

  <!-- Displaying Products End -->
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js'></script>

  <script type="text/javascript">
    $(document).ready(function() {
      $(".addItemBtn").click(function(e) {
        e.preventDefault();
        var $form = $(this).closest(".form-submit");
        var pid = $form.find(".pid").val();
        var pname = $form.find(".pname").val();
        var pprice = $form.find(".pprice").val();
        var pimage = $form.find(".pimage").val();
        var pcode = $form.find(".pcode").val();

        $.ajax({
          url: 'action.php',
          method: 'post',
          data: {
            pid: pid,
            pname: pname,
            pprice: pprice,
            pimage: pimage,
            pcode: pcode
          },
          success: function(response) {
            $("#message").html(response);
            window.scrollTo(0, 0);
            load_card_item_number();
          }
        });
      });

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