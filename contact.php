<!--
	TODO List:
    - CSS for page
    - PHP script for mailing
    - Find out how to set sender
    - Form validation
    - Set a success variable upon success or not (Structure based on what was wrong)
    - if (@mail....) for checking if sent
-->
<?php
    if (isset($_POST['email'])) { 

        $to = "jgardell@stevens.edu";  
        $cc = "pgrasso@stevens.edu"; 
        $reg_ex_email = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
        $reg_ex_str = "/^[A-Za-z .'-]+$/";
        $error = ""; 
        $headers = ""; 
        $message = ""; 

        // Fields of the form.
        $fname = $_POST['firstname'];
        $lname = $_POST['lastname'];
        $email_from = $_POST['email'];
        $comments = $_POST['message']; 

        function err($error) {
            echo "<p> There were error(s) with the form you have submitted. </p> <br>";
            echo "<p> The errors are as follows: </p> <br> <br> "; 
            echo $error . "<br> <br> "; 
            echo "<p> Please correct the error(s) and resubmit the form. <p>"; 
            echo "<a href='contact.php'> Click to return to form </a>"; 
            die(); 
        }

        // Ensure required data exists. 
        if (!isset($_POST['firstname']) || !preg_match($reg_ex_str, $fname)) {
            $error .= "<p> The first name you entered is not valid. </p> <br> ";
        }

        if (!isset($_POST['lastname']) || !preg_match($reg_ex_str, $lname)) {
            $error .= "<p> The last name you entered is not valid. </p>  <br> "; 
        }

        if (!isset($_POST['email']) || !preg_match($reg_ex_email, $email_from)) {
            $error .= "<p> The email you entered is not valid. </p> <br> "; 
        }

        if (!isset($_POST['message']) || strlen($comments) < 2 ) {
            $error .= "<p> The message you entered is not valid. <br> </p>"; 
        }

        // Call the error function if there was errors. 
        if (strlen($error) > 0) {
            err($error); 
        } else {
            $subj = "Message from " . $fname . " " . $lname; 
            $message .= "First Name: " . $fname . "\nLast Name: " . $lname . "\nEmail: " . $email_from . "\n\nMessage: " . $comments . "\n"; 
            $headers .= "From: " . $email_from . "\r\n"; 

            // Send the email. 
            mail($to, $subj, $message, $headers); 
            mail($cc, $subj, $message, $headers); 

            echo "<p>" . $fname . ", thank you for contacting us. You will receive an email from us shortly.</p> <br>"; 
            echo "<p> Click the link below to return to our homepage. </p> <br>"; 
            echo "<a href='home.html'> Home </a>"; 
        }
    } // End isset email. 
?> 
<html lang="en-US">
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="css/contact.css"/>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="javascript/smoothscroll.js"></script>
        <title>Stevens Computer Science Club</title>
    </head>
    <body>
        <header>
            <nav>
                <ul>
                    <li><h1><a href="index.html">SC<span class="superscript">2</span></a></h1></li>
                    <li><a href="index.html#about">About Us</a></li>
                    <li><a href="index.html#events">Events</a></li>
                    <li><a href="index.html#projects">Projects</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="index.html#">Anchor #5</a></li>
                </ul>
            </nav>
        </header>
        <section id="form-section"> 
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <input type="text" name="firstname" id="fname" placeholder="First Name" required autofocus width="32"/> <br> <br> 
                <input type="text" name="lastname" id="lname" placeholder="Last Name" required width="32"/> <br> <br> 
                <input type="email" name="email" id="email" required width="64" placeholder="Primary Email"/> <br> <br>
                <textarea type="text" name="message" id="message" cols="41" rows="15" maxlength="2000"  required placeholder="Message"></textarea> <br> <br> 
                <p id="rem"> Remaining:</p>
                <p id="charCount"> 2000 </p>
                <button type="submit" value="submit" class="btn btn-primary" id="formBut"> Send </button>
            </form>
        </section>
        <footer>
            Some social media stuff here, orgsync, idfk
        </footer>
    </body>
</html>