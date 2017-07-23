<?php
/**
 * Classe CmUser
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

    public function getRole()
    {
        return $this->wp_user->roles[0];
    }

    public function isAmministratore()
    {
        if($this->getRole() == "administrator")
            return true;
        else
            return false;
    }

    public function isDirettore()
    {
        if($this->getRole() == "editor")
            return true;
        else
            return false;
    }

    public function isOperatore()
    {
        if($this->getRole() == "author")
            return true;
        else
            return false;
    }

    public function isProprietario()
    {
        if($this->getRole() == "contributor")
            return true;
        else
            return false;
    }

    public function getUser()
    {
        return $this->wp_user;
    }

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