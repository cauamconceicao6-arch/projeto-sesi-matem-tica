# Projeto de Álgebra Linear & Testes Unitários em PHP

Aplicação web desenvolvida em PHP puro para operações de Álgebra Linear e resolução de sistemas lineares, com testes automatizados em PHPUnit. A suíte atual possui 13 testes e 17 asserções;.

# Instalação e execução

### Requisitos

- Git e Composer.
- PHP 8.3 ou superior, compatível com o PHPUnit 11 fixado no `composer.lock`.
- Extensões PHP necessárias ao PHPUnit.

```
# Instalar o projeto

```sh
git clone https://github.com/cauamconceicao6-arch/projeto-sesi-matem-tica.git
cd projeto-sesi-matem-tica
composer install
```

O comando instala também as dependências de desenvolvimento, incluindo o PHPUn

# Executar a aplicação

Na raiz do projeto, execute:

```sh
php -S localhost:8000 -t public
```

Abra [http://localhost:8000](http://localhost:8000) no navegador. 

As matrizes são informadas em JSON. Exemplo de matriz 2 × 2:

```json
[[1, 2], [3, 4]]
```

Para um sistema linear, informe os coeficientes em A e os termos independentes em B. Por exemplo, A = `[[1,2],[3,4]]` e B = `[[5],[11]]` representam x + 2y = 5 e 3x + 4y = 11, cuja solução é x = 1 e y = 2.

# Recursos e algoritmos implementados

1. **Soma de matrizes (A + B):** valida dimensões iguais e soma os elementos correspondentes.
2. **Subtração de matrizes (A − B):** valida dimensões iguais e subtrai os elementos correspondentes.
3. **Multiplicação de matrizes (A × B):** exige que o número de colunas de A seja igual ao número de linhas de B e calcula cada elemento por produto escalar.
4. **Matriz transposta:** troca os índices de linha e coluna.
5. **Determinante:** aceita matrizes quadradas 1 × 1 e 2 × 2. Para 1 × 1, retorna o único elemento; para 2 × 2, aplica ad − bc. Matrizes maiores são rejeitadas.
6. **Resolução de sistemas lineares 2 × 2:** utiliza a Regra de Cramer, calculando o determinante principal e os determinantes auxiliares. Retorna as classificações Sistema Possível Determinado (solução única), Sistema Possível Indeterminado (infinitas soluções) ou Sistema Impossível (sem solução).

A classificação dos sistemas utiliza os determinantes auxiliares quando o determinante principal é zero. A implementação atual não cobre corretamente todos os casos degenerados, como uma matriz de coeficientes inteiramente nula com termos independentes não nulos.

# Como rodar os testes

Após `composer install`, execute na raiz do projeto:

```sh
composer test
```

Para exibir os nomes dos testes:

```sh
php vendor/phpunit/phpunit/phpunit --colors=never --testdox
```

Para salvar a saída em arquivo:

```sh
php vendor/phpunit/phpunit/phpunit --colors=never --testdox > test.txt 2>&1
```

O arquivo `phpunit.xml` carrega `vendor/autoload.php`, procura os testes em `Test/` e define `Controller/` como fonte para a medição de cobertura.

A suíte verifica soma, subtração, multiplicação, transposição, determinantes 1 × 1 e 2 × 2, as três classificações de sistemas lineares e exceções para dimensões incompatíveis ou determinantes não suportados.


# Relatório técnico

#  Lógica dos algoritmos

As operações matriciais usam arrays e laços para percorrer os elementos. A multiplicação acumula os produtos entre linhas de A e colunas de B. Os determinantes são calculados diretamente; os sistemas 2 × 2 utilizam os determinantes da Regra de Cramer.

# Decisões do projeto

- **Controller centralizado:** `Controller/MatrizController.php` concentra os cálculos e o processamento das requisições. `handleRequest` seleciona a operação por condições `if/elseif`.
- **Tratamento de exceções:** os cálculos lançam `InvalidArgumentException` para dimensões incompatíveis ou matrizes não suportadas. O processamento das requisições captura erros e os disponibiliza para exibição.
- **Entrada da aplicação:** `public/index.php` carrega o autoload, processa os dados do formulário e inclui a view.
- **Formatação de saída:** `View/home.php` apresenta resultados matriciais em tabelas e as incógnitas dos sistemas em listas.

# Dificuldades encontradas e soluções

- **Entrada de matrizes:** campos de texto com JSON permitem informar dimensões diferentes sem criar um campo para cada elemento. Cada operação mantém suas restrições de dimensão.
- **Precisão numérica:** os testes de soluções com divisão usam `assertEqualsWithDelta` para considerar a tolerância de ponto flutuante.
- **Cobertura:** o relatório depende de uma extensão como Xdebug, além da instalação do PHPUnit.

# Declaração do uso de Inteligência Artificial

No desenvolvimento do projeto, ferramentas de IA foram utilizadas como assistência técnica nos seguintes pontos:

- Apoio à organização e revisão do código PHP na classe `MatrizController.php`.
- Apoio ao ajuste da interface para exibir matrizes e resultados no navegador.
- Orientação na estruturação das asserções e dos testes unitários em PHPUnit.
- Apoio à documentação de instalação.
