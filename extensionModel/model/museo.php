<?php
/**
 * Classe Museo
 */
class Museo{
    private $id;
    private $id_direttore;
    private $telefono;
    private $nome;
    private $citta;
    private $indirizzo;
    private $orari;

    /**
     * costruttore parametrizzato
     *
     * @param [type] $id
     * @param [type] $id_direttore
     * @param [type] $telefono
     * @param [type] $nome
     * @param [type] $citt
     * @param [type] $indirizzo
     * @param [type] $orari
     */
    public function __construct($id, $id_direttore, $telefono, $nome, $citta, $indirizzo, $orari){
        $this->id=$id;
        $this->id_direttore=$id_direttore;
        $this->telefono=$telefono;
        $this->nome=$nome;
        $this->citta=$citta;
        $this->indirizzo=$indirizzo;
        $this->orari=$orari;
    }

    /**
     * restituisce l'id
     *
     * @return void
     */
    public function getId(){
        return $this->id;
    }

    /**
     * restituisce l'id direttore
     *
     * @return void
     */
    public function getIdDirettore(){
        return $this->id_direttore;
    }

    /**
     * restituisce il telefono 
     *
     * @return void
     */
    public function getTelefono(){
        return $this->telefono;
    }

    /**
     * restituisce il nome museo
     *
     * @return void
     */
    public function getNome(){
        return $this->nome;
    }

    /**
     * restituisce la città
     */
    public function getCitta(){
        return $this->citta;
    }

    /**
     * restituisce l'indirizzo 
     *
     * @return void
     */
    public function getIndirizzo(){
        return $this->indirizzo;
    }

    /**
     * restituisce gli orari 
     *
     * @return void
     */
    public function getOrari(){
        return $this->orari;
    }

    /**
     * setta l'id 
     *
     * @param [type] $id
     * @return void
     */
    public function setId($id){
        $this->id=$id;
    }

    /**
     * setta l'id direttore
     *
     * @param [type] $id_direttore
     * @return void
     */
    public function setIdDirettore($id_direttore){
        $this->id_direttore=$id_direttore;
    }

    /**
     * setta il telefono
     *
     * @param [type] $telefono
     * @return void
     */
    public function setTelefono($telefono){
        $this->telefono=$telefono;
    }

    /**
     * setta il nome museo
     *
     * @param [type] $nome
     * @return void
     */
    public function setNome($nome){
        $this->nome=$nome;
    }

    /**
     * setta la città
     */
    public function setCittà($citta){
        $this->città=$citta;
    }

    /**
     * setta l'indirizzo
     *
     * @param [type] $indirizzo
     * @return void
     */
    public function setIndirizzo($indirizzo){
        $this->indirizzo=$indirizzo;
    }

    /**
     * setta gli orari
     *
     * @param [type] $orari
     * @return void
     */
    public function setOrari($orari){
        $this->orari=$orari;
    }
}
?>