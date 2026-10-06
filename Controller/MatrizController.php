<?php

namespace Controller;

use InvalidArgumentException;

class MatrizController {

 
    public function sum(array $a, array $b): array {
        $this->validateSameDimensions($a, $b);

        $resultado = [];
        foreach ($a as $i => $linha) {
            foreach ($linha as $j => $valor) {
                $resultado[$i][$j] = $valor + $b[$i][$j];
            }
        }
        return $resultado;
    }

   
    public function subtract(array $a, array $b): array {
        $this->validateSameDimensions($a, $b);

        $resultado = [];
        foreach ($a as $i => $linha) {
            foreach ($linha as $j => $valor) {
                $resultado[$i][$j] = $valor - $b[$i][$j];
            }
        }
        return $resultado;
    }

    public function multiply(array $a, array $b): array {
        if (count($a[0]) !== count($b)) {
            throw new InvalidArgumentException("Dimensões incompatíveis para multiplicação.");
        }

        $resultado = [];
        for ($i = 0; $i < count($a); $i++) {
            for ($j = 0; $j < count($b[0]); $j++) {
                $soma = 0;
                for ($k = 0; $k < count($b); $k++) {
                    $soma += $a[$i][$k] * $b[$k][$j];
                }
                $resultado[$i][$j] = $soma;
            }
        }
        return $resultado;
    }

    // 4. Matriz Transposta
    public function transpose(array $a): array {
        $resultado = [];
        foreach ($a as $i => $linha) {
            foreach ($linha as $j => $valor) {
                $resultado[$j][$i] = $valor;
            }
        }
        return $resultado;
    }

    public function determinant(array $a): float|int {
        $this->validateSquareMatrix($a);

        if (count($a) === 1) {
            return $a[0][0];
        }

        if (count($a) === 2) {
            return ($a[0][0] * $a[1][1]) - ($a[0][1] * $a[1][0]);
        }

        throw new InvalidArgumentException("Apenas matrizes 1x1 e 2x2 são suportadas.");
    }

    public function solveSystem(array $a, array $b): array {
        $detA = $this->determinant($a);

        $aX1 = [
            [$b[0][0], $a[0][1]],
            [$b[1][0], $a[1][1]]
        ];
        $detX1 = $this->determinant($aX1);

        $aX2 = [
            [$a[0][0], $b[0][0]],
            [$a[1][0], $b[1][0]]
        ];
        $detX2 = $this->determinant($aX2);

        if ($detA != 0) {
            return [
                'message' => 'Sistema Possível Determinado',
                'result' => [
                    'x1' => $detX1 / $detA,
                    'x2' => $detX2 / $detA
                ]
            ];
        }

        if ($detX1 == 0 && $detX2 == 0) {
            return [
                'message' => 'Sistema Possível Indeterminado',
                'result' => null
            ];
        }

        return [
            'message' => 'Sistema Impossível',
            'result' => null
        ];
    }

   
    public function handleRequest(array $postData): array {
        $response = ['result' => null, 'message' => null, 'error' => null];

        if (empty($postData['action'])) {
            return $response;
        }

        try {
            $action = $postData['action'];
            $matrixA = json_decode($postData['matrixA'] ?? '[]', true) ?? [];
            $matrixB = json_decode($postData['matrixB'] ?? '[]', true) ?? [];

            if ($action === 'sum') {
                $response['result'] = $this->sum($matrixA, $matrixB);
            } elseif ($action === 'subtract') {
                $response['result'] = $this->subtract($matrixA, $matrixB);
            } elseif ($action === 'multiply') {
                $response['result'] = $this->multiply($matrixA, $matrixB);
            } elseif ($action === 'transpose') {
                $response['result'] = $this->transpose($matrixA);
            } elseif ($action === 'determinant') {
                $response['result'] = $this->determinant($matrixA);
            } elseif ($action === 'solveSystem') {
                $sistema = $this->solveSystem($matrixA, $matrixB);
                $response['message'] = $sistema['message'];
                $response['result'] = $sistema['result'];
            }
        } catch (\Throwable $e) {
            $response['error'] = $e->getMessage();
        }

        return $response;
    }

    private function validateSameDimensions(array $a, array $b): void {
        if (count($a) !== count($b) || count($a[0]) !== count($b[0])) {
            throw new InvalidArgumentException("As matrizes devem ter as mesmas dimensões.");
        }
    }

    private function validateSquareMatrix(array $a): void {
        foreach ($a as $linha) {
            if (count($linha) !== count($a)) {
                throw new InvalidArgumentException("A matriz deve ser quadrada.");
            }
        }
    }
}