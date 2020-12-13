<?php

// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Check If User Came From A POST Request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Assign Form Data To Variables With Filtering It
  $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
  $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
  $subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);
  $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

  // Array Of Errors [In Case Of More Than One Validation]
  $formErrors = array();

  // Validate Name
  if (strlen($name) <= 2) {
    $formErrors[] = 'your name should not be less than <strong>3</strong> characters';
  }

  // Send Data To Email If There Is No Errors
  if (empty($formErrors)) {
    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);
    try {
      //Server settings
      $mail->SMTPDebug = 0;
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->SMTPAuth = true;
      // Enter Google Email To Send Messages With It (ex: example@gmail.com)
      $mail->Username = '';
      // you should add a google mail which allow the (Less Secure App Access), otherwise the message will not be sent with this email. You can manage that from google email security settings

      // Enter Password For Previous Google Email
      $mail->Password = '';
      $mail->SMTPSecure = 'tls';
      $mail->Port = 587;

      //Recipients
      $mail->setFrom($email, $name);
      // Enter The Following Info -> addAddress(Your Email To Receive Emails, You Name)
      $mail->addAddress('', '');
      $mail->addReplyTo($email, $name);

      // Content
      $mail->isHTML(true);
      $mail->Subject = $subject;
      $mail->Body = $message;
      $mail->AltBody = $message;

      // Send Message
      $mail->send();

      // Empty Fields
      $name = '';
      $email = '';
      $subject = '';
      $message = '';

      // Success Message
      $successMessage =
        '<div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            Your Message Has Been Sent Successfully
            </div>';
    } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      // Fail Message
      $failMessage =
        '<div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            Message could not be sent. Mailer Error (Server Side Error)
            </div>';
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Meta -->
  <meta charset="UTF-8"/>
  <meta name="author" content="Mohamed Salah"/>
  <meta name="keywords" content="contact form, PHP contact form"/>
  <meta name="description" content="PHP Contact Form"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

  <!-- Title -->
  <title>Contact Form</title>

  <!-- Fontawesome -->
  <link rel="stylesheet" href="css/fontawesome.min.css"/>

  <!-- CSS -->
  <link rel="stylesheet" href="css/bootstrap.min.css"/>
  <link rel="stylesheet" href="css/style.css"/>
</head>

<body>
<!-- Start Form -->
<div class="container">
  <div class="form-container">
    <h1 class="text-center">Contact Me</h1>
    <div class="error">
      <?php
      if (isset($formErrors)) {
        foreach ($formErrors as $error) { ?>
          <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?php echo $error; ?>
          </div>
        <?php }
      } ?>
    </div>
    <?php if (isset($successMessage)) {
      echo $successMessage;
    } else if (isset($failMessage)) {
      echo $failMessage;
    } ?>
    <form class="contact-form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
      <span class="required">*</span>
      <input class="form-control" type="text" name="name" placeholder="Your Name" value="<?php if (isset($name)) {
        echo $name;
      } ?>" required>
      <i class="fas fa-user fa-fw"></i>
      <span class="required">*</span>
      <div class="error-name">
        <div class="alert alert-danger alert-dismissible fade show">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          your name should not be less than <strong>3</strong> characters
        </div>
      </div>
      <input class="form-control" type="email" name="email" placeholder="Your Email" value="<?php if (isset($email)) {
        echo $email;
      } ?>" required>
      <i class="fas fa-envelope fa-fw"></i>
      <span class="required">*</span>
      <input class="form-control" type="text" name="subject" placeholder="Message Subject"
             value="<?php if (isset($subject)) {
               echo $subject;
             } ?>" required>
      <i class="fas fa-comment-alt fa-fw"></i>
      <span class="required">*</span>
      <textarea class="form-control" name="message" placeholder="Your Messsage" required><?php if (isset($message)) {
          echo $message;
        } ?></textarea>
      <input class="btn btn-success" type="submit" value="Send Message">
      <i class="fas fa-paper-plane"></i>
    </form>
  </div>
  <hr>
  <footer>
      <div class="container">
        <div class="row">
          <!-- Copyright -->
          <div class="copyright text-center text-lg-left col-lg-6">
            <p>© 2020 | <span>Mohamed Salah</span></p>
          </div>
          <!-- Links -->
          <div class="links text-center text-lg-right col-lg-6">
            <a href="https://github.com/salahineo" target="_blank">
              <i class="fab fa-github"></i>
            </a>
            <a href="https://www.linkedin.com/in/salahineo/" target="_blank">
              <i class="fab fa-linkedin-in"></i>
            </a>
            <a href="https://www.behance.net/salahineo" target="_blank">
              <i class="fab fa-behance"></i>
            </a>
            <a href="https://salahineo.github.io/salahineo/" target="_blank">
              <i class="fas fa-globe-africa"></i>
            </a>
            <a href="https://twitter.com/salahineo" target="_blank">
              <i class="fab fa-twitter"> </i>
            </a>
            <a href="https://www.facebook.com/salahineo/" target="_blank">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="mailto:salahineo.work@gmail.com" target="_blank">
              <i class="fas fa-envelope"></i>
            </a>
          </div>
        </div>
      </div>
    </footer>
</div>
<!-- End Form -->

<!-- Script -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/custom.js"></script>
</body>

</html>
