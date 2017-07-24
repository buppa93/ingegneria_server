<?php
    include_once "/storage/ssd4/018/2182018/public_html/wp-content/plugins/extensionModel/model/reperto.php";

    /**
     * Interfaccia per la comunicazione al database con
     * la tabella reperto
     */
    class RepertiDbInterface
    {
        const SERVER_NAME = "localhost";                                        //Host del database
        const USER_NAME = "id2182018_wp_2b7567379edf76574fef63eae7088954";      //Username del database
        const PASSWORD = "bdhlcwbiucsluicgs";                                   //Password del database
        const DB_NAME = "id2182018_wp_2b7567379edf76574fef63eae7088954";        //Nome del database
        
        public $conn;                                                           //Connesione al database

        /**
         * Costruttore per la classe RepertiDbInterface.
         */
        public function __construct() {}

        /**
         * Crea la connessione al database
         * @return boolean false in caso di errori, tue altrimenti
         */
        public function createConn()
        {
            $this->conn = new mysqli(self::SERVER_NAME, self::USER_NAME, 
                                self::PASSWORD, self::DB_NAME);

            if(mysqli_connect_error())
                return false;
            else
                return true;
        }

        /**
         * Inserisce nel database un nuovo reperto
         * @param Reperto $reperto
         */
        public function create($reperto)
        {
            $query = 'INSERT INTO reperto (id, id_museo, id_proprietario, data_acquisizione, dimensioni, valore, titolo,'.
                     'tipo, nome_autore, peso, luogo_scoperta, data_scoperta, bibliografia, descrizione, pubblicato)'.
                     ' VALUES ('.$reperto->getId().', '
                     .$reperto->getIdMuseo().', "'
                     .$reperto->getIdProprietario().'", "'
                     .$reperto->getDataAcquisizione()
                     .'", "'.$reperto->getDimensioni()
                     .'", '.$reperto->getValore().', "'
                     .$reperto->getTitolo()
                     .'", "'.$reperto->getTipo()
                     .'", "'.$reperto->getNomeAutore()
                     .'", '.$reperto->getPeso().
                     ', "'.$reperto->getLuogoScoperta()
                     .'", "'.$reperto->getDataScoperta().
                     '", "'.$reperto->getBibliografia().
                     '", "'.$reperto->getDescrizione()
                     .'", '."'"
                     .$reperto->getPubblicato()."')";

            $result = $this->conn->query($query);
            return $result;
        }

        /**
         * Preleva tutti i reperto dal database
         * @return array
         */
        public function read()
        {
            $query = "SELECT * FROM reperto";

            $result = $this->conn->query($query);

            $reperti = array();
            $i = 0;

            if ($result->num_rows > 0) 
            {
                // output data of each row
                while($row = $result->fetch_assoc()) 
                {
                    $reperto = new Reperto($row["id"], $row["id_museo"], $row["id_proprietario"], $row["data_acquisizione"], 
                                            $row["dimensioni"], $row["valore"], $row["titolo"], $row["tipo"], $row["nome_autore"], 
                                            $row["peso"], $row["luogo_scoperta"], $row["data_scoperta"], $row["bibliografia"], 
                                            $row["descrizione"], $row["pubblicato"]);
                    $reperti[$i] = $reperto;

                    $i++;
                    
                }
            } 

            return $reperti;
        }

        /**
         * Preleva il reperto avente id uguale all'intero passato come parametro e pubblicato = 's'
         * @param int $id
         * @return array
         */
        public function readById($id)
        {
            $query = 'SELECT * FROM reperto WHERE (id LIKE '.$id.' AND pubblicato LIKE \'s\')';

            $result = $this->conn->query($query);

            $reperti = array();
            $i = 0;

            if ($result->num_rows > 0) 
            {
                // output data of each row
                while($row = $result->fetch_assoc()) 
                {
                    $reperto = new Reperto($row["id"], $row["id_museo"], $row["id_proprietario"], $row["data_acquisizione"], 
                                            $row["dimensioni"], $row["valore"], $row["titolo"], $row["tipo"], $row["nome_autore"], 
                                            $row["peso"], $row["luogo_scoperta"], $row["data_scoperta"], $row["bibliografia"], 
                                            $row["descrizione"], $row["pubblicato"]);
                    $reperti[$i]["id"] = $row["id"];
                    $reperti[$i]["id_museo"] = $row["id_museo"];
                    $reperti[$i]["id_proprietario"] = $row["id_proprietario"];
                    $reperti[$i]["data_acquisizione"] = $row["data_acquisizione"];
                    $reperti[$i]["dimesioni"] = $row["dimensioni"];
                    $reperti[$i]["valore"] = $row["valore"];
                    $reperti[$i]["titolo"] = $row["titolo"];
                    $reperti[$i]["tipo"] = $row["tipo"];
                    $reperti[$i]["nome_autore"] = $row["nome_autore"];
                    $reperti[$i]["peso"] = $row["peso"];
                    $reperti[$i]["luogo_scoperta"] = $row["luogo_scoperta"];
                    $reperti[$i]["data_scoperta"] = $row["data_scoperta"];
                    $reperti[$i]["bibliografia"] = $row["bibliografia"];
                    $reperti[$i]["descrizione"] = $row["descrizione"];
                    $reperti[$i]["pubblicato"] = $row["pubblicato"];

                    $i++;
                    
                }
            } 

            return $reperti;
        }


        /**
         * Aggiorna il reperto passato come parametro
         * @param Reperto $reperto
         * @return boolean true in caso di successo, false altrimenti
         */
        public function update($reperto)
        {
            $query = 'UPDATE reperto SET id='.$reperto->getId().
                     ', id_museo='.$reperto->getIdMuseo().
                     ', id_proprietario="'.$reperto->getIdProprietario().
                     '", data_acquisizione="'.$reperto->getDataAcquisizione().
                     '", dimensioni="'.$reperto->getDimensioni().
                     '", valore='.$reperto->getValore().
                     ', titolo="'.$reperto->getTitolo().
                     '", nome_autore="'.$reperto->getNomeAutore().
                     '", peso='.$reperto->getPeso().
                     ', luogo_scoperta="'.$reperto->getLuogoScoperta().
                     '", data_scoperta="'.$reperto->getDataScoperta().
                     '", bibliografia="'.$reperto->getBibliografia().
                     '", descrizione="'.$reperto->getDescrizione().
                     '", pubblicato='."'".$reperto->getPubblicato()."'".
                     ' WHERE id LIKE '.$reperto->getID();

            if ($this->conn->query($query) === true) 
                return true;
            else 
                return false;
        }

        /**
         * Cancella il reperto avente id uguale a quello passato come parametro
         * @param Reperto $reperto
         * @return boolean true in caso di successo, false altrimenti
         */
        public function delete($id)
        {
            $query = "DELETE FROM reperto WHERE id=".$id;

            if ($this->conn->query($query) === true) 
                return true;
            else 
                return false;
        }

        /**
         * Ritorna la connessione al database
         * @return mysqli
         */
        public function getConn()
        {
            return $this->conn;
        }

        /**
         * Chiude la connessione al database
         */
        public function closeConn()
        {
            $this->conn->close();
        }
    }
?>