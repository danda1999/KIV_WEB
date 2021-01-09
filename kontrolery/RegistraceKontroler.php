<?php
/**
 * @author Daniel Cífka
 * @version 2021-1-9
 * Kontroler pro registraci pouze předává získaný data modelu pro správu uživatelů a pokud je vše v pořídku
 * tak se přihlásíme a po přihlášení jsme presměrovany na administraci
 */
class RegistraceKontroler extends Kontroler
{
    /**
     * @param parametry argumenty v url adrese za nazvem kontroler
     */
    public function zpracuj($parametry)
    {
        $this->hlavicka['titulek'] = 'Registrace';
        /**
         * Přijatá data jsou předaný modelu pro registraci a nasledně login a heslo předaný pro přihlášení
         * Pokud je detekováná chyba, tak je uživatel přenesen znovu na registraci
         */
        if ($_POST)
        {
            try
            {
                $spravceUzivatelu = new SpravceUzivatelu(); //instance pro komunikaci s modelem uživatele
                $spravceUzivatelu->registruj($_POST['login'], $_POST['jmeno'], $_POST['prijmeni'], $_POST['email'], $_POST['heslo'], $_POST['heslo_znovu'], $_POST['rok']);
                $spravceUzivatelu->prihlas($_POST['login'], $_POST['heslo']);
                $this->smeruj('administrace');
            }
            catch (ChybaUzivatele $chyba)
            {
                $this->smeruj('registrace');
            }
        }
        
        $this->pohled = 'registrace';
    }
}
?>