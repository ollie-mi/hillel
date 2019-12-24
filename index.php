<?php

$input = [
    'phone_code'   => '+38',
    'phone_number' => '(000) 111-2233',
    'first_name'   => 'John',
    'middle_name'  => 'Malcolm',
    'last_name'    => 'Doe',
];

$phoneCode  = !empty($input['phone_code']) ? $input['phone_code'] . ' ' : '';
$middleName = !empty($input['middle_name']) ? $input['middle_name'] . ' ' : '';

$output = [
    'phone' => $phoneCode . $input['phone_number'],
    'name'  => $input['first_name'] . ' ' . $middleName . $input['last_name'],
];

?>


<ul>
    <?php foreach ($output as $key => $value): ?>
        <li>
            <?php if ($key == 'phone'): ?>
                <a href="tel:<?= $value ?>"><?= $value ?></a>
            <?php else: ?>
                <?= $value ?>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>
