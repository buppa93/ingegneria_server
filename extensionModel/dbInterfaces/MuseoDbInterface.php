<?php
    ini_set('display_errors',1); 
    error_reporting(E_ALL);
    include "/storage/ssd4/018/2182018/public_html/wp-content/plugins/extensionModel/model/museo.php";

    class MuseoDbInterface
    {
        const SERVER_NAME = "localhost";                                        //Host del database
        const USER_NAME = "id2182018_wp_2b7567379edf76574fef63eae7088954";      //Username del database
        const PASSWORD = "bdhlcwbiucsluicgs";                                   //Password del database
        const DB_NAME = "id2182018_wp_2b7567379edf76574fef63eae7088954";        //Nome del database
        
        public $conn;                                                           //Connesione al database

        /**
         * Costruttore per la classe DbInterface.
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
         * Inserisce nel database un nuovo museo
         * @param Museo $museo
         */
        public function create($museo)
        {
            $query = 'INSERT INTO museo (id, id_direttore, nome, citta, indirizzo, telefono, orari)'.
                     ' VALUES ('.$museo->getId().', "'.$museo->getIdDirettore().'", "'.$museo->getNome().'", "'
                     .$museo->getCitta().'", "'.$museo->getIndirizzo().'", "'.$museo->getTelefono().'", "'
                     .$museo->getOrari().'")';

            $result = $this->conn->query($query);
            return $result;
        }

        /**
         * Preleva tutti i musei dal database
         * @return array
         */
        public function read()
        {
            $query = "SELECT * FROM museo";

            $result = $this->conn->query($query);

            $musei = array();
            $i = 0;

            if ($result->num_rows > 0) 
            {
                // output data of each row
                while($row = $result->fetch_assoc()) 
                {
                    $museo = new Museo($row["id"], $row["id_direttore"], $row["telefono"],
                                        $row["nome"], $row["citta"], $row["indirizzo"],
                                        $row["orari"]);
                    $musei[$i] = $museo;
                    $i++;
                }
            } 

            return $musei;
        }

        /**
         * Aggiorna il museo passato come parametro
         * @param Museo $museo
         * @return boolean true in caso di successo, false altrimenti
         */
        public function update($museo)
        {
            $query = 'UPDATE museo SET id='.$museo->getId().
                     ', id_direttore="'.$museo->getIdDirettore().
                     '", nome="'.$museo->getNome().
                     '", citta="'.$museo->getCitta().
                     '", indirizzo="'.$museo->getIndirizzo().
                     '", telefono="'.$museo->getTelefono().
                     '", orari="'.$museo->getOrari().
                     '" WHERE id LIKE '.$museo->getID();

            if ($this->conn->query($query) === true) 
                return true;
            else 
                return false;
        }

        /**
         * Cancella il museo passato come parametro
         * @param Museo $museo
         * @return boolean true in caso di successo, false altrimenti
         */
        public function delete($museo)
        {
            $query = "DELETE FROM museo WHERE id=".$museo->getId();

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