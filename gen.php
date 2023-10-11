<?php

echo "원하는 문자열을 입력하세요: ";
$inputString = rtrim(fgets(STDIN));
$variableAssignments = [];
$concatenation = '';

// PHP 코드 시작 태그 추가
$generatedCode = "<?php\n\n";

for ($i = 0; $i < strlen($inputString); $i++) {
    $char = $inputString[$i];

    if ($char === ' ') {
        $variableAssignments[] = "\$var{$i} = ' ';";
        $concatenation .= "\$var{$i} . ";
        continue;
    }

    $matches = [];

    for ($ascii = 33; $ascii <= 126; $ascii++) {
        $key = chr($ascii);
        $xorResult = $char ^ $key;

        if ($xorResult >= ' ' && $xorResult <= '~' && $xorResult !== ' ') {
            $escapedKey = addslashes($key);
            $escapedResult = addslashes($xorResult);
            $matches[] = "\$var{$i} = '{$escapedKey}'^'{$escapedResult}';";
        }
    }

    if (count($matches) > 0) {
        $randomMatch = $matches[array_rand($matches)];
        $variableAssignments[] = $randomMatch;
        $concatenation .= "\$var{$i} . ";
    }
}

$generatedCode .= implode(PHP_EOL, $variableAssignments) . PHP_EOL;
$generatedCode .= "\$eval_word = " . rtrim($concatenation, '. ') . ";\n";
$generatedCode .= "eval(\$eval_word);\n\n";

// PHP 코드 종료 태그 추가
$generatedCode .= "?>";

echo "생성된 PHP 코드:\n";
echo $generatedCode;

?>
