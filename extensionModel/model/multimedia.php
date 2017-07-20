<?php
/**
 * Gestisce file multimediali
 */
class Multimedia{
    private $id;
    private $id_tipo;
    private $url;
    private $id_reperto;

    /**
     * costruttore parametrizzato
     *
     * @param [type] $id
     * @param [type] $id_tipo
     * @param [type] $url
     * @param [type] $id_reperto
     * @return void
     */
    public function __construct($id, $id_tipo, $url, $id_reperto){
        $this->id=$id;
        $this->id_tipo=$id_tipo;
        $this->url=$url;
        $this->id_reperto=$id_reperto;
    }

    /**
     * restituisce l' id del file multimediale
     *
     * @return void
     */
    public function getId(){
        return $this->id;
    }
    
    /**
     * restituisce l'id del tipo di file multimediale
     *
     * @return void
     */
    public function getIdTipo(){
        return $this->id_tipo;
    }

    /**
     * restituisce l'url del file multimediale 
     *
     * @return void
     */
    public function getUrl(){
        return $this->url;
    }

    /**
     * restituisce l'id del reperto
     *
     * @return void
     */
    public function getIdReperto(){
        return $this->id_reperto;
    }

    /**
     * setta l'id multimedia
     *
     * @param [type] $id
     * @return void
     */
    public function setId($id){
        $this->id=$id;
    }

    /**
     * setta l'id del reperto
     *
     * @param [type] $id_reperto
     * @return void
     */
    public function setIdReperto($id_reperto){
        $this->id_reperto=$id_reperto;
    }

    /**
     * setta l'id del tipo di file multimediale
     *
     * @param [type] $id_tipo
     * @return void
     */
    public function setIdTipo($id_tipo){
        $this->id_tipo=$id_tipo;
    }

    /**
     * setta l'url
     *
     * @param [type] $url
     * @return void
     */
    public function setUrl($url){
        $this->url=$url;
    }
}
?>