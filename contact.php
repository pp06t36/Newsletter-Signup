<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact</title>
</head>
<?php

    // Check for Header Injections
    function has_header_injection($str) {
        return preg_match( "/[\r\n]/", $str );
    }


    if (isset($_POST['contact_submit'])) {
        
        // Assign trimmed form data to variables
        // Note that the value within the $_POST array is looking for the HTML "name" attribute, i.e. name="email"
        $name	= trim($_POST['name']);
        $email	= trim($_POST['email']);
        $msg	= $_POST['message']; // no need to trim message

        // Check to see if $name or $email have header injections
        if (has_header_injection($name) || has_header_injection($email)) {
            
            die(); // If true, kill the script
            
        }
        
        if (!$name || !$email || !$msg) {
            echo '<h4 class="error">All fields required.</h4><a href="contact.php" class="button block">Go back and try again</a>';
            exit;
        }
        
        // Add the recipient email to a variable
        $to	= "myemail@gmail.com";
        
        // Create a subject
        $subject = "$name sent a message via your contact form";
        
        // Construct the message
        $message .= "Name: $name\r\n";
        $message .= "Email: $email\r\n\r\n";
        $message .= "Message:\r\n$msg";
        
        // If the subscribe checkbox was checked
        if (isset($_POST['subscribe']) && $_POST['subscribe'] == 'Subscribe' ) {
        
            // Add a new line to the $message
            $message .= "\r\n\r\nPlease add $email to the mailing list.\r\n";
            
        }

        $message = wordwrap($message, 72); // Keep the message neat n' tidy

        // Set the mail headers into a variable
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
        $headers .= "From: " . $name . " <" . $email . ">\r\n";
        $headers .= "X-Priority: 1\r\n";
        $headers .= "X-MSMail-Priority: High\r\n\r\n";

        
        // Send the email!
        mail($to, $subject, $message, $headers);

        try {
            $db = new PDO('mysql:host=127.0.0.1;dbname=Dname', 'root', '');
        } catch (PDOException $e) {
            // echo '<pre>';
            // print_r($e);
            // echo '</pre>';
            echo '<p>There seems to be an error</p>';
            echo '<br>';
            echo '<a href="/</a>';
            exit();
        }

        $customer = [
            'name' => isset($_POST['name']) ? $_POST['name'] : NULL,
            'email' => isset($_POST['email']) ? $_POST['email'] : NULL,
            'message' => isset($_POST['message']) ? $_POST['message'] : NULL,
            'created_at' => date("Y-m-d"), 
        ];

        $db->prepare("
            INSERT INTO contact (name, email, message, created_at) VALUES (:name, :email, :message, :created_at)
        ")->execute($customer);

        // Redirect browser
        header("/"); 
        exit();
    ?>

    <!-- Show success message after email has sent -->
    <h5>Thanks for contacting Us</h5>
    <p>Please allow 24 hours for a response.</p>
    <p><a href="/" class="button block">&laquo; Go to Home Page</a></p>

    <?php
        } else {
    ?>

    <section id="contact__form">
        <div class="container">
            <form method="post" action="" id="contact-form">
                <label for="name">Your name</label>
                <br>
                <input class="ct__form ct__name__form" type="text"  name="name" placeholder="Name...">
                
                <label for="email">Your email</label>
                <br>
                <input class="ct__form ct__name__form" type="email"  name="email" placeholder="Email...">
                
                <label for="message">Your message</label>
                <br>
                <textarea class="ct__form ct__name__form" name="message" placeholder="Your message..."></textarea>
                <br>
                <input type="checkbox" id="subscribe" value="Subscribe" name="subscribe"> <label for="subscribe">I'm not a robot</label>
                <br>
                <input class="ct__form ct__submit" type="submit" class="button next" name="contact_submit" value="Send Message">
            </form>
        
            <?php
                }
            ?>
        </div>
    </section>
		
  
