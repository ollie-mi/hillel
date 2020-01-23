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
        $_SESSION['errors'] = [
            $field => [
                'message' => 'The field must be filled in!'
            ]
        ];
    }
}

/*
 * Если хотя бы одно из полей пустое, выводим ошибку
 */
if (isset($_SESSION['errors'])) {
//    header('Location: /lesson-11/form.phtml');
    header('Location: form.php');
    exit();
}

/*
 * Подготовка данных для валидации
 */

$data = [
    'email' => htmlspecialchars($rawData['email']),
    'age' => (int) $rawData['age'],
    'password' => password_hash($rawData['password'], PASSWORD_DEFAULT)
];

/*
 * Валидация полей
 */

if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    $_SESSION['errors'] = [
        'email' => [
            'message' => 'Email address is not valid!'
        ]
    ];
}

$requiredAge = 14;
if ($data['age'] < $requiredAge) {
    $_SESSION['errors'] = [
        'age' => [
            'message' => 'Sorry! You are to young!'
        ]
    ];
}

if ($rawData['password'] !== $rawData['password_confirm']) {
    $_SESSION['errors'] = [
        'password_confirm' => [
            'message' => 'Incorrect password confirmation!'
        ]
    ];
}

if (isset($_SESSION['errors'])) {
//    header('Location: /lesson-11/form.phtml');
    header('Location: form.php');
    exit();
} else {
    $filename = __DIR__ . '/database/users.json';
    $addUsers = [];
    if (file_exists($filename)) {
        $content = file_get_contents($filename);
        $users = json_decode($content, true);
        foreach ($users as $user) {
            if ($data['email'] === $user['email']) {
                $_SESSION['errors'] = [
                    'email' => [
                        'message' => 'This email already exists! Please, choose another one'
                    ]
                ];
//                header('Location: /lesson-11/form.phtml');
                header('Location: form.php');
                exit();
            } else {
                $addUsers[] = $user;
            }
        }
        $addUsers[] = $data;
        file_put_contents(
            $filename,
            json_encode($addUsers, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
        );
        //        header('Location: /lesson-11/form.phtml');
        header('Location: form.php');
        exit();
    } else {
        /*
        * Записываем данные в файл
        */
        $addUsers[] = $data;
        file_put_contents(
            $filename,
            json_encode($addUsers, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
        );

        $_SESSION['success'] = [
            'message' => 'Congratulations! You are registered now!'
        ];

        /*
        * Перенаправляем обратно
        */
//        header('Location: /lesson-11/form.phtml');
        header('Location: form.php');
        exit();
    }
}


//if (isset($_POST['year'], $_POST['month'], $_POST['day'])) {
//
//    $year = (int)$_POST['year'];
//    $month = (int)$_POST['month'];
//    $day = (int)$_POST['day'];
//
//    $requiredTime = strtotime('-18 years');
//    $userTime = strtotime("{$year}/{$month}/{$day}");
//
//    if ($userTime < $requiredTime) {
//        // Проходи
//    } else {
//        $_SESSION['errors'] = [
//            'age' => [
//                'value' => $year,
//                'message' => 'Доступ запрещен!'
//            ]
//        ];
//
//        header('Location: /lesson-11/validation/form.php');
//    }
//}