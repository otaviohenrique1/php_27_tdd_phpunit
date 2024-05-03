<?php

namespace Alura\Leilao\Tests\Service;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Service\Avaliador;
use PHPUnit\Framework\TestCase;

class AvaliadorTest extends TestCase
{
  private $leiloeiro;

  protected function setUp(): void {
    $this->leiloeiro = new Avaliador();
  }

  /**
   * @dataProvider leilaoEmOrdemCrescente
   * @dataProvider leilaoEmOrdemDecrescente
   * @dataProvider leilaoEmOrdemAleatoria
   */
  public function testAvaliadorDeveEncontrarOMaiorValorDeLances(Leilao $leilao)
  {
    $this->leiloeiro->avalia($leilao);
    $maiorValor = $this->leiloeiro->getMaiorValor();
    self::assertEquals(2500, $maiorValor);
  }

  /**
   * @dataProvider leilaoEmOrdemCrescente
   * @dataProvider leilaoEmOrdemDecrescente
   * @dataProvider leilaoEmOrdemAleatoria
   */
  public function testAvaliadorDeveEncontrarOMenorValorDeLances(Leilao $leilao)
  {
    $this->leiloeiro->avalia($leilao);
    $menorValor = $this->leiloeiro->getMenorValor();
    self::assertEquals(1700, $menorValor);
  }

  /**
   * @dataProvider leilaoEmOrdemCrescente
   * @dataProvider leilaoEmOrdemDecrescente
   * @dataProvider leilaoEmOrdemAleatoria
   */
  public function testAvaliadorDeveBuscar3MaioresValores(Leilao $leilao)
  {
    $this->leiloeiro->avalia($leilao);
    $maiores = $this->leiloeiro->getMaioresLances();
    static::assertCount(3, $maiores);
    static::assertEquals(2500, $maiores[0]->getValor());
    static::assertEquals(2000, $maiores[1]->getValor());
    static::assertEquals(1700, $maiores[2]->getValor());
  }

  public static function leilaoEmOrdemCrescente()
  {
    $leilao = new Leilao('Fiat 147 0km');

    $maria = new Usuario('Maria');
    $joao = new Usuario('Joao');
    $ana = new Usuario('Ana');

    $leilao->recebeLance(new Lance($ana, 1700));
    $leilao->recebeLance(new Lance($joao, 2000));
    $leilao->recebeLance(new Lance($maria, 2500));

    return [[$leilao]];
  }

  /* ---------Dados--------- */
  public static function leilaoEmOrdemDecrescente()
  {
    $leilao = new Leilao('Fiat 147 0km');

    $maria = new Usuario('Maria');
    $joao = new Usuario('Joao');
    $ana = new Usuario('Ana');

    $leilao->recebeLance(new Lance($maria, 2500));
    $leilao->recebeLance(new Lance($joao, 2000));
    $leilao->recebeLance(new Lance($ana, 1700));

    return [[$leilao]];
  }

  public static function leilaoEmOrdemAleatoria()
  {
    $leilao = new Leilao('Fiat 147 0km');

    $maria = new Usuario('Maria');
    $joao = new Usuario('Joao');
    $ana = new Usuario('Ana');

    $leilao->recebeLance(new Lance($joao, 2000));
    $leilao->recebeLance(new Lance($maria, 2500));
    $leilao->recebeLance(new Lance($ana, 1700));

    return [[$leilao]];
  }

  public static function entregaLeiloes()
  {
    return [
      [self::leilaoEmOrdemCrescente()],
      [self::leilaoEmOrdemDecrescente()],
      [self::leilaoEmOrdemAleatoria()],
    ];
  }
}

/*
public static function setUpBeforeClass(): void - Método executado uma vez só, antes de todos os testes da classe
protected function setUp(): void - Método executado antes de cada teste da classe
protected function tearDown(): void - Método executado após cada teste da classe
public static function tearDownAfterClass(): void - Método executado uma vez só, após todos os testes da classe
*/
