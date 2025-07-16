<?php
// Sanitizar entradas
$name = htmlspecialchars(trim($_POST['name'] ?? ''));
$phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
$emailHelp = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$comments = htmlspecialchars(trim($_POST['comments'] ?? ''));

// Validar campos obligatorios
if (!empty($name) && !empty($phone) && !empty($emailHelp) && filter_var($emailHelp, FILTER_VALIDATE_EMAIL)) {

    $to_email = "rmayra2010@gmail.com";
    $subject = "Nuevo mensaje desde el formulario de contacto";

    $message = "
    <html>
    <head><title>Nuevo mensaje</title></head>
    <body>
        <p><strong>Nombre:</strong> {$name}</p>
        <p><strong>Email:</strong> {$emailHelp}</p>
        <p><strong>Teléfono:</strong> {$phone}</p>
        <p><strong>Mensaje:</strong><br>{$comments}</p>
        <p><strong>IP del usuario:</strong> " . $_SERVER['REMOTE_ADDR'] . "</p>
        <p>Enviado desde: " . $_SERVER['HTTP_HOST'] . " el día " . date('d-m-Y') . "</p>
    </body>
    </html>
    ";

    $headers  = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "From: {$name} <{$emailHelp}>\r\n";
    $headers .= "Reply-To: {$emailHelp}\r\n";

    if (mail($to_email, $subject, $message, $headers)) {
        $status = 'success';
        $output = "Felicidades {$name}, tu mensaje se ha enviado correctamente. ¡Pronto nos comunicaremos contigo!";
    } else {
        $status = 'error';
        $output = "Lo siento, el mensaje no se pudo enviar. Intenta de nuevo más tarde.";
    }

} else {
    $status = 'error';
    $output = "Por favor, llena todos los campos requeridos con información válida.";
}

// Devolver respuesta JSON
echo json_encode(['status' => $status, 'msg' => $output]);
?>
