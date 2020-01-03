<?php
$mathResult = [];

if (!empty($_POST['task'])) {
    foreach ($_POST['task'] as $task) {
        $left     = (int)$task['first_operand'];
        $right    = (int)$task['second_operand'];
        $operator = $task['operator'];

        $result = 0;
        switch ($operator) {
            case '+':
                $result = $left + $right;
                break;
            case '-':
                $result = $left - $right;
                break;
            case '*':
                $result = $left * $right;
                break;
            case '/':
                $result = $left / $right;
                break;
            case '%':
                $result = $left % $right;
                break;
            case '**':
                $result = $left ** $right;
                break;
        }

        $mathResult[] = [
            'task_str'     => $left . ' ' . $operator . ' ' . $right,
            'user_answer'  => $task['answer'],
            'check_answer' => $result,
            'check_result' => ($task['answer'] == $result),
        ];
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Контрольная по арифметике</title>
</head>
<body>
<h2>Результат</h2>
<?php foreach ($mathResult as $res): ?>
    <?= $res['task_str'] ?> = <?= $res['user_answer'] ?> <?= ($res['check_result']) ? '<span style="color: green; padding-left: 20px">Правильно!</span>' : '<span style="color: red; padding-left: 20px">Неправильно!</span> Верный ответ ' . $res['check_answer'] ?>
    <br/>
<?php endforeach; ?>
</body>
</html>