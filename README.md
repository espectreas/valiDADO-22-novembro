# valiDADO

## Definicao de regras e correcoes
(README.md parcial)

Use `definirRegras()` para configurar o tipo, a gravidade e, quando necessario,
as condicoes da validacao:

```php
$validado->definirRegras(
    "intervalo",
    "baixa",
    ["min" => 100, "max" => 500],
    300
);
```

O quarto argumento controla a correcao:

- `false`: nao corrige os dados. Valor padrao.
- `true`: ativa a correcao automatica da regra.
- Numero: substitui um dado fora de um intervalo pelo valor informado.

O terceiro argumento continua sendo um array nas regras que precisam de
condicoes:

```php
$validado->definirRegras("not null", "alta", ["Nao informado"], true);
$validado->definirRegras("normCase", "media", ["title"], true);
$validado->definirRegras("minlen", "baixa", [8], true);
$validado->definirRegras("maxlen", "baixa", [5], true);
$validado->definirRegras("validType", "alta", ["int"], true);
$validado->definirRegras("fk", "alta", ["poder_executivo"], true);
$validado->definirRegras(
    "intervalo",
    "baixa",
    ["min" => 100, "max" => 500],
    true
);
```

Quando uma regra nao possui condicoes, o valor `true` ou `false` pode ser
passado diretamente no terceiro argumento:

```php
$validado->definirRegras("trim", "media", true);
$validado->definirRegras("unique", "alta", true);
```

Para desativar a correcao de uma regra que nao possui condicoes:

```php
$validado->definirRegras("trim", "media", false);
```

Exemplo de intervalo aberto: `true` limita o valor ao limite mais proximo,
enquanto um numero substitui qualquer valor fora do intervalo:

```php
$validado->definirRegras(
    "intervalo",
    "baixa",
    ["min" => 100, "max" => 500],
    true
);

// 900 sera corrigido para 500.

$validado->definirRegras(
    "intervalo",
    "baixa",
    ["min" => 100, "max" => 500],
    300
);

// 900 sera corrigido para 300.
```
