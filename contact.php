<!--
	TODO List:
    - CSS for page
    - PHP script for mailing
    - if (@mail....) for checking if sent
-->
<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['email'])) { 

            $to = "zdonato@stevens.edu";  
            $cc = ""; 
            $reg_ex_email = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
            $reg_ex_str = "/^[A-Za-z .'-]+$/"; 
            $headers = ""; 
            $message = ""; 

            // Fix the data for security. 
            function fix_input($inp){
                $inp = trim($inp);
                $inp = stripslashes($inp);
                $inp = htmlspecialchars($inp);
                return $inp; 
            }
            
            // Fields of the form.
            $fname = fix_input($_POST['firstname']);
            $lname = fix_input($_POST['lastname']);
            $email_from = fix_input($_POST['email']);
            $comments = fix_input($_POST['message']); 
            $join_email = $_POST['join_list'];

            // Ensure required data exists. 
            if (!isset($_POST['fname']) || !preg_match($reg_ex_str, $fname)) {
                header("Location: submit.php?success=3");
            }

            if (!isset($_POST['lname']) || !preg_match($reg_ex_str, $lname)) {
                header("Location: submit.php?success=4");
            }

            if (!isset($_POST['email']) || !preg_match($reg_ex_email, $email_from)) {
                header("Location: submit.php?success=5");
            }

            if (!isset($_POST['message']) || strlen($comments) < 2 ) {
                header("Location: submit.php?success=6"); 
            }

            $subj = "Message from " . $fname . " " . $lname; 
            $message .= "First Name: " . $fname . "\nLast Name: " . $lname . "\nEmail: " . $email_from . "\n"; 
            echo $join_email;
            if ($join_email == 'yes'){
                $message .= "Join email list: YES\n";
            } else {
                $message .= "Join email list: NO\n"; 
            }
            $message .= "\nMessage: " . $comments . "\n\n";
            $headers .= "From: SCSC-Contact@stevens.edu\r\n"; 

            //Send the email. 
            //&& mail($cc, $subj, $message, $headers
            if (mail($to, $subj, $message, $headers) ){
                header("Location: submit.php?success=1");
            } else {
                header("Location: submit.php?success=0");
            }
        } // End isset email. 
    } // End server request check. 
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
            <h1> Have a question? Want to join the email list? Contact us below!</h1> <br>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <input type="text" name="firstname" id="fname" placeholder="First Name" required autofocus width="32"/> <br> <br> 
                <input type="text" name="lastname" id="lname" placeholder="Last Name" required width="32"/> <br> <br> 
                <input type="email" name="email" id="email" required width="64" placeholder="Primary Email"/> <br> <br>
                <textarea type="text" name="message" id="message" cols="41" rows="15" maxlength="2000"  required placeholder="Message"></textarea> <br> <br> 
                <label for="join_list" id="join_label" value="yes"> Join E-Mail List</label>
                <input type="radio" id="join_list"></input><br><br>
                <button type="submit" value="submit" class="btn btn-primary" id="form_but"> Send </button>
            </form>
        </section>
        <footer>
            Some social media stuff here, orgsync, idfk
        </footer>
    </body>
</html>