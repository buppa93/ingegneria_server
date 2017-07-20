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
     * @param [type] $id
     * @param [type] $nome
     */
    public function __construct($id, $nome){
        $this->id=$id;
        $this->nome=$nome;
    }

    /**
     * restituisce l'id del tipo di file multimediale
     *
     * @return void
     */
    public function getId(){
        return $this->id;
    }

    /**
     * restituisce il nome del tipo di file multimediale
     *
     * @return void
     */
    public function getNome(){
        return $this->nome;
    }

    /**
     * setta l'id del tipo di file multimediale
     *
     * @param [type] $id
     * @return void
     */
    public function setId($id){
        $this->id=$id;
    }

    /**
     * restituisce il nome del tipo di file multimediale
     *
     * @param [type] $nome
     * @return void
     */
    public function setNome($nome){
        $this->nome=$nome;
    }
}

?>