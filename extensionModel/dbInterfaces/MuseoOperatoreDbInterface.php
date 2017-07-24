<?php
    include_once '/storage/ssd4/018/2182018/public_html/wp-content/plugins/extensionModel/model/museo-operatore.php';

    /**
     * Interfaccia per la comunicazione al database con
     * la tabella museo-operatore
     */
    class MuseoOperatoreDbInterface
    {
        const SERVER_NAME = "localhost";                                        //Host del database
        const USER_NAME = "id2182018_wp_2b7567379edf76574fef63eae7088954";      //Username del database
        const PASSWORD = "bdhlcwbiucsluicgs";                                   //Password del database
        const DB_NAME = "id2182018_wp_2b7567379edf76574fef63eae7088954";        //Nome del database
        
        public $conn;                                                           //Connesione al database

        /**
         * Costruttore per la classe MuseoOperatoreDbInterface.
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
         * Inserisce nel database una nuova associazione museo-operatore
         * @param MuseoOpertaore $museoOperatore
         */
        public function create($museoOperatore)
        {
            $query = "INSERT INTO `museo-operatore` (id_museo, id_operatore)" .
                     " VALUES (".$museoOperatore->getIdMuseo().", ".$museoOperatore->getIdOperatore().")";

            $result = $this->conn->query($query);
            return $result;
        }

        /**
         * Preleva tutte le associazioni museo-operatore
         * dal database
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
         * Cancella l'associzione museo-operatore avente ids uguali a quelli
         * passati come parametro
         * @param int $id_museo
         * @param int $id_operatore
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