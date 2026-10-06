<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Controller\MatrizController;
use InvalidArgumentException;

class MatrizControllerTest extends TestCase {

    private MatrizController $controller;

    protected function setUp(): void {
    
        $this->controller = new MatrizController();
    }

    #[Test]
    public function deveSomarDuasMatrizesComSucesso(): void {
    
        $a = [[1, 2], [3, 4]];
        $b = [[5, 6], [7, 8]];
        $esperado = [[6, 8], [10, 12]];

        $resultado = $this->controller->sum($a, $b);

        $this->assertEquals($esperado, $resultado);
    }

    #[Test]
    public function deveSubtrairDuasMatrizesComSucesso(): void {
    
        $a = [[5, 6], [7, 8]];
        $b = [[1, 2], [3, 4]];
        $esperado = [[4, 4], [4, 4]];

        $resultado = $this->controller->subtract($a, $b);

        $this->assertEquals($esperado, $resultado);
    }

    #[Test]
    public function deveMultiplicarDuasMatrizesComSucesso(): void {
    
        $a = [[1, 2], [3, 4]];
        $b = [[2, 0], [1, 2]];
        $esperado = [[4, 4], [10, 8]];

        $resultado = $this->controller->multiply($a, $b);

        $this->assertEquals($esperado, $resultado);
    }

    #[Test]
    public function deveCalcularMatrizTransposta(): void {
    
        $a = [[1, 2], [3, 4]];
        $esperado = [[1, 3], [2, 4]];

        $resultado = $this->controller->transpose($a);

        $this->assertEquals($esperado, $resultado);
    }

    #[Test]
    public function deveCalcularDeterminanteMatriz1x1(): void
    {
        $a = [[5]];
        
        $resultado = $this->controller->determinant($a);

        $this->assertEquals(5, $resultado);
    }

    #[Test]
    public function deveCalcularDeterminanteMatriz2x2(): void {
    
        $a = [[1, 2], [3, 4]]; 
        
        $resultado = $this->controller->determinant($a);

        $this->assertEquals(-2, $resultado);
    }

    #[Test]
    public function deveResolverSistemaLinearSPD(): void {
    
        // Sistema: 
        // 1x + 2y = 5
        // 3x + 4y = 11
        $a = [[1, 2], [3, 4]];
        $b = [[5], [11]];

        $resultado = $this->controller->solveSystem($a, $b);

        $this->assertEquals('Sistema Possível Determinado', $resultado['message']);
        $this->assertEqualsWithDelta(1.0, $resultado['result']['x1'], 0.0001);
        $this->assertEqualsWithDelta(2.0, $resultado['result']['x2'], 0.0001);
    }

    #[Test]
    public function deveIdentificarSistemaLinearSPI(): void {
    
        // Linhas proporcionais com resultados proporcionais
        $a = [[1, 2], [2, 4]];
        $b = [[3], [6]];

        $resultado = $this->controller->solveSystem($a, $b);

        $this->assertEquals('Sistema Possível Indeterminado', $resultado['message']);
        $this->assertNull($resultado['result']);
    }

    #[Test]
    public function deveIdentificarSistemaLinearSI(): void {
    
        // Linhas iguais com resultados diferentes
        $a = [[1, 2], [1, 2]];
        $b = [[3], [5]];

        $resultado = $this->controller->solveSystem($a, $b);

        $this->assertEquals('Sistema Impossível', $resultado['message']);
        $this->assertNull($resultado['result']);
    }

    #[Test]
    public function deveLancarExcecaoParaSomaComDimensoesIncompativeis(): void {
    
        $this->expectException(InvalidArgumentException::class);

        $a = [[1, 2]];
        $b = [[1, 2], [3, 4]];

        $this->controller->sum($a, $b);
    }

    #[Test]
    public function deveLancarExcecaoParaMultiplicacaoComDimensoesIncompativeis(): void {
    
        $this->expectException(InvalidArgumentException::class);

        $a = [[1, 2, 3]]; // 1x3
        $b = [[1, 2]];    // 1x2 (precisaria de 3 linhas)

        $this->controller->multiply($a, $b);
    }

    #[Test]
    public function deveLancarExcecaoParaDeterminanteEmMatrizNaoQuadrada(): void {
    
        $this->expectException(InvalidArgumentException::class);

        $a = [[1, 2, 3], [4, 5, 6]];

        $this->controller->determinant($a);
    }

    #[Test]
    public function deveLancarExcecaoParaDeterminanteMaiorQue2x2(): void {
    
        $this->expectException(InvalidArgumentException::class);

        $a = [
            [1, 2, 3],
            [4, 5, 6],
            [7, 8, 9]
        ];

        $this->controller->determinant($a);
    }
}

