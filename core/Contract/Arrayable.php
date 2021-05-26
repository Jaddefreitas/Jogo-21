<?php

namespace Core\Contract;

/**
 * Um objeto que implemente essa interface possui uma representação válida em formato de array
 */
interface Arrayable
{
    /**
     * Retorna a representação do objeto em array
     * 
     * @return array
     */
    public function toArray(): array;
}