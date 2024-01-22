<?php
require_once __DIR__ . '/../../infra/middlewares/middleware-not-authenticated.php';
include_once __DIR__ . '../../../templates/header.php'; ?>

<main>
  <section>
    <?php
    if (isset($_SESSION['success'])) {
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
      echo $_SESSION['success'] . '<br>';
      echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
      unset($_SESSION['success']);
    }
    if (isset($_SESSION['errors'])) {
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
      foreach ($_SESSION['errors'] as $error) {
        echo $error . '<br>';
      }
      echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
      unset($_SESSION['errors']);
    }
    ?>
  </section>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link rel="stylesheet" href="<?php BASE_URL?>/BuyTime/assets/css/style.css">

  <form action="/BuyTime/controllers/auth/register.php" method="post">
  
  <div class="container d-flex justify-content-center align-items-center min-vh-100">

  <div class="row border rounded-5 p-3 bg-white shadow box-area">

  <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="background: #a4a9ea;">
      <div class="featured-image mb-3">
        <img src="/BuyTime/assets/images/register.png" class="img-fluid" alt="Buy Time Register">
      </div>
      <p class="text-white fs-2 text-center" style="font-family: 'Courier New', Courier, monospace; font-weight: 600;">Buy Time</p>
      <small class="text-white text-wrap text-center" style="width: 17rem; font-family: 'Courier New', Courier, monospace;">Organize your tasks on this platform.</small>
    </div>

    <div class="col-md-6 right-box">
      <form>
        <div class="row align-items-center">
          <div class="header-text mb-4 text-center">
            <h2>Register</h2>
            <p>Welcome to the family.</p>
          </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="name" placeholder="Name" maxlength="100" size="100"
            value="<?= isset($_REQUEST['name']) ? $_REQUEST['name'] : null ?>" required>
        </div>
        <div class="input-group mb-3">
          <input type="email" class="form-control" id="floatingInput" name="email" placeholder="Email"
            value="<?= isset($_REQUEST['email']) ? $_REQUEST['email'] : null ?>">
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" id="password" name="password" placeholder="Password">
        </div>
        <div class="input-group mb-5">
          <input type="password" class="form-control" id="confirmar_palavra_passe" name="confirmar_palavra_passe"
            placeholder="Confirm Password">
        </div>
        <div class="input-group mb-3">
          <button class="btn btn-lg btn-color w-100 fs-6" type="submit" name="user" value="register">Register</button>
        </div>
        <div class="input-group mb-3">
            <a href="/BuyTime" class="btn btn-lg btn-color w-100 fs-6">Back</a>
        </div>
      </div>
    </div>
  </form>
</div>
</div>
</div>

<?php
include_once __DIR__ . '../../../templates/footer.php'; ?>
