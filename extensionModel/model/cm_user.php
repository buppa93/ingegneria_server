<?php

/**
 * Classe CmUser 
 * Associata alla classe WPUser
 */
class CmUser
{
    private $wp_user;

    /**
     * costruttore parametrizzato
     */
    public function __construct($wp_user)
    {
        $this->wp_user = $wp_user;
    }

    /**
     * Ritorna il ruolo di un CmUser
     * @return string
     */
    public function getRole()
    {
        return $this->wp_user->roles[0];
    }

    /**
     * Verifica che un CmUser sia amministratore 
     * o meno
     * @return boolean true in caso sia amministratore, false altrimenti
     */
    public function isAmministratore()
    {
        if($this->getRole() == "administrator")
            return true;
        else
            return false;
    }

    /**
     * Verifica che un CmUser sia direttore 
     * o meno
     * @return boolean true in caso sia direttore, false altrimenti
     */
    public function isDirettore()
    {
        if($this->getRole() == "editor")
            return true;
        else
            return false;
    }

    /**
     * Verifica che un CmUser sia operatore 
     * o meno
     * @return boolean true in caso sia operatore, false altrimenti
     */
    public function isOperatore()
    {
        if($this->getRole() == "author")
            return true;
        else
            return false;
    }

    /**
     * Verifica che un CmUser sia proprietario 
     * o meno
     * @return boolean true in caso sia proprietario, false altrimenti
     */
    public function isProprietario()
    {
        if($this->getRole() == "contributor")
            return true;
        else
            return false;
    }

    /**
     * Restituisce l'attributo wp_user
     * o meno
     * @return WPUser 
     */
    public function getUser()
    {
        return $this->wp_user;
    }

    /**
     * Setta il parametro $_SESSION["UserRole"] relativo all'oggetto
     * CmUser
     * @return void
     */
    public function setUserCookie()
    {
        if($this->isAmministratore())
            $_SESSION['UserRole'] = "amministratore";
        else if($this->isDirettore())
            $_SESSION['UserRole'] = "direttore";
        else if($this->isOperatore())
            $_SESSION['UserRole'] = "operatore";
        else if($this->isProprietario())
            $_SESSION['UserRole'] = "proprietario";
        else
            $_SESSION['UserRole'] = "sconosciuto";
    }
}
?>