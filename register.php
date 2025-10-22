<?php
require_once('db.php');

// Включим отображение ошибок для отладки
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Получаем данные из формы
$name = $_POST['name'];
$surname = $_POST['surname'];
$birthday = $_POST['birthday'];
$country = $_POST['country'];
$email = $_POST['email'];
$password = $_POST['pass'];
$passconfirm = $_POST['passconfirm'];

// Проверяем совпадение паролей
if ($password != $passconfirm) {
    header('Location: register-error.html?error=password_mismatch');
    exit;
}

// Проверяем, существует ли уже пользователь с таким email
$check_sql = "SELECT id FROM users WHERE email = ?";
$check_stmt = $conn->prepare($check_sql);

if ($check_stmt) {
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_stmt->store_result();
    
    // Если пользователь с таким email уже существует
    if ($check_stmt->num_rows > 0) {
        header('Location: register-error.html?error=email_exists');
        exit;
    }
    
    $check_stmt->close();
} else {
    header('Location: register-error.html?error=db_error');
    exit;
}

// Хешируем пароль
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Безопасный SQL-запрос для вставки
$sql = "INSERT INTO `users` (name, surname, birthday, country, email, password) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("ssssss", $name, $surname, $birthday, $country, $email, $hashed_password);
    
    if ($stmt->execute()) {
        // УСПЕШНАЯ РЕГИСТРАЦИЯ
        header('Location: success.html');
        exit;
    } else {
        header('Location: register-error.html?error=registration_failed');
        exit;
    }
    
    $stmt->close();
} else {
    header('Location: register-error.html?error=db_error');
    exit;
}

$conn->close();
?>