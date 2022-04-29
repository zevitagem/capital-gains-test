## Stack
- `PHP` ( Linguagem base )

## Configurar o terreno antes do projeto
Na raiz do projeto existe um arquivo `run.sh` que fará a subida do container contendo toda a aplicação:
```shell
./run.sh
```

Caso prefira, pode executar o comando diretamente:
```shell
docker compose up -d
docker exec -ti php sh /../../../tmp/run.sh
```

Verifique se o projeto foi configurado corretamente e se os seguintes arquivos existem:
```
.env (caso não exista, copie o .env.example e renomeie )
/vendor ( caso não exista, execute "composer install" )
```

## Arquivo de configuração
```PROFIT_LIMIT=20000``` 


## Como testar
A aplicação possui dois pontos de entrada, navegue até o diretório:
`src/app/public`

Verás que existirão dois arquivos:
`command_index.php` e `index.php`

Caso opte por executar via terminal, será necessário:
```
docker exec -it project-apps-php bash
cd public
php command_index.php
```

Caso opte por executar via REST, será necessário:
```
POST http://localhost:8080/app/public/index.php

{
	"data": [
	    {
			"operation": "buy",
			"unit-cost": 10.00,
			"quantity": 5
		},
		{
			"operation": "buy",
			"unit-cost": 20.00,
			"quantity": 5
		}
	]
}
```

## Explicações
Decisões técnicas e arquiteturais:
- Foi decidido seguir uma abordagem onde existe a separação das regras de domínio com as regras da aplicação. Cada tipo de operação possui sua vida independente, trabalhando intensamente com orientação à objetos.
- Foi optado por não usar `framework` devido a simplicidade do desafio, não foi visto necessidade de importar bibliotecas gigantes, sendo então substituido todo esse esforço por uma bela organização entre diretórios e responsabilidades.
- Instruções de como executar o projeto já foram mencionadas anteriormente.
- Não foram implementados testes unitários e automatizados, porém, deixo-os cientes de que trabalho com ambos diariamente.
- Avaliação extensa, nível médio e com particularidades interessantes para medir a linha de raciocínio do candidato. Deixo inclusive uma observação: segundo meu código, `O CENÁRIO 7` de vocês encontra-se incorreto e o `CENÁRIO 8` encontra-se incompleto.
- Observação: O CENÁRIO ( `CASE #1 + CASE #2` ) pedia para receber duas linhas para serem processadas, informo que esse ponto em específico não tratei na aplicação, sendo aceito então somente `UM JSON` por vez porém, o dado é sempre tratado isoladamente conforme solicitado.

## AVALIAÇÃO do cenário 7

```
{"operation":"buy","unitCost":10,"quantity":10000}
{"antes::total_acoes":0,"antes::total_capital":0,"antes::media_ponderada":0}
{"depois::total_acoes":10000,"depois::total_capital":0,"depois::media_ponderada":10}

{"operation":"sell","unitCost":2,"quantity":5000}
{"antes::total_acoes":10000,"antes::total_capital":0,"antes::media_ponderada":10}
{"depois::total_acoes":5000,"depois::total_capital":-40000,"depois::media_ponderada":10}

{"operation":"sell","unitCost":20,"quantity":2000}
{"antes::total_acoes":5000,"antes::total_capital":-40000,"antes::media_ponderada":10}
{"depois::total_acoes":3000,"depois::total_capital":-20000,"depois::media_ponderada":10}

{"operation":"sell","unitCost":20,"quantity":2000}
{"antes::total_acoes":3000,"antes::total_capital":-20000,"antes::media_ponderada":10}
{"depois::total_acoes":1000,"depois::total_capital":0,"depois::media_ponderada":10}

{"operation":"sell","unitCost":25,"quantity":1000}
{"antes::total_acoes":1000,"antes::total_capital":0,"antes::media_ponderada":10}
{"depois::total_acoes":0,"depois::total_capital":12000,"depois::media_ponderada":10}

{"operation":"buy","unitCost":20,"quantity":10000}
{"antes::total_acoes":0,"antes::total_capital":12000,"antes::media_ponderada":10}
{"depois::total_acoes":10000,"depois::total_capital":12000,"depois::media_ponderada":20}

{"operation":"sell","unitCost":15,"quantity":5000}
{"antes::total_acoes":10000,"antes::total_capital":12000,"antes::media_ponderada":20}
{"depois::total_acoes":5000,"depois::total_capital":-13000,"depois::media_ponderada":20}

{"operation":"sell","unitCost":30,"quantity":4350}
{"antes::total_acoes":5000,"antes::total_capital":-13000,"antes::media_ponderada":20}
{"depois::total_acoes":650,"depois::total_capital":24400,"depois::media_ponderada":20}

{"operation":"sell","unitCost":30,"quantity":650}
{"antes::total_acoes":650,"antes::total_capital":24400,"antes::media_ponderada":20}
{"depois::total_acoes":0,"depois::total_capital":30900,"depois::media_ponderada":20}

Segundo as análises, no quinto evento,  existe a seguinte explicação no PDF:
“Lucro de R$ 15000 e sem prejuízos: paga 20% de R$ 15000 em imposto (R$ 3000)”

Até ai, está tudo certo.
Se eu tive um lucro de 15.000, paguei 3.000 e não devo nada, então, ainda tenho 12.000 no capital/caixa, correto?
Okay

No sétimo evento, teve um prejuízo de 25.000, resultando em um valor negativo de -13.000.

O problema esta justamente na próxima operação, onde diz que será DEDUZIDO 25.000 do lucro de 43.500 ( ou seja, está deduzindo 2x o valor de 25.000 segundo o PDF ).

O correto seria: 
- ESTAVA NEGATIVO -13.000
- RECEBI 43.500
- FIQUEI COM 30.500 DE LUCRO
- PAGUEI 6.100 DE TAXA
- SOBROU 24.400 DE LUCRO
- E POR FIM, MAIS UM LUCRO DE 6.500

##TAXAS
[{"tax":"0.00"},{"tax":"0.00"},{"tax":"0.00"},{"tax":"0.00"},{"tax":"3000.00"},{"tax":"0.00"},{"tax":"0.00"},{"tax":"6100.00"},{"tax":"0.00"}]
```