<?php

echo "input code: ";
$inputString = rtrim(fgets(STDIN));
$variableAssignments = [];
$concatenation = '';

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

$generatedCode .= "?>";

echo "result :\n";
echo $generatedCode;

?>
