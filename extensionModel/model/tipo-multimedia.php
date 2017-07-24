<?php

/**
 * gestisce il tipo di file multimediale
 */
class TipoMultimedia{
    private $id;
    private $nome;

    /**
     * costruttore parametrizzato
     *
     * @param int $id
     * @param string $nome
     */
    public function __construct($id, $nome){
        $this->id=$id;
        $this->nome=$nome;
    }

    /**
     * restituisce l'id del tipo di file multimediale
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * restituisce il nome del tipo di file multimediale
     * @return string
     */
    public function getNome(){
        return $this->nome;
    }

    /**
     * setta l'id del tipo di file multimediale
     * @param int $id
     * @return void
     */
    public function setId($id){
        $this->id=$id;
    }

    /**
     * restituisce il nome del tipo di file multimediale
     * @param string $nome
     * @return void
     */
    public function setNome($nome){
        $this->nome=$nome;
    }
}

?>