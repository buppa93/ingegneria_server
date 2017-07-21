<?php
    ini_set('display_errors',1); 
    error_reporting(E_ALL);
    include_once '/storage/ssd4/018/2182018/public_html/wp-content/plugins/extensionModel/model/multimedia.php';

    class MultimediaDbInterface
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
        public function create($multimedia)
        {
            $query = 'INSERT INTO multimedia (id, id_tipo, id_reperto, url)' .
                     ' VALUES ('.$multimedia->getId().', '.$multimedia->getIdTipo().', 
                     '.$multimedia->getIdReperto().', "'.$multimedia->getUrl().'")';

            $result = $this->conn->query($query);
            return $result;
        }

        /**
         * Preleva tutti i multimedia dal database
         * @return array
         */
        public function read()
        {
            $query = "SELECT * FROM multimedia";

            $result = $this->conn->query($query);

            $multimedias = array();
            $i = 0;

            if ($result->num_rows > 0) 
            {
                // output data of each row
                while($row = $result->fetch_assoc()) 
                {
                    $multimedia = new Multimedia($row["id"], $row["id_tipo"], $row["url"],
                                        $row["id_reperto"]);
                    $multimedias[$i] = $multimedia;
                    $i++;
                }
            } 

            return $multimedias;
        }

        /**
         * Preleva le informazioni relative al reperto avente lo stesso id dell'intero
         * passato come parametro
         * @param int $idReperto
         * @return array
         */
        public function readByReperto($idReperto)
        {
            $query = "SELECT * FROM multimedia WHERE id_reperto LIKE ".$idReperto;

            $result = $this->conn->query($query);

            $multimedias = array();
            $i = 0;

            if ($result->num_rows > 0) 
            {
                // output data of each row
                while($row = $result->fetch_assoc()) 
                {
                    $multimedias[$i]["id"] = $row["id"];
                    $multimedias[$i]["id_tipo"] = $row["id_tipo"];
                    $multimedias[$i]["url"] = $row["url"];
                    $multimedias[$i]["id_reperto"] = $row["id_reperto"];

                    $i++;
                }
            } 

            return $multimedias;
        }

        /**
         * Aggiorna il multimedia passato come parametro
         * @param Multimedia $multimedia
         * @return boolean true in caso di successo, false altrimenti
         */
        public function update($multimedia)
        {
            $query = 'UPDATE multimedia SET id='.$multimedia->getId().
                     ', id_tipo='.$multimedia->getIdTipo().
                     ', id_reperto='.$multimedia->getIdReperto().
                     ', url="'.$multimedia->getUrl().
                     '" WHERE id LIKE '.$multimedia->getID();

            if ($this->conn->query($query) === true) 
                return true;
            else 
                return false;
        }

        /**
         * Cancella il multimedia avente id uguale passato come parametro
         * @param int $id
         * @return boolean true in caso di successo, false altrimenti
         */
        public function delete($id)
        {
            $query = "DELETE FROM multimedia WHERE id=".$id;

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