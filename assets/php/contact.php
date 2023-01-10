<?php

    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
        $name = strip_tags(trim($_POST["name"]));
				$name = str_replace(array("\r","\n"),array(" "," "),$name);
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $message = trim($_POST["message"]);

        // Check that data was sent to the mailer.
        if ( empty($name) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Veuillez compléter le formulaire et réessayer s'il vous plaît.";
            exit;
        }

        // Set the recipient email address.
        //FIXME update this to your desired email address.
        $recipient = "ebac.sn@gmail.com";

        // Set the email subject.
        $subject = "New contact from $name";

        // Build the email content.
        $email_content = "Nom: $name\n";
        $email_content .= "Email: $email\n\n";
        $email_content .= "Message:\n$message\n";

        // Build the email headers.
        $email_headers = "De: $name <$email>";

        // Send the email.
        if (mail($recipient, $email_headers, $email_content)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
            echo "Merci! Votre message a été envoyé.";
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Oups! Il y'a une erreur et nous n'avons pas pu envoyer votre message.";
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "Il y'a eu un problème, veuillez réessayer s'il vous plaît.";
    }



