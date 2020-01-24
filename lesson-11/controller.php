<?php
declare(strict_types=1);
session_start();

/*
 * Проверка наличия необходимого набора данных
 */

$requiredFields = [
    'email',
    'age',
    'password',
    'password_confirm'
];

$rawData = [];

foreach ($requiredFields as $field) {
    if (isset($_POST[$field]) && strlen($_POST[$field])) {
        $rawData[$field] = trim($_POST[$field]);
    } else {
        // Если хотя бы одно из полей пустое, выводим ошибку
        $_SESSION['errors'] = [
            $field => [
                'message' => 'The field must be filled in!'
            ]
        ];
        header('Location: /lesson-11/form.phtml');
        exit();
    }
}

/*
 * Подготовка данных для валидации
 */

$data = [
    'email' => htmlspecialchars($rawData['email']),
    'age' => (int)$rawData['age'],
    'password' => password_hash($rawData['password'], PASSWORD_DEFAULT)
];

/*
 * Валидация полей
 */

if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    $_SESSION['errors']['email'] = [
        'message' => 'Email address is not valid!'
    ];
}

$requiredAge = 14;
if ($data['age'] < $requiredAge) {
    $_SESSION['errors']['age'] = [
        'message' => 'Sorry! You are to young!'
    ];
}

if ($rawData['password'] !== $rawData['password_confirm']) {
    $_SESSION['errors']['password_confirm'] = [
        'message' => 'Incorrect password confirmation!'
    ];
}

if (isset($_SESSION['errors'])) {
    header('Location: /lesson-11/form.phtml');
    exit();
} else {
    $dir = __DIR__ . '/database';
    // Если нет директории, создаём её
    if (!mkdir($dir, 0777, true) && !is_dir($dir)) {
        throw new \RuntimeException(sprintf('Directory "%s" was not created', $dir));
    }

    $filepath = $dir . '/users.json';
    $addUsers = [];
    if (file_exists($filepath)) {
        /*
         * Если файл уже существует, проверяем нет ли там юзера с таким же имейлом
         */
        $content = file_get_contents($filepath);
        $users = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        foreach ($users as $user) {
            if ($data['email'] === $user['email']) {
                $_SESSION['errors'] = [
                    'email' => [
                        'message' => 'This email already exists! Please, choose another one'
                    ]
                ];
                header('Location: /lesson-11/form.phtml');
                exit();
            } else {
                $addUsers[] = $user;
            }
        }
        $addUsers[] = $data;
        file_put_contents(
            $filepath,
            json_encode($addUsers, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT, 512)
        );
    } else {
        /*
        * Записываем данные в файл
        */
        $addUsers[] = $data;
        file_put_contents(
            $filepath,
            json_encode($addUsers, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT, 512)
        );
    }

    /*
     * Если не было ошибок, юзер зарегистрирован
     */
    if (!isset($_SESSION['errors'])) {
        $_SESSION['success'] = [
            'message' => 'Congratulations! You are registered now!'
        ];
        header('Location: /lesson-11/form.phtml');
        exit();
    }
}
