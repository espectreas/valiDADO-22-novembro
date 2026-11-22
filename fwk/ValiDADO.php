<?php

require_once(__DIR__ . "/Regras.php");
require_once(__DIR__ . "/../dao/DAO.php");
require_once(__DIR__ . "/Validacao.php");
class ValiDADO
{
    private Regras $regras;
    private DAO $dao;

    //Métodos

    public function __construct()
    {
        $this->regras = new Regras();
        $this->dao = new DAO();
    }

    public function definirRegras(string $tipo, string $gravidade, $condicao = array(), $correcao = false)
    {
        if (is_bool($condicao) || is_int($condicao) || is_float($condicao)) {
            if ($correcao !== false) {
                throw new InvalidArgumentException("Informe a correcao uma unica vez.");
            }
            $correcao = $condicao;
            $condicao = array();
        } elseif (!is_array($condicao)) {
            throw new InvalidArgumentException("Condicao deve ser um array.");
        }

        $this->regras
            ->setTipo($tipo)
            ->setGravidade($gravidade)
            ->setCondicao($condicao)
            ->setCorrecao($correcao);
    }

    public function notNUll() {}
    public function intervalo() {}

    public function validar(string $tabela, string $atributo)
    {
        $tipo = $this->regras->getTipo();
        $gravidade = $this->regras->getGravidade();
        $condicao = $this->regras->getCondicao();
        $tabelas = array($tabela => array("id", $atributo));

        if ($tipo == "fk") {
            $chaveFk = $condicao[0];
            if ($chaveFk == $tabela) {
                $tabelas[$tabela] = array_values(array_unique(array("id", $atributo)));
            } else {
                $tabelas[$chaveFk] = array("id");
            }
        }

        $dadosCarregados = $this->dao->getDados(array_keys($tabelas), $tabelas);
        $dados = $dadosCarregados[$tabela];

        if ($this->regras->getCorrecao() !== false) {
            $dadosCorrigidos = array();
            $usados = array();
            $idsValidos = array();

            if ($tipo == "fk") {
                $chaveFk = $condicao[0];
                foreach ($dadosCarregados[$chaveFk] as $referenciado) {
                    $idsValidos[(string) $referenciado["id"]] = true;
                }
            }

            $conn = \Connection::getConnection();
            if ($conn === null) {
                throw new RuntimeException("Nao foi possivel estabelecer conexao com o banco de dados.");
            }
            $conn->beginTransaction();

            try {
                foreach ($dados as $dado) {
                    $contexto = array(
                        "usados" => $usados,
                        "ids_validos" => $idsValidos
                    );
                    $valorCorrigido = $this->regras->processarDado($dado[$atributo], $contexto);
                    $dadosCorrigidos[] = array(
                        "id" => $dado["id"],
                        $atributo => $valorCorrigido
                    );
                    $usados[strtolower((string) $valorCorrigido)] = true;
                    if ((string) $dado[$atributo] !== (string) $valorCorrigido) {
                        $this->dao->atualizarDado($tabela, $atributo, $dado["id"], $valorCorrigido);
                    }
                }

                $conn->commit();
            } catch (Throwable $erro) {
                $conn->rollBack();
                throw $erro;
            }

            return $dadosCorrigidos;
        }

        if ($tipo == "not null") {
            return Validacao::notNull($dados, $atributo, $gravidade);
        } elseif ($tipo == "intervalo") {
            //executar validacao de intervalo
            $min = array_key_exists("min", $condicao) ? $condicao["min"] : $condicao[0];
            $max = array_key_exists("max", $condicao) ? $condicao["max"] : $condicao[1];

            return Validacao::intervalo($dados, $atributo, $gravidade, $min, $max);
        } elseif ($tipo == "fk") {
            $chaveFk = $condicao[0];
            $tabelaFk = $dadosCarregados[$chaveFk];
            return Validacao::foreignKey($dados, $tabelaFk, $atributo, $gravidade);
        } elseif ($tipo == "normCase") {
            $tipoCase = $condicao[0];

            return Validacao::normCase($dados, $atributo, $tipoCase);
        } elseif ($tipo == "unique") {

            return Validacao::unique($dados, $atributo, $gravidade);
        } elseif ($tipo == "minlen") {
            $min = $condicao[0];

            return Validacao::minlen($dados, $atributo, $gravidade, $min);
        } elseif ($tipo == "maxlen") {
            $max = $condicao[0];

            return Validacao::maxlen($dados, $atributo, $gravidade, $max);
        } elseif ($tipo == "validType") {
            $tipo = $condicao[0];

            return Validacao::validType($dados, $atributo, $tipo, $gravidade);
        } elseif($tipo == "trim"){
            return Validacao::trim($dados, $atributo);
        }
    }


    //Getters e Setters
    public function getRegras(): Regras
    {
        return $this->regras;
    }

    public function setRegras(Regras $regras): self
    {
        $this->regras = $regras;

        return $this;
    }
}
