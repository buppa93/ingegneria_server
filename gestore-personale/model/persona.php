<?php
/**
 * Classe Persona
 */
class Persona{
    private $numero_documento;
    private $id_ruolo;
    private $telefono;
    private $nome;
    private $cognome;
    private $id_museo;

    /**
     * costruttore
     */
    public function __construct(){}

    /**
     * costruttore parametrizzato
     */
    public function __construct($numero_documento, $id_ruolo, $telefono, $nome, $cognome,$id_museo){
        $this->numero_documento=$numero_documento;
        $this->id_ruolo=$id_ruolo;
        $this->telefono=$telefono;
        $this->nome=$nome;
        $this->cognome=$cognome;
        $this->id_museo=$id_museo;
    }

    /**
     * restituisce il numero documento
     *
     * @return void
     */
    public function getNumeroDocumento(){
        return $this->numero_documento;
    }

    /**
     * restituisce l'id ruolo 
     *
     * @return void
     */
    public function getIdRuolo(){
        return $this->id_ruolo;
    }

    /**
     * restituisce il numero telefono
     *
     * @return void
     */
    public function getTelefono(){
        return $this->telefono;
    }

    /**
     * restituisce il nome della persona
     *
     * @return void
     */
    public function getNome(){
        return $this->nome;
    }

    /**
     * restituisce il cognome della persona
     *
     * @return void
     */
    public function getCognome(){
        return $this->cognome;
    }

    /**
     * restituisce l' id del museo
     *
     * @return void
     */
    public function getIdMuseo(){
        return $this->id_museo;
    }

    /**
     * setta il numero documento
     *
     * @param [type] $numero_documento
     * @return void
     */
    public function setNumeroDocumento($numero_documento){
        $this->numero_documento=$numero_documento;
    }

    /**
     * setta l'id ruolo
     *
     * @param [type] $id_ruolo
     * @return void
     */
    public function setIdRuolo($id_ruolo){
        $this->id_ruolo=$id_ruolo;
    }

    /**
     * setta il numero telefono
     *
     * @param [type] $telefono
     * @return void
     */
    public function setTelefono($telefono){
        $this->telefono=$telefono;
    }

    /**
     * setta il nome della persona
     *
     * @param [type] $nome
     * @return void
     */
    public function setNome($nome){
        $this->nome=$nome;
    }

    /**
     * setta il cognome della persona
     *
     * @param [type] $cognome
     * @return void
     */
    public function setCognome($cognome){
        $this->cognome=$cognome;
    }

    /**
     * setta l'id del museo
     *
     * @param [type] $id_museo
     * @return void
     */
    public function setIdMuseo($id_museo){
        $this->id_museo=$id_museo;
    }
}
?>