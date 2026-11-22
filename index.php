<?php

require_once(__DIR__ . "/dao/DAO.php");
require_once(__DIR__ . "/fwk/ValiDADO.php");

$validado = new ValiDADO();

$exemplos = array();

$validado->definirRegras("trim", "media", true);
$exemplos[] = array("trim", '"  Ana Silva  "', "true ou definirRegras(..., true)", $validado->getRegras()->processarDado("  Ana Silva  "));

$validado->definirRegras("not null", "alta", array("Nao informado"), true);
$exemplos[] = array("not null", "null", '["Nao informado"], true', $validado->getRegras()->processarDado(null));

$validado->definirRegras("intervalo", "baixa", array("min" => 100, "max" => 500), 300);
$exemplos[] = array("intervalo", "900", '["min" => 100, "max" => 500], 300', $validado->getRegras()->processarDado(900));

$validado->definirRegras("intervalo", "baixa", array("min" => 100, "max" => 500), true);
$exemplos[] = array("intervalo com true", "900", '["min" => 100, "max" => 500], true', $validado->getRegras()->processarDado(900));

$validado->definirRegras("normCase", "media", array("title"), true);
$exemplos[] = array("normCase", "ana silva", '["title"], true', $validado->getRegras()->processarDado("ana silva"));

$validado->definirRegras("minlen", "baixa", array(8), true);
$exemplos[] = array("minlen", '"ABC"', "[8], true", $validado->getRegras()->processarDado("ABC"));

$validado->definirRegras("maxlen", "baixa", array(5), true);
$exemplos[] = array("maxlen", '"Executivo"', "[5], true", $validado->getRegras()->processarDado("Executivo"));

$validado->definirRegras("validType", "alta", array("int"), true);
$exemplos[] = array("validType", '"42"', '["int"], true', $validado->getRegras()->processarDado("42"));

$validado->definirRegras("unique", "alta", true);
$exemplos[] = array("unique", '"Brasil"', "true ou definirRegras(..., true)", $validado->getRegras()->processarDado("Brasil", array("usados" => array("brasil" => true))));

$validado->definirRegras("fk", "alta", array("poder_executivo"), true);
$exemplos[] = array("fk", "99", '["poder_executivo"], true', "null");

function valorTabela($valor)
{
    if ($valor === null) {
        return "null";
    }
    if (is_bool($valor)) {
        return $valor ? "true" : "false";
    }
    if (is_string($valor)) {
        return htmlspecialchars($valor, ENT_QUOTES, "UTF-8");
    }
    return (string) $valor;
}

?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Correcoes das regras - valiDADO</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 24px; }
        table { border-collapse: collapse; width: 100%; max-width: 900px; }
        th, td { border: 1px solid #bbb; padding: 8px; text-align: left; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h1>Correcoes aplicadas pelas regras</h1>
    <table>
        <thead>
            <tr>
                <th>Regra</th>
                <th>Dado original</th>
                <th>Quarto argumento</th>
                <th>Dado corrigido</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($exemplos as $exemplo): ?>
            <tr>
                <td><?= htmlspecialchars($exemplo[0]) ?></td>
                <td><?= valorTabela($exemplo[1]) ?></td>
                <td><?= valorTabela($exemplo[2]) ?></td>
                <td><?= valorTabela($exemplo[3]) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
