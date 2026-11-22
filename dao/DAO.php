<?php

require_once(__DIR__ . "/../util/Connection.php");
class DAO{
    public function getDados($tabelas = array(), $colunasPorTabela = array()){
        $conn = Connection::getConnection();

        if (is_string($tabelas)) {
            $tabelas = array($tabelas);
        }

        $dados = array();

        foreach ($tabelas as $tabela) {
            $this->validarIdentificador($tabela, "tabela");

            $colunas = array_key_exists($tabela, $colunasPorTabela)
                ? $colunasPorTabela[$tabela]
                : array();

            if (is_string($colunas)) {
                $colunas = array($colunas);
            }

            if (empty($colunas)) {
                $colunasSql = "*";
            } else {
                $colunasSql = array();
                foreach ($colunas as $coluna) {
                    $this->validarIdentificador($coluna, "coluna");
                    $colunasSql[] = "`" . $coluna . "`";
                }
                $colunasSql = array_values(array_unique($colunasSql));
                $colunasSql = implode(", ", $colunasSql);
            }

            $sql = "SELECT " . $colunasSql . " FROM `" . $tabela . "`";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $dados[$tabela] = $stmt->fetchAll();
        }

        return $dados;
    }

    public function atualizarDado(string $tabela, string $coluna, $id, $valor): bool
    {
        $this->validarIdentificador($tabela, "tabela");
        $this->validarIdentificador($coluna, "coluna");

        $conn = Connection::getConnection();
        $sql = "UPDATE `" . $tabela . "` SET `" . $coluna . "` = :valor WHERE `id` = :id";
        $stmt = $conn->prepare($sql);

        if ($valor === null) {
            $stmt->bindValue(":valor", null, PDO::PARAM_NULL);
        } elseif (is_bool($valor)) {
            $stmt->bindValue(":valor", $valor, PDO::PARAM_BOOL);
        } elseif (is_int($valor)) {
            $stmt->bindValue(":valor", $valor, PDO::PARAM_INT);
        } else {
            $stmt->bindValue(":valor", $valor);
        }

        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    private function validarIdentificador(string $identificador, string $tipo): void
    {
        if (!preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/', $identificador)) {
            throw new InvalidArgumentException("Nome de " . $tipo . " invalido.");
        }
    }
}
