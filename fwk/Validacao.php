<?php

class Validacao
{
    public static function intervalo(array $dados, string $campo, string $gravidade, float $min, float $max)
    {

        $erros = array();
        foreach ($dados as $dado) {
            $erro = array();
            if ($dado[$campo] > $max) {

                $erro[$dado["id"]] = "Valor acima do intervalo";
                $erro["gravidade"] = $gravidade;
                array_push($erros, $erro);
            } elseif ($dado[$campo] < $min) {

                $erro[$dado["id"]] = "Valor abaixo do intervalo";
                $erro["gravidade"] = $gravidade;
                array_push($erros, $erro);
            }
        }

        return $erros;
    }

    public static function notNull(array $dados, string $campo, string $gravidade)
    {
        $erros = array();
        foreach ($dados as $dado) {
            $erro = array();
            if ($dado[$campo] == null) {
                $erro[$dado["id"]] = "Campo nulo";
                $erro["gravidade"] = $gravidade;

                array_push($erros, $erro);
            }
        }

        return $erros;
    }

    public static function foreignKey(array $tabelaAlvo, array $tabelaEstrang, string $campo, string $gravidade)
    {
        $erros = array();
        foreach ($tabelaAlvo as $alvo) {
            $erro = array();
            $chave = $alvo[$campo];
            $fkExiste = false;

            foreach ($tabelaEstrang as $estrang) {
                if ($estrang["id"] == $chave) {
                    $fkExiste = true;
                    break;
                }
            }

            if (!$fkExiste) {
                $erro[$alvo["id"]] = "Chave estrangeira referencia registro inexistente.";
                $erro["gravidade"] = $gravidade;

                array_push($erros, $erro);
            }
        }

        return $erros;
    }

    public static function normCase(array $dados, string $campo, string $tipoCase)
    {
        $dadosAlt = array();
        foreach ($dados as $dado) {
            if ($tipoCase == "upper") {
                //lógica do upper case
                $dado = strtoupper($dado[$campo]);
            } elseif ($tipoCase == "lower") {
                $dado = strtolower($dado[$campo]);
            } elseif ($tipoCase == "capital") {
                $dado = ucfirst(strtolower($dado[$campo]));
            } elseif ($tipoCase == "ucFirst") {
                //lógica do lcfirst
                $dado = ucFirst($dado[$campo]);
            } elseif ($tipoCase == "title") {
                $dado = ucwords($dado[$campo]);
            } elseif ($tipoCase == "lcfirst") {
                $dado = lcfirst($dado[$campo]);
            }


            array_push($dadosAlt, $dado);
        }
        return $dadosAlt;
    }

    public static function unique(array $dados, string $campo, string $gravidade)
    {
        $erros = array();
        $list = array();
        foreach ($dados as $dado) {
            if (array_key_exists(strtolower($dado[$campo]), $list)) {
                $erros[$dado["id"]] = [
                    "indice duplicado" => $list[$dado[$campo]],
                    "valor duplicado" => $dado[$campo],
                    "gravidade" => $gravidade
                ];
            } else {
                $list[strtolower($dado[$campo])] = $dado["id"];
            }
        }

        return $erros;
    }

    public static function minlen(array $dados, string $campo, string $gravidade, int $min)
    {
        $erros = array();
        foreach ($dados as $dado) {
            $alvo = $dado[$campo];
            if (strlen($alvo) < $min) {
                $erros[$dado["id"]] = [
                    "string" => $alvo,
                    "diferenca" => strlen($alvo) - $min,
                    "gravidade" => $gravidade
                ];
            }
        }

        return $erros;
    }

    public static function maxlen(array $dados, string $campo, string $gravidade, int $max)
    {
        $erros = array();
        foreach ($dados as $dado) {
            $alvo = $dado[$campo];
            if (strlen($alvo) > $max) {
                $erros[$dado["id"]] = [
                    "string" => $alvo,
                    "diferenca" => strlen($alvo) - $max,
                    "gravidade" => $gravidade
                ];
            }
        }

        return $erros;
    }

    public static function validType(array $dados, string $campo, string $tipo, string $gravidade)
    {
        $erros = array();
        foreach ($dados as $dado) {
            //get_debug_type retorna o tipo do dado inserido no parâmetro. Foi introduzida no PHP 8. Seu funcionamento é similar ao gettype, mas é melhor. Caso o tipo seja um objeto, ele retorna o nome da classe desse objeto.
            if (get_debug_type($dado[$campo]) != $tipo) {
                $erros[$dado["id"]] = [
                    "tipo dado" => get_debug_type($dado[$campo]),
                    "tipo esperado" => $tipo,
                    "gravidade" =>  $gravidade
                ];
            }
        }

        return $erros;
    }

    public static function trim(array $dados, string $campo)
    {
        $dadosAlt = array();
        foreach ($dados as $dado) {
            
            $dado = trim($dado[$campo]);

            array_push($dadosAlt, $dado);
        }
        return $dadosAlt;
    }
}
