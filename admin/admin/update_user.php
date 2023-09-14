<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
}
;

if (isset($_POST['update'])) {

    $id = $_POST['id'];
    $id = filter_var($id, FILTER_SANITIZE_STRING);
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $address = $_POST['address'];
    $address = filter_var($address, FILTER_SANITIZE_STRING);

    $update_product = $conn->prepare("UPDATE `users` SET name = ?, address = ?, email = ? WHERE id = ?");
    $update_product->execute([$name, $address, $email, $id]);

    $message[] = 'user updated!';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update user</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'?>

<!-- update product section starts  -->

<section class="update-product">

   <h1 class="heading">Update User</h1>

   <?php
$update_id = $_GET['update'];
$show_users = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
$show_users->execute([$update_id]);
if ($show_users->rowCount() > 0) {
    while ($fetch_users = $show_users->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?=$fetch_users['id'];?>">


            <span>Update username</span>
            <input type="text" required name="name" maxlength="100" class="box" value="<?=$fetch_users['name'];?>">

            <span>Update email</span>
            <input type="email"  required name="email" class="box" value="<?=$fetch_users['email'];?>">

            <span>Update address</span>
            <input type="text" required name="address" maxlength="100" class="box" value="<?=$fetch_users['address'];?>">

            <div class="flex-btn">
                <input type="submit" value="update" class="btn" name="update">
                <a href="users_accounts.php" class="option-btn">go back</a>
            </div>
        </form>
   <?php
}
} else {
    echo '<p class="empty">No user with that id is found !</p>';
}
?>

</section>

<!-- update user section ends -->










<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>