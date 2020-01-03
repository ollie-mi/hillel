<?php

// Получение количества примеров
$num = (int)$_GET['num'];

// массив операций
$mathOperations = ['+', '-', '*', '/', '%', '**'];

// формирование массива примеров
$tasks = [];
for ($i = 0; $i < $num; ++$i) {
    $tasks[$i] = [
        'first_operand'  => random_int(-100, 100),
        'operator'       => $mathOperations[array_rand($mathOperations)],
        'second_operand' => random_int(-100, 100),
    ];
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
<form action="check.php" method="post">
    <fieldset>
        <?php if (!empty($tasks)): ?><?php foreach ($tasks as $key => $task): ?>
            <input type="hidden" name="task[<?= $key ?>][first_operand]" value="<?= $task['first_operand'] ?>">
            <input type="hidden" name="task[<?= $key ?>][operator]" value="<?= $task['operator'] ?>">
            <input type="hidden" name="task[<?= $key ?>][second_operand]" value="<?= $task['second_operand'] ?>">
            <label for="task_<?= $key ?>"><?= $task['first_operand'] . ' ' . $task['operator'] . ' ' . $task['second_operand'] ?>
                = </label><input type="number" id="task_<?= $key ?>" name="task[<?= $key ?>][answer]"><br/>
        <?php endforeach; ?>
            <button type="submit">Calculate</button>
        <?php else: ?>
            <h3>Вы ввели 0 примеров!</h3>
        <?php endif; ?>
    </fieldset>
</form>
</body>
</html>

