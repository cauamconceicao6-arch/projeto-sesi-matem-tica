# Projeto de Álgebra Linear & Testes Unitários em PHP

Aplicação web desenvolvida em PHP puro para execução de operações matemáticas de Álgebra Linear e resolução de Sistemas Lineares validada integralmente por testes unitários automatizados com PHPUnit.


# Recursos e Algoritmos

A aplicação suporta as seguintes operações matriciais e de sistemas lineares:

1. **Soma de Matrizes ($A + B$):** Valida dimensões idênticas e realiza a adição elemento a elemento.
2. **Subtração de Matrizes ($A - B$):** Valida dimensões idênticas e realiza a subtração elemento a elemento.
3. **Multiplicação de Matrizes ($A \times B$):** Valida a compatibilidade de dimensões ($colunas_A = linhas_B$) e executa a multiplicação por produto escalar.
4. **Matriz Transposta ($A^T$):** Inverte as linhas e colunas da matriz fornecida.
5. **Determinante ($\det(A)$):** Cálculo para matrizes $1 \times 1$ e $2 \times 2$.
6. **Resolução de Sistemas Lineares ($2 \times 2$):** Resolução baseada na Regra de Cramer com classificação automática do sistema:
   

 Relatório Técnico

 1. Lógica dos Algoritmos Implementados
- **Operações Matriciais :* A soma, subtração, multiplicação e transposição utilizam funções nativas de manipulação de arrays e laços iterativos para percorrer os elementos das matrizes e aplicar as respetivas regras de álgebra linear.
- **Determinante:* Calculado de forma direta para matrizes $1 \times 1$ e pela fórmula clássica do produto diagonal $(a \cdot d - b \cdot c)$ para matrizes $2 \times 2$.
- **Sistemas Lineares ($2 \times 2$):** Implementado através da Regra de Cramer, calculando o determinante principal ($\det A$) e os determinantes auxiliares ($\det X_1$, $\det X_2$). O algoritmo classifica automaticamente o sistema 

 2. Decisões do projeto 
- **Estrutura do Controller:* O `MatrixController.php` atua de forma centralizada, aplicando funções nativas de manipulação de arrays e expressões `match` para um direcionamento rápido e limpo das requisições HTTP.
- **Tratamento de Exceções:* Lançamento de `InvalidArgumentException` para entradas com dimensões incompatíveis ou matrizes não quadradas, assegurando que erros de cálculo sejam capturados e exibidos amigavelmente ao utilizador sem quebrar o servidor.
- **Formatação de Saída:* O resultado retornado pelo Controller é convertido dinamicamente na View em tabelas HTML com delimitadores laterais (estilo matriz matemática) ou em listas explicativas de incógnitas.

 3. Dificuldades Encontradas e Soluções
- **Flexibilidade no Envio de Matrizes:* Para evitar formulários HTML engessados com número fixo de campos, utilizou-se a entrada de dados em formato JSON dentro de `<textarea>`. Isso permitiu enviar matrizes de qualquer dimensão ($1 \times 1$, $2 \times 2$, etc.) de forma simples e direta.
- **Precisão Numérica nos Testes:* Em operações de divisão na Regra de Cramer que geram dízimas ou valores decimais, foram utilizadas asserções do PHPUnit com margem de tolerância (`assertEqualsWithDelta`), garantindo a validação correta dos cálculos de ponto flutuante.

# Declaração do Uso de Inteligência Artificial

No âmbito do desenvolvimento do projeto, ferramentas de IA foram utilizadas como assistente técnico nos seguintes pontos:

Refatoração do Código PHP: Auxílio na classe `MatrixController.php`, aplicando recursos do PHP  (como a expressão `match`) 
Desenvolvimento da Interface: Apoio no ajuste da estilização gráfica para formatar e alinhar a exibição visual das matrizes e dos resultados no navegador.
Estratégia de Testes Unitários: Orientação na estruturação das asserções do PHPUnit 
