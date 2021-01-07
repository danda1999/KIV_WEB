<?php
class PrihlaseniKontroler extends Kontroler
{
    public function zpracuj($parametry)
    {
        $SpravceUzivatelu = new SpravceUzivatelu();

        if($SpravceUzivatelu->vratUzivatele())
        {
            if($_SESSION['uzivatel']['admin'])
            {
                $this->smeruj('administraceadmin');
            }
            else
            {
                $this->smeruj('administrace');
            }
        }

        $this->hlavicka['titulek'] = 'Přihlášení';
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
            catch(ChybaUzivatele $chyba)
            {
                $this->smeruj('prihlaseni');
            }

        }

        $this->pohled = 'prihlaseni';
    }
}
?>