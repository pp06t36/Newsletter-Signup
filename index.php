<?php
  if(isset($_GET['msg'])) {
    $msg = "Success";
  } elseif (isset($_GET['error'])) {
    $msg = $_GET['error'];
  }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
    />
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Newsletter Signup</title>
    <link rel="stylesheet" href="style.css"/>
  </head>
  <body>
    <section id="sign_up">
      <div class="container row">
        <h5 class="card-title">Newsletter</h5>
        <div class="form_container">
          <form class="form-inline" action="newsletter-signup.php" method="post">
            <div class="form name_form">
              <input type="text" name="name" placeholder="Name.." required /> 
            </div>
            <div class="form email_form">
              <input type="email" name="email" placeholder="Email.." required />
            </div>
            <button type="submit" class="button_one">Submit</button>
          </form>
        </div>
      </div>
    </section>
    <script>
      <?php
        if(isset($msg))
        echo "alert('$msg');";
      ?>
    </script>
  </body>
</html>
