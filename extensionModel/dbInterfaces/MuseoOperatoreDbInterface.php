<?php
    ini_set('display_errors',1); 
    error_reporting(E_ALL);
    include_once '/storage/ssd4/018/2182018/public_html/wp-content/plugins/extensionModel/model/museo-operatore.php';

    class MuseoOperatoreDbInterface
    {
        const SERVER_NAME = "localhost";                                        //Host del database
        const USER_NAME = "id2182018_wp_2b7567379edf76574fef63eae7088954";      //Username del database
        const PASSWORD = "bdhlcwbiucsluicgs";                                   //Password del database
        const DB_NAME = "id2182018_wp_2b7567379edf76574fef63eae7088954";        //Nome del database
        
        public $conn;                                                           //Connesione al database

        /**
         * Costruttore per la classe MultimediaDbInterface.
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
         * Inserisce nel database un nuovo multimedia
         * @param Multimedia $multimedia
         */
        public function create($museoOperatore)
        {
            $query = "INSERT INTO `museo-operatore` (id_museo, id_operatore)" .
                     " VALUES (".$museoOperatore->getIdMuseo().", ".$museoOperatore->getIdOperatore().")";

            $result = $this->conn->query($query);
            return $result;
        }

        /**
         * Preleva tutti i multimedia dal database
         * @return array
         */
        public function read()
        {
            $query = "SELECT * FROM `museo-operatore`";

            $result = $this->conn->query($query);

            $museiOperatori = array();
            $i = 0;

            if ($result->num_rows > 0) 
            {
                // output data of each row
                while($row = $result->fetch_assoc()) 
                {
                    $museoOperatore = new MuseoOperatore($row["id_museo"], $row["id_operatore"]);
                    $museiOperatori[$i] = $museoOperatore;
                    $i++;
                }
            } 

            return $museiOperatori;
        }

        /**
         * Cancella il multimedia avente id uguale passato come parametro
         * @param int $id
         * @return boolean true in caso di successo, false altrimenti
         */
        public function delete($id_museo, $id_operatore)
        {
            $query = "DELETE FROM `museo-operatore` WHERE (id_museo="
                        .$id_museo." AND id_operatore="
                        .$id_operatore.")";

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