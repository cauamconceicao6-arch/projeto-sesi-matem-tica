<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Calculadora de Álgebra Linear</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h2>Operações com Matrizes e Sistemas Lineares</h2>

    <?php if (!empty($data['error'])): ?>
        <p class="error"><strong>Erro:</strong> <?= htmlspecialchars($data['error']) ?></p>
    <?php endif; ?>

    <form method="POST">
        <p>
            <label>Matriz A / Coeficientes (JSON):</label><br>
            <textarea name="matrixA"><?= htmlspecialchars($_POST['matrixA'] ?? '[[1, 2], [3, 4]]') ?></textarea>
        </p>
        <p>
            <label>Matriz B / Termos Independentes (JSON):</label><br>
            <textarea name="matrixB"><?= htmlspecialchars($_POST['matrixB'] ?? '[[5, 6], [7, 8]]') ?></textarea>
        </p>
        
        <div class="buttons">
            <button type="submit" name="action" value="sum">Somar</button>
            <button type="submit" name="action" value="subtract">Subtrair</button>
            <button type="submit" name="action" value="multiply">Multiplicar</button>
            <button type="submit" name="action" value="transpose">Transposta (A)</button>
            <button type="submit" name="action" value="determinant">Determinante (A)</button>
            <button type="submit" name="action" value="solveSystem">Resolver Sistema Linear</button>
        </div>
    </form>

    <?php if ($data['message'] !== null): ?>
        <div class="info">
            <strong>Classificação:</strong> <?= htmlspecialchars($data['message']) ?>
        </div>
    <?php endif; ?>

    <?php if ($data['result'] !== null): ?>
        <div class="result">
            <h3>Resultado:</h3>

            <?php if (is_array($data['result'])): ?>
                <?php 
                    $firstElement = reset($data['result']);
                    $isMatrix = is_array($firstElement);
                ?>

                <?php if ($isMatrix): ?>
                    <!-- Formatação visual para Matrizes em formato de tabela -->
                    <div class="matrix-container">
                        <table class="matrix-table">
                            <?php foreach ($data['result'] as $row): ?>
                                <tr>
                                    <?php foreach ($row as $val): ?>
                                        <td><?= is_float($val) ? number_format($val, 2) : $val ?></td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                <?php else: ?>
                    <!-- Formatação para Solução de Sistema Linear (incógnitas x1, x2) -->
                    <ul class="system-solution">
                        <?php foreach ($data['result'] as $var => $val): ?>
                            <li><strong><?= htmlspecialchars($var) ?>:</strong> <?= is_float($val) ? number_format($val, 2) : $val ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

            <?php else: ?>
                <!-- Formatação para valor único (Determinante) -->
                <p class="single-value"><?= is_float($data['result']) ? number_format($data['result'], 2) : $data['result'] ?></p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
</body>
</html>