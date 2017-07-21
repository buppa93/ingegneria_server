<?php 
    /**
     * Classe Reperto
     */
    class Reperto {
        private $id;
        private $data_acquisizione;
        private $dimensioni;
        private $valore;
        private $titolo;
        private $tipo;
        private $nome_autore;
        private $peso;
        private $luogo_scoperta;
        private $data_scoperta;
        private $bibliografia;
        private $descrizione;
        private $pubblicato;
        private $id_proprietario;
        private $id_museo;

        /**
         * costruttore parametrizzato
         *
         * @param [type] $id
         * @param [type] $data_acquisizione
         * @param [type] $dimensioni
         * @param [type] $valore
         * @param [type] $titolo
         * @param [type] $tipo
         * @param [type] $nome_autore
         * @param [type] $peso
         * @param [type] $luogo_scoperta
         * @param [type] $data_scoperta
         * @param [type] $bibliografia
         * @param [type] $descrizione
         * @param [type] $pubblicato
         * @param [type] $id_proprietario
         * @param [type] $id_museo
         */
        public function __construct($id, $id_museo, $id_proprietario, $data_acquisizione, 
                    $dimensioni, $valore, $titolo, $tipo, $nome_autore, $peso, $luogo_scoperta, 
                    $data_scoperta, $bibliografia, $descrizione, $pubblicato)
        {  
            $this->id = $id;
            $this->data_acquisizione= $data_acquisizione;
            $this->dimensioni = $dimensioni;
            $this->valore = $valore;
            $this->titolo = $titolo;
            $this->tipo = $tipo;
            $this->nome_autore = $nome_autore;
            $this->peso = $peso;
            $this->luogo_scoperta = $luogo_scoperta;
            $this->data_scoperta = $data_scoperta;
            $this->bibliografia = $bibliografia;
            $this->descrizione = $descrizione;
            $this->pubblicato = $pubblicato;
            $this->id_proprietario = $id_proprietario;
            $this->id_museo = $id_museo;


        }   
             
        /**
         * restituisce l'id del reperto
         *
         * @return void
         */
        public function getId() {
            //$this rappresenta l'oggetto che sarà costruito a runtime
            return $this->id;
        }       

        /**
         * restituisce la data acquisizione reperto
         *
         * @return void
         */
        public function getDataAcquisizione(){
            return $this->data_acquisizione;
        }

        /**
         * restituisce le dimensioni del reperto
         *
         * @return void
         */
        public function getDimensioni(){
            return $this->dimensioni;
        }

        /**
         * restituisce il valore reperto
         *
         * @return void
         */
        public function getValore(){
            return $this->valore;
        }
        
        /**
         * restituisce il nome del reperto 
         *
         * @return void
         */
        public function getTitolo(){
            return $this->titolo;
        }

        /**
         * restituisce il tipo del reperto
         *
         * @return void
         */
        public function getTipo(){
            return $this->tipo;
        }
        
        /**
         * restituisce l' id dell'autore del reperto
         *
         * @return void
         */
        public function getNomeAutore(){
            return $this->nome_autore;
        }

        /**
         * restituisce il peso del reperto
         *
         * @return void
         */
        public function getPeso(){
            return $this->peso;
        }

        /**
         * restituisce il luogo della scoperta del reperto
         *
         * @return void
         */
        public function getLuogoScoperta(){
            return $this->luogo_scoperta;
        }

        /**
         * restituisce la data della scoperta del reperto
         *
         * @return void
         */
        public function getDataScoperta(){
            return $this->data_scoperta;
        }

        /**
         * restituisce la bibliografia del reperto
         *
         * @return void
         */
        public function getBibliografia(){
            return $this->bibliografia;
        }

        /**
         * restituisce la descrizione del reperto
         *
         * @return void
         */
        public function getDescrizione(){
            return $this->descrizione;
        }

        /**
         * controlla se il reperto è stato pubblicato o meno
         *
         * @return void
         */
        public function getPubblicato(){
            return $this->pubblicato;
        }

        /**
         * restituisce l'id del proprietario del reperto
         *
         * @return void
         */
        public function getIdProprietario(){
            return $this->id_proprietario;
        }

        /**
         * restituisce l'id del museo in cui si trova il reperto
         *
         * @return void
         */
        public function getIdMuseo(){
            return $this->id_museo;
        }

        /**
         * setta l'id reperto
         *
         * @param [type] $id
         * @return void
         */
        public function setID($id){
            $this->id = $id;
        }

        /**
         * setta la data acquisizione reperto
         *
         * @param [type] $data_acquisizione
         * @return void
         */
        public function setDataAcquisizione($data_acquisizione){
            $this->data_acquisizione=$data_acquisizione;
        }

        /**
         * setta le dimensioni reperto
         *
         * @param [type] $dimensioni
         * @return void
         */
        public function setDimensioni($dimensioni){
            $this->dimensioni=$dimensioni;
        }

        /**
         * setta il valore del reperto
         *
         * @param [type] $valore
         * @return void
         */
        public function setValore($valore){
            $this->valore=$valore; 
        }

        /**
         * setta il nome del reperto
         *
         * @param [type] $titolo
         * @return void
         */
        public function setTitolo($titolo){
            $this->titolo=$titolo;
        }

        /**
         * setta il tipo del reperto
         *
         * @param [type] $tipo
         * @return void
         */
        public function setTipo($tipo){
            $this->tipo=$tipo;
        }

        /**
         * setta l'id autore del reperto
         *
         * @param [type] $id_autore
         * @return void
         */
        public function setNomeAutore($nome_autore){
            $this->nome_autore=$nome_autore;
        }

        /**
         * setta il peso del reperto
         *
         * @param [type] $peso
         * @return void
         */
        public function setPeso($peso){
            $this->peso= $peso;
        }   

        /**
         * setta il luogo della scoperta del reperto
         *
         * @param [type] $luogo_scoperta
         * @return void
         */
        public function setLuogoScoperta($luogo_scoperta){
            $this->luogo_scoperta=$luogo_scoperta;
        }

        /**
         * setta la data scoperta del reperto
         *
         * @param [type] $data_scoperta
         * @return void
         */
        public function setDataScoperta($data_scoperta){
            $this->data_scoperta=$data_scoperta;
        }

        /**
         * setta la bibliografia del reperto
         *
         * @param [type] $bibliografia
         * @return void
         */
        public function setBibliografia($bibliografia){
            $this->bibliografia=$bibliografia;
        }

        /**
         * setta la descrizione del reperto
         *
         * @param [type] $descrizione
         * @return void
         */
        public function setDescrizione($descrizione){
            $this->descrizione=$descrizione;
        }

        /**
         * imposta pubblicato a "s" o "n"
         *
         * @param [type] $pubblicato
         * @return void
         */
        public function setPubblicato($pubblicato){
            $this->pubblicato=$pubblicato;
        }

        /**
         * setta l'id del proprietario del reperto
         *
         * @param [type] $id_proprietario
         * @return void
         */
        public function setIdProprietario($id_proprietario){
            $this->id_proprietario=$id_proprietario;
        }

        /**
         * setta l'id del museo in cui è custodito il reperto
         *
         * @param [type] $id_museo
         * @return void
         */
        public function setIDMuseo ($id_museo){
            $this->id_museo=$id_museo;
        }

    }
?>