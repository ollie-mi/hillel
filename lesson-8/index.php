<?php
declare(strict_types=1);

// 1-4
// humanizeDate - со всеми проверками

function humanizeDate(int $day, int $month, int $year = null) {

    if (isDayValid($day) === false) {
        exit('Неверно указан день');
    } elseif (isMonthValid($month) === false) {
        exit('Неверно указан месяц');
    } elseif (isDayOfMonthValid($day, $month, $year) === false) {
        exit('Invalid Argument Error: Неверное количество дней в месяце');
    }

    $monthsOfYear = [
        1  => 'января',
        2  => 'февраля',
        3  => 'марта',
        4  => 'апреля',
        5  => 'мая',
        6  => 'июня',
        7  => 'июля',
        8  => 'августа',
        9  => 'сентября',
        10 => 'октября',
        11 => 'ноября',
        12 => 'декабря',
    ];

    $result = $day . ' ' . $monthsOfYear[$month];

    if (!is_null($year)) {
        $result .= ' ' . abs($year) . ' года';
        if ($year < 0) {
            $result .= ' до н.э.';
        }
    }

    return $result;
}

function isDayValid(int $day) {
    return ($day > 0 && $day <= 31);
}

function isMonthValid(int $month) {
    return ($month > 0 && $month <= 12);
}

function isDayOfMonthValid(int $day, int $month, int $year = null) {

    switch ($month) {
        case 4:
        case 6:
        case 9:
        case 11:
            $numberOfDays = 30;
            break;
        case 2:
            $numberOfDays = 28;
            if (!is_null($year) && isLeapYear($year)) {
                $numberOfDays = 29;
            }
            break;
        default:
            $numberOfDays = 31;
            break;
    }
    return ($day <= $numberOfDays);
}

function isLeapYear(int $year) {
    $result = false;
    if ($year % 4 === 0) {
        if ($year % 100 === 0) {
            if ($year % 400 === 0) {
                $result = true;
            }
        } else {
            $result = true;
        }
    }
    return $result;
}

$dateString = humanizeDate(29, 2, 1704);

echo $dateString;



// 2-2
// convertEmptyStringToNull c $replaceKeys

function convertEmptyStringToNull (array $array, bool $replaceKeys = false) {
    $result = [];
    foreach ($array as $key => $value) {
        if ($replaceKeys && empty($value)) {
            continue;
        }
        $result[$key] = empty($value) ? NULL : $value;
    }
    return $result;
}

$input = ['a' => 'string', 'b' => '', 'c' => 42];

$new_array = convertEmptyStringToNull($input, true);

var_dump($new_array);



// 3-1
// isMultiDimensional

function isMultiDimensional (array $array) {
    $result = false;
    foreach ($array as $item) {
        if (is_array($item)) {
            $result = true;
        }
    }
    return $result;
}

$falseInput = [42,84,126];
var_dump(isMultiDimensional($falseInput));

$trueInput = [42, [84,126]];
var_dump(isMultiDimensional($trueInput));


// 3-5
// getArrayDimension

function getArrayDimension(array $array) {
    $counter = 1;
    $dimensions = 0;
    foreach ($array as $value) {
        if (is_array($value)) {
            $dimensions = getArrayDimension($value);
        }
    }
    if ($dimensions > 0) {
        $counter += $dimensions;
    }
    return $counter;
}

$array_1 = array(42, 84, 126);
var_dump(getArrayDimension($array_1));

$array_2 = array(42, array(84, 126));
var_dump(getArrayDimension($array_2));

$array_3 = array(42, array(84, array(126, 168)));
var_dump(getArrayDimension($array_3));


// 4-2
// filterArrayByType

function filterArrayByType (array $array, string $type) {
    $result = [];

    $type = strtolower($type);

    foreach ($array as $key => $value) {

        if ($type === 'string' && is_string($value)) {
            $result[$key] = $value;
        } elseif ($type === 'int' && is_int($value)) {
            $result[$key] = $value;
        } elseif (($type === 'float' || $type === 'decimal') && is_float($value)) {
            $result[$key] = $value;
        } elseif ($type === 'numeric' && is_numeric($value)) {
            $result[$key] = $value;
        } elseif ($type === 'array' && is_array($value)) {
            $result[$key] = $value;
        } elseif ($type === 'bool' && is_bool($value)) {
            $result[$key] = $value;
        }
    }

    if (empty($result)) {
        die('Неверно указан тип');
    }

    return $result;
}

$output_array = [123, '', 'array' => [1,2,3], 'float' => 12.5, 'int' => 567, 45.67, true, 'string' => 'hi'];

var_dump(filterArrayByType($output_array, 'float'));