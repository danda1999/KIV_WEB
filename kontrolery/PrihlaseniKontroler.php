<?php
/**
 * @author Daniel Cífka
 * @version 2021-1-9
 * Koontroler pro přihlašení kontrule zdali je uživatel přihlášená nebo ne
 * Pokud je tak automaticky přenese na jeho profil, tato funkce je v aplikaci využita pouze jednou a to když se nepovede změna hesl
 * Jinak je pozustatek z prního nápadu.
 */
class PrihlaseniKontroler extends Kontroler
{
    /**
     * @param parametry argumenty v url adrese za nazvem kontroler
     */
    public function zpracuj($parametry)
    {
        $SpravceUzivatelu = new SpravceUzivatelu();

        if($SpravceUzivatelu->vratUzivatele()) //presmeruje na konkretní pohled podle toho jakou pozici má uživatel u sebe
        {
            if($_SESSION['uzivatel']['admin'])
            {
                $this->smeruj('administraceadmin');
            }
            else if($_SESSION['uzivatel']['recenzent']) 
            {
                $this->smeruj('administracerecenzent');
            }
            else
            {
                $this->smeruj('administrace');
            }
        }

        $this->hlavicka['titulek'] = "Přihlášení";

        /**
         * Udaje prijatý z formuláře, jsou predaný funci prihlasi, která je oveří a přihlásí uživatel
         * pote podle údajů uložených v $_SESSION rozhodne jakou administraci otevřít
         */
        if($_POST)
        {
            try
            {
                $SpravceUzivatelu->prihlas($_POST['Login'], $_POST['heslo']);
                if($_SESSION['uzivatel']['admin'])
                {
                    $this->smeruj('administraceadmin');
                }
                else if($_SESSION['uzivatel']['recenzent'])
                {
                    $this->smeruj('administracerecenzent');
                }
                else
                {
                    $this->smeruj('administrace');
                }
            }
            catch(ChybaUzivatele $chyba) //pokud nastane chyba při přihlášení, tak je uživatel znovu presmerovan na přihlášení
            {
                $this->smeruj('prihlaseni');
            }

        }

        $this->pohled = 'prihlaseni';
    }
}
?>