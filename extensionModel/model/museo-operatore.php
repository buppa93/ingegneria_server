<?php
/**
 * Astrae le associazioni museo-operatore
 */
class MuseoOperatore{
    private $id_museo;
    private $id_operatore;

    /**
     * costruttore parametrizzato
     * @param int $id_museo
     * @param int $id_operatore
     * @return void
     */
    public function __construct($id_museo, $id_operatore){
        $this->id_museo=$id_museo;
        $this->id_operatore=$id_operatore;
    }

    /**
     * restituisce l'id del museo
     * @return int
     */
    public function getIdMuseo(){
        return $this->id_museo;
    }
    
    /**
     * restituisce l'id dell'operatore
     * @return int
     */
    public function getIdOperatore(){
        return $this->id_operatore;
    }

    /**
     * setta l'id del museo
     * @param int $id
     * @return void
     */
    public function setIdMuseo($id_museo){
        $this->id_museo=$id_museo;
    }

    /**
     * setta l'iddell'oggetto
     * @param int $id_reperto
     * @return void
     */
    public function setIdOperatore($id_operatore){
        $this->id_operatore=$id_operatore;
    }
}
?>