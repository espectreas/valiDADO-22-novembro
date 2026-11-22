<?php

class Regras{
    private string $tipo = "";
    private string $gravidade = "";
    private array $condicao = array();
    private $correcao = false;

    public function getTipo(): string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getGravidade(): string
    {
        return $this->gravidade;
    }

    public function setGravidade(string $gravidade): self
    {
        $this->gravidade = $gravidade;

        return $this;
    }

    public function getCondicao(): array
    {
        return $this->condicao;
    }

    public function setCondicao(array $condicao): self
    {
        $this->condicao = $condicao;

        return $this;
    }

    public function getCorrecao()
    {
        return $this->correcao;
    }

    public function setCorrecao($correcao): self
    {
        if (!is_bool($correcao) && !is_int($correcao) && !is_float($correcao)) {
            throw new InvalidArgumentException("Correcao deve ser bool ou numero.");
        }

        $this->correcao = $correcao;

        return $this;
    }

    public function processarDado($dado, array $contexto = array())
    {
        if ($this->correcao === false) {
            return $dado;
        }

        switch ($this->tipo) {
            case "trim":
                return is_string($dado) ? trim($dado) : $dado;

            case "normCase":
                if (!is_string($dado)) {
                    return $dado;
                }

                $tipoCase = $this->condicao[0] ?? "";
                if ($tipoCase == "upper") return strtoupper($dado);
                if ($tipoCase == "lower") return strtolower($dado);
                if ($tipoCase == "capital") return ucfirst(strtolower($dado));
                if ($tipoCase == "ucFirst") return ucFirst($dado);
                if ($tipoCase == "title") return ucwords($dado);
                if ($tipoCase == "lcfirst") return lcfirst($dado);
                return $dado;

            case "intervalo":
                $min = $this->condicao["min"] ?? ($this->condicao[0] ?? null);
                $max = $this->condicao["max"] ?? ($this->condicao[1] ?? null);

                if (!is_numeric($dado) || $min === null || $max === null) {
                    return $dado;
                }

                $valor = (float) $dado;
                if (is_numeric($this->correcao)) {
                    if ($valor < (float) $min || $valor > (float) $max) {
                        return (float) $this->correcao;
                    }
                    return $dado;
                }

                if ($valor < (float) $min) return (float) $min;
                if ($valor > (float) $max) return (float) $max;
                return $dado;

            case "not null":
                if ($dado === null || $dado === "") {
                    return $this->condicao[0] ?? "";
                }
                return $dado;

            case "minlen":
                $min = (int) ($this->condicao[0] ?? 0);
                return is_string($dado) ? str_pad($dado, $min, " ", STR_PAD_RIGHT) : $dado;

            case "maxlen":
                $max = (int) ($this->condicao[0] ?? 0);
                return is_string($dado) ? substr($dado, 0, $max) : $dado;

            case "unique":
                $valor = is_string($dado) ? $dado : (string) $dado;
                $usados = $contexto["usados"] ?? array();
                $corrigido = $valor;
                $indice = 1;

                while (array_key_exists(strtolower($corrigido), $usados)) {
                    $corrigido = $valor . "_" . $indice++;
                }

                return $corrigido;

            case "validType":
                $tipoEsperado = $this->condicao[0] ?? "";
                if ($tipoEsperado == "int" || $tipoEsperado == "integer") return (int) $dado;
                if ($tipoEsperado == "float" || $tipoEsperado == "double") return (float) $dado;
                if ($tipoEsperado == "bool" || $tipoEsperado == "boolean") return (bool) $dado;
                if ($tipoEsperado == "string") return (string) $dado;
                return $dado;

            case "fk":
                $idsValidos = $contexto["ids_validos"] ?? array();
                if (array_key_exists((string) $dado, $idsValidos)) {
                    return $dado;
                }
                return null;
        }

        return $dado;
    }
}