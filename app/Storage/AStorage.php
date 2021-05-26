<?php

namespace App\Storage;

/**
 * Storage abstrato, que implementa boa parte dos comandos básicos de todo storage
 */
abstract class AStorage
{
    /**
     * @var array Todos os dados guardados
     */
    public static array $data = [];

    final private function __construct()
    {
        // não faz nada
    }

    /**
     * Retorna um índice a partir do objeto passado
     * 
     * @param  mixed $object
     * @return string
     */
    abstract public static function indexPorObjeto($object);

    /**
     * Retorna todos os dados existentes
     * 
     * @return array
     */
    public static function get(): array
    {
        return self::$data;
    }

    /**
     * Adiciona um novo dado. Faz uso de um índice pré-estabelecido
     * 
     * @param  mixed $object
     * @return void
     */
    public static function add($object): void
    {
        self::$data[static::indexPorObjeto($object)] = $object;
    }

    /**
     * Remove um dado a partir de seu índice
     * 
     * @param  mixed $index
     * @return void
     */
    public static function remove($index): void
    {
        if (array_key_exists($index, self::$data)) {
            unset(self::$data[$index]);
        }
    }

    /**
     * Procura um dado pelo seu índice. Caso não seja encontrado, retorna nulo
     * 
     * @param  mixed $index 
     * @return mixed|null
     */
    public static function find($index)
    {
        return array_key_exists($index, self::$data) ? self::$data[$index] : null;
    }
}