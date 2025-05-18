<?php

// generatePassword - генерация пароля по заданным параметрами
// вход:
//  - length - длина требуемого пароля, по умолчанию == 6; length >= 4 && length <= 20, иначе length == 6
//  - requiredSymbols - строка символов, обязательно встречающиеся в пароле (хотя бы 1 раз), по умолчанию пустая
//  - exludedSymbols - строка символов, которые не должны встречаться в пароле, по умолчанию пустая
//  - excludedCombinations - массив строк через variadic args, которые представляют сочетания, не встречающиеся в пароле
// выход:
//  - сгенерированный пароль если все параметры валидные
//  - null если входные параметры некорректные или генерация пароля не возможна по тем или иным причинам


function generatePassword(
    int $length=6, 
    string $requiredSymbols="", 
    string $exludedSymbols="", 
    string $characterPool="",
    string ...$excludedCombinations // массив строк
) : ?string {
     if ($length < 4 || $length > 20) {
        return null; // Длина пароля должна быть от 4 до 20 символов
    }
    if ($length < strlen($requiredSymbols)) {
        return null;
    }

    if (strlen(preg_replace('/(.)\1+/', '$1', $requiredSymbols)) !== strlen($requiredSymbols)) {
        return null; // Проверяем, что обязательные символы уникальны
    }

    if (!empty(array_intersect(str_split($requiredSymbols), str_split($exludedSymbols)))) {
        return null; // Исключенные символы не могут пересекаться с обязательными символами
    }

    // Проверка, что все обязательные символы входят в пулл
    // foreach (str_split($requiredSymbols) as $key => $value) {
    //     if(!str_contains($characterPool, $value)){
    //         echo "найден недопустимый символ";
    //         return null;// Если найден недопустимый символ, возвращаем null
    //     }
    // }

    // Удаляем исключенные символы из пула символов
   
    $characterPool = str_replace(str_split($exludedSymbols), "", $characterPool);
    // Проверяем, что после исключения символов пул не пуст
    if (strlen($characterPool) === 0) {
        return null; // Если все символы были исключены, возвращаем null
    }

    // Начинаем формировать пароль с обязательных символов
    $password = $requiredSymbols;
    // Заполняем оставшиеся символы случайными из пула
    while (strlen($password) < $length) {
        $randomIndex = rand(0, strlen($characterPool) - 1);
       $password = $password.$characterPool[$randomIndex];
    }

    // Перемешиваем пароль для большей случайности
    $password = str_shuffle($password);

    //проверяем нет ли заперщенных подстрок
    foreach ($excludedCombinations as $value) {
       if(stripos($password, $value)){
        return null;
       }
    }

    return $password;
}
