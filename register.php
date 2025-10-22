<?php
require_once('db.php');

// Получаем данные из формы
$name = $_POST['name'];
$surname = $_POST['surname'];
$birthday = $_POST['birthday'];
$country = $_POST['country'];
$email = $_POST['email'];
$password = $_POST['pass']; // исправлено!
$passconfirm = $_POST['passconfirm'];

// Проверяем совпадение паролей
if ($password != $passconfirm) {
    echo "Пароли не совпадают";
    exit;
}

// Хешируем пароль
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Безопасный SQL-запрос
$sql = "INSERT INTO `users` (name, surname, birthday, country, email, password) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("ssssss", $name, $surname, $birthday, $country, $email, $hashed_password);
    
    if ($stmt->execute()) {
        echo "Вы зарегистрированы!";
    } else {
        echo "Ошибка базы данных: " . $stmt->error;
    }
    
    $stmt->close();
} else {
    echo "Ошибка подготовки запроса: " . $conn->error;
}

$conn->close();
?>