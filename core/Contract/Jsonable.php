<?php

namespace Core\Contract;

/**
 * Um objeto que implemente essa interface possui uma representação válida em formato de json
 */
interface Jsonable
{
    /**
     * Retorna a representação do objeto em json
     * 
     * @return object
     */
    public function toJson(): object;
}