<?php
namespace ViniCavilha\Tarefas\Math;

class Basic
{
    public function soma(int|float $numero, int|float $numero2)
    {
        return $numero + $numero2;
    }

    public function subtrai(int|float $numero, int|float $numero2)
    {
        return $numero + $numero2;
    }
    public function multiplicacao(int|float $numero, int|float $numero2)
    {
        return $numero * $numero2;
    }
    public function divisao(int|float $numero, int|float $divisor)
    {
        return $numero / $divisor;
    }
    public function elevado(int|float $numero, int|float $numero2)
    {
        return $numero ** $numero2;
    }
    public function raiz(int|float $numero, int|float $numero2)
    {
        return sqrt($numero);
    }
    }
    