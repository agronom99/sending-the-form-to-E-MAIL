<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/scr/Exception.php';
require 'phpmailer/scr/PHPMailer.php';

$mail=new PHPMailer(true);
$mail->CharSet = 'UTF-8';
$mail->setLanguage('uk', 'phpmailer/language/');
$mail->IsHTML(true);

// Від кого лист
$mail->setForm('agronom99.github.io', 'Фрилансер по життю');
// кому відправити
$mail->addAddress('agronom9913@gmail.com');
// Тема листа
$mail->Subject = 'Привіт! Це "Фрилансер по життю" ';

// Рука
$hand ="Правая";
if($_POST['hand']=="left"){
    $hand="Ліва";
}

// Тіло листа
$body='<h1>Зустрічайте супер лист!</h1>';

if(trim(!empty($_POST['name']))){
    $body.='<p><strong>Ім`я:</strong> '.$_POST['name'].'</p>';
}
if(trim(!empty($_POST['email']))){
    $body.='<p><strong>E-mail:</strong> '.$_POST['email'].'</p>';
}
if(trim(!empty($_POST['hand']))){
    $body.='<p><strong>Рука:</strong> '.$hand.'</p>';
}
if(trim(!empty($_POST['age']))){
    $body.='<p><strong>Возраст:</strong> '.$_POST['age'].'</p>';
}

if(trim(!empty($_POST['message']))){
    $body.='<p><strong>Повідомлення:</strong> '.$_POST['message'].'</p>';
}

// Прікрипити файл
if(!empty($_FILES['image']['tmp_name'])) {
    // шлях загрузки файла
    $filePath = __DIR__ . "/files/" . $_FILES['image']['name'];
    // грузимо файл
    if(copy($_FILES['image']['tmp_name'], $filePath)){  
        $fileAttach = $filePath;
        $body.='<p><strong>Фото в додатку</strong></p>';
        $mail->addAttachment($fileAttach);
    }
}

$mail->Body = $body;

// Відправляємо
if($!mail->send()) {
    $message = 'Помилка';
} else{
    $message = 'Данні відправлено';
}

$response = ['message' => $message];

header('Content-type: application/json');
echo json_encode($response);
?>






