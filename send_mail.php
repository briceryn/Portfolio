<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));
    
    $errors = [];
    
    if (empty($name)) $errors[] = "Nom requis";
    if (empty($email)) $errors[] = "Email requis";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email invalide";
    if (empty($subject)) $errors[] = "Sujet requis";
    if (empty($message)) $errors[] = "Message requis";
    
    if (empty($errors)) {
        $to = "lawsonb0905@gmail.com";
        $email_subject = "Portfolio - $subject";
        
        $email_message = "
        <html>
        <head><title>$subject</title></head>
        <body>
            <h2>Message depuis votre portfolio</h2>
            <p><strong>Nom:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Sujet:</strong> $subject</p>
            <p><strong>Message:</strong></p>
            <p>$message</p>
        </body>
        </html>
        ";
        
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8\r\n";
        $headers .= "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        
        if (mail($to, $email_subject, $email_message, $headers)) {
            header("Location: index.html?success=1");
        } else {
            header("Location: index.html?error=mail");
        }
    } else {
        header("Location: index.html?error=" . urlencode(implode(",", $errors)));
    }
    exit();
}
?>
