<?php
session_start();
require_once('db.php');

// Включите отображение ошибок для отладки
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Получаем данные из формы
$email = $_POST['email'];
$password = $_POST['pass']; 

// Проверяем, что данные получены
if (empty($email) || empty($password)) {
    die("Email и пароль обязательны для заполнения");
}

// Безопасный SQL-запрос с подготовленными выражениями
$sql = "SELECT * FROM `users` WHERE email = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Проверяем пароль
        if (password_verify($password, $user['password'])) {
            // УСПЕШНЫЙ ЛОГИН - устанавливаем сессию
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_name'] = $user['name'] . ' ' . $user['surname'];
            
            // Перенаправляем на страницу профиля
            header('Location: profile.html');
            exit;
            
        } else {
            // Неверный пароль
            header('Location: login-error.html?error=password');
            exit;
        }
    } else {
        // Пользователь не найден
        header('Location: login-error.html?error=user_not_found');
        exit;
    }
    
    $stmt->close();
} else {
    header('Location: login-error.html?error=db_error');
    exit;
}

$conn->close();
?>