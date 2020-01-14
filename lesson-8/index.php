<?php
declare(strict_types=1);

// Задача 1 - все уровни

function humanizeDate(int $day, int $month, int $year = null):string {

    if (isDayValid($day) === false) {
        die('Задача 1: Неверно указан день');
    } elseif (isMonthValid($month) === false) {
        die('Задача 1: Неверно указан месяц');
    } elseif (isDayOfMonthValid($day, $month, $year) === false) {
        die(' Задача 1: Invalid Argument Error: Неверное количество дней в месяце');
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

function isDayValid(int $day):bool {
    return ($day > 0 && $day <= 31);
}

function isMonthValid(int $month):bool {
    return ($month > 0 && $month <= 12);
}

function isDayOfMonthValid(int $day, int $month, int $year = null):bool {
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

function isLeapYear(int $year):bool {
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

// TESTING
// негативные тесты закомментарены

print 'ЗАДАЧА 1: humanizeDate';
var_dump(humanizeDate(14,1,2020));
var_dump(humanizeDate(14,1));
//var_dump(humanizeDate(-5,3, 2020));
//var_dump(humanizeDate(35,5, 2020));
//var_dump(humanizeDate(31,4, 2020));
//var_dump(humanizeDate(15,13, 2020));
var_dump(humanizeDate(14,1, -304));
var_dump(humanizeDate(29,2, 1600));
//var_dump(humanizeDate(29,2, 1703));

print "</br></br>";



// Задача 2 - все уровни

function convertEmptyStringToNull(array $array, bool $replaceKeys = false):array {
    $result = [];
    foreach ($array as $index => $value) {
        if ($replaceKeys && empty($value)) {
            continue;
        }
        $result[$index] = empty($value) ? null : $value;
    }
    return $result;
}

// TESTING
$input = ['a' => 'string', 'b' => '', 'c' => 42];

print 'ЗАДАЧА 2: convertEmptyStringToNull';
var_dump(convertEmptyStringToNull($input));
var_dump(convertEmptyStringToNull($input, true));

print "</br></br>";



// Задача 3 - 1 звездочка

function isMultiDimensional(array $array):bool {
    $result = false;
    foreach ($array as $item) {
        if (is_array($item)) {
            $result = true;
        }
    }
    return $result;
}

// TESTING
print 'ЗАДАЧА 3-1: isMultiDimensional';
$arrayNotMulti = [42, 84, 126];
var_dump(isMultiDimensional($arrayNotMulti));

$arrayIsMulty = [42, [84, 126]];
var_dump(isMultiDimensional($arrayIsMulty));

print "</br></br>";



// Задача 3 - 5 звездочек

function getArrayDimension(array $array): int {
    $counter = $arrayDimensions = 1;
    foreach ($array as $value) {
        if (is_array($value)) {
            $arrayDimensions = getArrayDimension($value) + 1;

            if ($arrayDimensions > $counter) {
                $counter = $arrayDimensions;
            }
        }
    }
    return $counter;
}

// TESTING
print 'ЗАДАЧА 3-5: getArrayDimension';

$array_1 = [42, 84, 126];
var_dump(getArrayDimension($array_1));

$array_2 = [42, [84, 126], 5];
var_dump(getArrayDimension($array_2));

$array_3 = [42, [84, [126, 168], [7,8]], [1,2]];
var_dump(getArrayDimension($array_3));

print "</br></br>";



// Задача 4

function filterArrayByType(array $array, string $type):array {
    $type = strtolower($type);

    $result = [];
    foreach ($array as $index => $value) {
        switch ($type) {
            case 'string':
                if (is_string($value)) {
                    $result[$index] = $value;
                }
                break;
            case 'int':
                if (is_int($value)) {
                    $result[$index] = $value;
                }
                break;
            case 'float':
            case 'decimal':
                if (is_float($value)) {
                    $result[$index] = $value;
                }
                break;
            case 'numeric':
                if (is_numeric($value)) {
                    $result[$index] = $value;
                }
                break;
            case 'array':
                if (is_array($value)) {
                    $result[$index] = $value;
                }
                break;
            case 'bool':
                if (is_bool($value)) {
                    $result[$index] = $value;
                }
                break;
        }
    }

    if (empty($result)) {
        die('Неверно указан тип');
    }

    return $result;
}

$input = [123, '', 'array' => [1, 2, 3], 'float' => 12.5, 'int' => 567, 45.67, true, 'string' => 'hi', 'hello'];

// TESTING
// негативные тесты закомментарены

print 'ЗАДАЧА 4: filterArrayByType';
var_dump(filterArrayByType($input, 'int'));
var_dump(filterArrayByType($input, 'float'));
var_dump(filterArrayByType($input, 'decimal'));
var_dump(filterArrayByType($input, 'numeric'));
var_dump(filterArrayByType($input, 'string'));
var_dump(filterArrayByType($input, 'array'));
var_dump(filterArrayByType($input, 'bool'));
//var_dump(filterArrayByType($input, 'number'));

print "</br></br>";



// Задача 5

function invertArray(array $array): array {
    $result = [];
    foreach ($array as $index => $value) {
        if (is_int($value) || is_string($value)) {
            $result[$value] = $index;
        } else {
            trigger_error('Значение массива не является строкой или целочисленным числом, потому не может стать ключом: ' . print_r($value, true));
        }
    }
    return $result;
}

// TESTING

print 'ЗАДАЧА 5: invertArray';
$input = [42, 84, 'a' => 'hello', '42' => 126, 'b' => [1,2,3], 4.5];
var_dump(invertArray($input));

print "</br></br>";



// Задача 6

// проверка, что все данные в матрице имеют тип integer
function isValidValues (array $array):bool {
    $result = true;
    foreach ($array as $value) {
        if (is_array($value)) {
            $result = isValidValues($value);
        } elseif (!is_int($value)) {
            return false;
        }
    }
    return $result;
}

// проверка квадратности матрицы
function isSquareMatrix (array $array):bool {
    $arrayDepth = count($array);
    foreach ($array as $value) {
        if (count($value) !== $arrayDepth) {
            return false;
        }
    }
    return true;
}

// детерминант для матрицы 2х2
function getMinorDeterminant(array $array): int {
    return +$array[0][0] * $array[1][1] - $array[0][1] * $array[1][0];
}

// определение минора - матрица 2х2
function isMinorArray(array $array): bool {
    if (count($array) !== 2) {
        return false;
    } else {
        if (isSquareMatrix($array) === false) {
            return false;
        }
    }
    return true;
}

function getMatrixDeterminant(array $array): int {
    if (isValidValues($array) === false) {
        die("Одно из значений матрицы не является целочисленным числом");
    } elseif (isSquareMatrix($array) === false) {
        die("Была передана не квадратная матрица");
    }

    $result = 0;
    if (isMinorArray($array)) {
        return getMinorDeterminant($array);
    } else {
        $firstRowValues = $array[0];
        $rowValuesCount = count($firstRowValues);
        unset ($array[0]);

        $minorArray = [];
        foreach ($array as $i => $value) {
            for ($j = 0; $j < $rowValuesCount; ++$j) {
                foreach ($value as $k => $item) {
                    if ($k !== $j) {
                        $minorArray[$j][$i - 1][] = $item;
                    }
                }
            }
        }

        foreach ($firstRowValues as $index => $value) {
            $determinant = isMinorArray($minorArray[$index]) ? getMinorDeterminant($minorArray[$index]) : getMatrixDeterminant($minorArray[$index]);
            if ($index % 2 === 0) {
                $result += $value * $determinant;
            } else {
                $result -= $value * $determinant;
            }
        }
    }
    return $result;
}

// TESTING

// генерим матрицу размером n x n
$dimension = 4;

$matrix = [];
for ($i = 0; $i < $dimension; ++$i) {
    for ($j = 0; $j < $dimension; ++$j) {
        $matrix[$i][$j] = random_int(-100, 100);
    }
}

print "ЗАДАЧА 6: getMatrixDeterminant</br>";
print 'Input array:';

var_dump($matrix);

print "Determinant: </br>";
var_dump(getMatrixDeterminant($matrix));

// негативные тесты
$inputFalse = [[2,3],[4,5],[1]];
//var_dump(getMatrixDeterminant($inputFalse));

$inputNotInt = [[1,2],['hi',7]];
//var_dump(getMatrixDeterminant($inputNotInt));

print "</br></br>";



// Задача 7 - все уровни

// сравнение мультимерного массива
function isDiffMultiArray(array $array1, array $array2):bool {
    if (count($array1) !== count($array2)) {
        return false;
    }
    foreach ($array1 as $index => $value) {
        if (is_array($value) && isset($array2[$index]) && is_array($array2[$index])) {
            $result = isDiffMultiArray($value, $array2[$index]);
        } elseif (!isset($array2[$index]) || $value !== $array2[$index]) {
            return false;
        }
    }
    return true;
}


function maxAggragate(array $array, array $result = []): array {
    foreach ($array as $value) {
            if ((is_int($value) || is_float($value))) {
                if (!isset($result['int']) || $value > $result['int']['value']) {
                    $result['int'] = [
                        'value' => $value,
                        'count' => 1,
                    ];
                } elseif ($value === $result['int']['value']) {
                    ++$result['int']['counter'];
                }
            } elseif (is_string($value)) {
                if (!isset($result['string']) || strlen($value) > strlen($result['string']['value'])) {
                    $result['string'] = [
                        'value' => $value,
                        'count' => 1,
                    ];
                } elseif ($value === $result['string']['value']) {
                    ++$result['string']['count'];
                }
            } elseif (is_array($value)) {
                if (!isset($result['array']) || count($value, COUNT_RECURSIVE) > count($result['array']['value'], COUNT_RECURSIVE)) {
                    $result['array'] = [
                        'value' => $value,
                        'count' => 1,
                    ];
                } elseif (isDiffMultiArray($value, $result['array']['value'])) {
                    ++$result['array']['count'];
                }
            }
    }
    return $result;
}

// TESTING
$input = [234, 'hello', [1 => [1, 2], 3], 'hellooooo', 867.7, [1, 2, 3], 'long string', [1, 2, 3, 4], [5, 6, 7], [1 => [1, 2], 3], 'long string'];

print 'ЗАДАЧА 7: maxAggragate';
var_dump(maxAggragate($input));

print "</br></br>";



// Задача 8

// для валидации большинства карт используется алгоритм Луна

/*
из Википедии:
1. Цифры проверяемой последовательности нумеруются справа налево.
2. Цифры, оказавшиеся на нечётных местах, остаются без изменений.
3. Цифры, стоящие на чётных местах, умножаются на 2.
4. Если в результате такого умножения возникает число больше 9, оно заменяется суммой цифр получившегося произведения — однозначным числом, то есть цифрой.
5. Все полученные в результате преобразования цифры складываются. Если сумма кратна 10, то исходные данные верны.
*/

function isValidCreditCard(int $cardNumber): bool {
    $cardNumberArray = str_split((string)$cardNumber);
    $cardReversed    = array_reverse($cardNumberArray);

    $checkSumArray = [];
    foreach ($cardReversed as $index => $digit) {
        if ($index % 2 !== 0) {
            $checkSumArray[] = ($digit * 2) > 9 ? ($digit * 2) - 9 : $digit * 2;
        } else {
            $checkSumArray[] = $digit;
        }
    }

    $finalCheckSum = array_sum($checkSumArray);

    return $finalCheckSum % 10 === 0;
}

// TESTING
print 'ЗАДАЧА 8: isValidCreditCard';

$validCardNumber      = 4650311185290471;
var_dump(isValidCreditCard($validCardNumber));

$validCardNumberShort = 347841835879866;
var_dump(isValidCreditCard($validCardNumberShort));

$notValidCardNumber   = 4650311185290472;
var_dump(isValidCreditCard($notValidCardNumber));
