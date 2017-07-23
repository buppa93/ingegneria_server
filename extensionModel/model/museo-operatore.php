<?php
/**
 * Gestisce file multimediali
 */
class MuseoOperatore{
    private $id_museo;
    private $id_operatore;

    /**
     * costruttore parametrizzato
     *
     * @param [type] $id
     * @param [type] $id_tipo
     * @return void
     */
    public function __construct($id_museo, $id_operatore){
        $this->id_museo=$id_museo;
        $this->id_operatore=$id_operatore;
    }

    /**
     * restituisce l' id del file multimediale
     *
     * @return void
     */
    public function getIdMuseo(){
        return $this->id_museo;
    }
    
    /**
     * restituisce l'id del tipo di file multimediale
     *
     * @return void
     */
    public function getIdOperatore(){
        return $this->id_operatore;
    }

    /**
     * setta l'id multimedia
     *
     * @param [type] $id
     * @return void
     */
    public function setIdMuseo($id_museo){
        $this->id_museo=$id_museo;
    }

    /**
     * setta l'id del reperto
     *
     * @param [type] $id_reperto
     * @return void
     */
    public function setIdOperatore($id_operatore){
        $this->id_operatore=$id_operatore;
    }
}
?>