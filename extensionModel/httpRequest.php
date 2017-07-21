<?php

    include_once 'dbInterfaces/MultimediaDbInterface.php';
    include_once 'dbInterfaces/RepertiDbInterface.php';

    /**
     * Classe che permette di elaborare i dati ricevuti dal 
     * client ed inviare i risultati al client stesso sotto
     * forma di oggetto json, contente sia il reperto richiesto
     * e sia tutti i dati dei file mltimediali collegati ad esso
     */
    class HttpRequest
    {
        private $id;            //id del reperto
        private $multimedias;   //array di file multimediali relativi al reperto trovati
        private $reperto;       //oggetto di classe Reperto

        /**
         * Costruttore per la classe
         * @param int $id
         */
        public function __construct($id) 
        {
            $this->id = $id;
        }

        /**
         * Preleva dal database le informazini relative al reperto e ai file 
         * multimediali ad esso collegati in base all'id del reperto stesso
         */
        public function receiver()
        {
            $multimediaDbInstance = new MultimediaDbInterface();
            $multimediaDbInstance->createConn();
            $this->multimedias = $multimediaDbInstance->readByReperto($this->id);
            $multimediaDbInstance->closeConn();

            $repertiDbInstance = new RepertiDbInterface();
            $repertiDbInstance->createConn();
            $this->reperto = $repertiDbInstance->readById($this->id);
            $repertiDbInstance->closeConn();
        }

        /**
         * Invia al client le informazioni estratte dal database
         * sottoforma di oggetto Json
         */
        public function sender()
        {
            header('Content-type: application/json');
            $toSend = array($this->reperto, $this->multimedias);
            echo json_encode($toSend);
        }
    }
?>