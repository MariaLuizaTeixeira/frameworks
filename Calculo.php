<?php

//Classe que contempla os seguinte calculos : média, mediana, desvio-padrão, coeficiente de variação (cv), mínimo e máximo;
class Calculo
{

    public function calcMedia(array $value): int | float
    {
        $total = array_sum($value); //Soma todos os valores contido no array


        $count = count($value); //Conta os valores no array 

        return $total / $count;

        /*
            Exemplo array contas [1,2,3,4];
            $total = array_sum($contas) : 1+2+3+4;
            $count = count($contas) : 4;
            retorna a média 10/4 = 2.5;
        */
    }

    public function calcMediana(array $values): int | float
    {
        sort($values, SORT_NUMERIC); //Ordena os valores a partir de uma ordem numérica (1,2,3,...)
        $count = count($values); // Conta número de valores

        $middle = ($count-1) / 2; // identifica o meio do array a partir do número de total e o arrendonda para o valor inteiro mais próximo, considerando o menor valor;
        if ($middle % 2 != 0) 
            $middle -= 0.5;
            

        if ($count % 2 == 0) //Verifica se é divisível por 2; ou seja par ou ímpar
        {
            return (($values[$middle] + $values[$middle + 1]) / 2); //caso verdadeiro retorna a média dos dois valores centrais
        } else {
            return $values[$middle]; //caso falso retorna o meio
        }

        /*
            Exemplo caso ímpar : 
                array contas [4,2,3,1,5];
                sort($contas) : [1,2,3,4,5]
                $count = count($contas) : 5;
                $middle = 2; resultado da conta ((5-1)/2)
                retorna 3;
            
            Exemplo caso par :
                array contas [4,2,3,1];
                sort($contas) : [1,2,3,4]
                $count = count($contas) : 5;
                $middle = 1.5;
                ---condicional de paridade---
                $middle = 1;

                retorno considera os índices $values[1] e $values[2], portanto 2 e 3, e então tira sua média, ou seja 2.5;
        */
    }


    public function calcModa(array $values): array
    {
        $listaRepeticoes = [];// Inicializa o array lista;
        foreach ($values as $v) {
           $v = "$v";// Transforma o valor do array para string para permitir valores flutuantes(float)!!
           $listaRepeticoes[$v] +=1; //Cria o índice de lista a partir do valor do array inserido e adiciona 1; caso o índice ja exista será apenas adiciona mais um!!
        }


        $max = max($listaRepeticoes);//Verifica o índice com maior valor dentro de lista;
        $chaves = array_keys($listaRepeticoes);// Adquire as chaves de lista que corresponde aos valores do array inserido

        /*
            $moda é um array que é contruído a partir de array_filter que tem como parametro um array e uma função callback que irá molda-lo. 
        */
        $moda = array_filter($chaves, function ($v) use ($listaRepeticoes, $max) {
            return $listaRepeticoes[$v] == $max;
        });

        return $moda;

    }

    public function calcVariancia(array $values): int | float
    {
        $media = $this->calcMedia($values);// pega a média dos valores inserido;
        $soma = 0;//inicializa soma que servirá como o somatório do calculo

        foreach ($values as $v) {
            $soma += pow(($v - $media), 2);// adiciona a diferença do valor individual em relação a média;
        }

        return $soma / count($values); //retorna o resultado do somatório divido pelo número de valores

        /*
        Exemplo :
        array contas : [1,2,3,4];
        $media = 2.5;
        --inicializa $soma ---

        ---loop em contas ----
            0: $soma += 1.125
            1: $soma += 0.125
            2: $soma += 0.125
            4: $soma += 1.125

        retorna a $soma pela $media, ou seja 2.5/4 que resulta em 0.625
        */

        
    }

    public function calcDesvioPadrao(array $values): int | float
    {
        return sqrt($this->calcVariancia($values));// retorna a raiz da vâriancia

        /*
        exemplo qualquer : 
        variancia : 4;
        retorno : 2;

        exemplo caso contas : 
        variancia : 0.625;
        retorno : 0.79056941504
        */
    }


    public function calcCoeficienteDeVariacao(array $values): int | float
    {
        return ($this->calcDesvioPadrao($values) / $this->calcMedia($values)) * 100; //retorna um valor percentual de variação;
        /*
        exemplo array contas [1,2,3,4]
        desvio padrão : 0.79056941504
        media : 2.5

        esta função retorna o resultado do seguinte calculo  (0.79056941504/2.5) * 100 o que resulta em 31.6227766017, que caso arredonde este valor portesriomente possa resultar em 32
        */
    }
}


function calcModa(array $values)//: int | float | array
    {
        $listaRepeticoes = [];
        foreach ($values as $v) {
           $v = "$v";
           $listaRepeticoes[$v] +=1;
        }


        $max = max($listaRepeticoes);
        $chaves = array_keys($listaRepeticoes);


        $moda = array_filter($chaves, function ($v) use ($listaRepeticoes, $max) {
            return $listaRepeticoes[$v] == $max;
        });

        return $moda;

    }

    print_r(calcModa([1.5,2,1.5,6,2]));