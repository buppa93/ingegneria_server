<?php
    include_once "/storage/ssd4/018/2182018/public_html/wp-content/plugins/extensionModel/model/tipo-multimedia.php";

    /**
     * Interfaccia per la comunicazione al database con
     * la tabella tipo_multimedia
     */
    class TipoMultimediaDbInterface
    {
        const SERVER_NAME = "localhost";                                        //Host del database
        const USER_NAME = "id2182018_wp_2b7567379edf76574fef63eae7088954";      //Username del database
        const PASSWORD = "bdhlcwbiucsluicgs";                                   //Password del database
        const DB_NAME = "id2182018_wp_2b7567379edf76574fef63eae7088954";        //Nome del database
        
        public $conn;                                                           //Connesione al database

        /**
         * Costruttore per la classe TipoMultimediaDbInterface.
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
         * Inserisce nel database un nuovo tipo multimedia
         * @param TipoMultimedia $tipoMultimedia
         */
        public function create($tipoMultimedia)
        {
            $query = 'INSERT INTO tipo_multimedia (id, nome)' .
                     ' VALUES ('.$tipoMultimedia->getId.', "'.$tipoMultimedia->getNome.'")';

            $result = $this->conn->query($query);
            return $result;
        }

        /**
         * Preleva tutti i tipi multimedia dal database
         * @return array
         */
        public function read()
        {   
            $query = "SELECT * FROM tipo_multimedia;";
            $result = $this->conn->query($query);
            $tipiMultimedia = array();
            $i = 0;

            if ($result->num_rows > 0) 
            {
                // output data of each row
                while($row = $result->fetch_assoc()) 
                {
                    $tipoMultimedia = new TipoMultimedia($row["id"], $row["nome"]);
                    $tipiMultimedia[$i] = $tipoMultimedia;
                    $i++;
                }
            } 

            return $tipiMultimedia;
        }

        /**
         * Aggiorna il tipo multimedia passato come parametro
         * @param TipoMultimedia $tipoMultimedia
         * @return boolean true in caso di successo, false altrimenti
         */
        public function update($tipoMultimedia)
        {
            $query = 'UPDATE tipo_multimedia SET id='.$tipoMultimedia->getId().
                     ', nome="'.$tipoMultimedia->getNome().'" '.
                     'WHERE id LIKE '.$tipoMultimedia->getID();

            if ($this->conn->query($query) === true) 
                return true;
            else 
                return false;
        }

        /**
         * Cancella il tipo multimedia passato come parametro
         * @param TipoMultimedia $tipoMultimedia
         * @return boolean true in caso di successo, false altrimenti
         */
        public function delete($tipoMultimedia)
        {
            $query = "DELETE FROM tipo_multimedia WHERE id=".$tipoMultimedia->getId();

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