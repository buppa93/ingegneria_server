<?php
    ini_set('display_errors',1); 
    error_reporting(E_ALL);
    include "/storage/ssd4/018/2182018/public_html/wp-content/plugins/extensionModel/model/persona.php";

    class PersonaDbInterface
    {
        const SERVER_NAME = "localhost";                                        //Host del database
        const USER_NAME = "id2182018_wp_2b7567379edf76574fef63eae7088954";      //Username del database
        const PASSWORD = "bdhlcwbiucsluicgs";                                   //Password del database
        const DB_NAME = "id2182018_wp_2b7567379edf76574fef63eae7088954";        //Nome del database
        
        public $conn;                                                           //Connesione al database

        /**
         * Costruttore per la classe PersonaDbInterface.
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
         * Inserisce nel database una nuova persona
         * @param Persona $persona
         */
        public function create($persona)
        {
            $query = "INSERT INTO persona (numero_documento, telefono, nome, cognome, id_museo)" .
                     ' VALUES ("'.$persona->getNumeroDocumento().'", '.$persona->getIdRuolo().', "'.$persona->getTelefono().'", "'
                     .$persona->getNome().'", "'.$persona->getCognome().'", '.$persona->getIdMuseo()."')";

            $result = $this->conn->query($query);
            return $result;
        }

        /**
         * Preleva tutti le persone dal database
         * @return array
         */
        public function read()
        {
            $query = "SELECT * FROM persona";

            $result = $this->conn->query($query);

            $persone = array();
            $i = 0;

            if ($result->num_rows > 0) 
            {
                // output data of each row
                while($row = $result->fetch_assoc()) 
                {
                    $persona = new Persona($row["numero_documento"], $row["id_ruolo"], $row["telefono"],
                                        $row["nome"], $row["cognome"], $row["id_museo"]);
                    $persone[$i] = $persona;
                    $i++;
                }
            } 

            return $persone;
        }

        public function readOnlyDirettori()
        {
            $query = "SELECT * FROM persona WHERE id_ruolo LIKE 1";

            $result = $this->conn->query($query);

            $direttori = array();
            $i = 0;

            if ($result->num_rows > 0) 
            {
                // output data of each row
                while($row = $result->fetch_assoc()) 
                {
                    $direttore = new Persona($row["numero_documento"], $row["id_ruolo"], $row["telefono"],
                                        $row["nome"], $row["cognome"], $row["id_museo"]);
                    $direttori[$i] = $direttore;
                    $i++;
                }
            } 

            return $direttori;
        }

        public function readOnlyAutori()
        {
            $query = "SELECT * FROM persona WHERE id_ruolo LIKE 2";

            $result = $this->conn->query($query);

            $autori = array();
            $i = 0;

            if ($result->num_rows > 0) 
            {
                // output data of each row
                while($row = $result->fetch_assoc()) 
                {
                    $autore = new Persona($row["numero_documento"], $row["id_ruolo"], $row["telefono"],
                                        $row["nome"], $row["cognome"], $row["id_museo"]);
                    $autori[$i] = $autore;
                    $i++;
                }
            } 

            return $autori;
        }


        /**
         * Aggiorna la persona passato come parametro
         * @param Persona $persona
         * @return boolean true in caso di successo, false altrimenti
         */
        public function update($persona)
        {
            $query = 'UPDATE persona SET numero_documento="'.$persona->getNumeroDocumento().
                     '", id_ruolo='.$persona->getIdRuolo().
                     ', telefono="'.$persona->getTelefono().
                     '", nome="'.$persona->getNome().
                     '", cognome="'.$persona->getCognome().
                     '", id_museo='.$persona->getIdMuseo().
                     ' WHERE numero_documento LIKE "'.$persona->getNumeroDocumento().'"';

            if ($this->conn->query($query) === true) 
                return true;
            else 
                return false;
        }

        /**
         * Cancella la persona passato come parametro
         * @param Persona $persona
         * @return boolean true in caso di successo, false altrimenti
         */
        public function delete($persona)
        {
            $query = 'DELETE FROM persona WHERE numero_documento="'.$persona->getNumeroDocumento();

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