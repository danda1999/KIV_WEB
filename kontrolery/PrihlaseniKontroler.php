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
                $this->presmeruj('administraceadmin');
            }
            else
            {
                $this->presmeruj('administrace');
            }
        }

        $this->hlavicka['titulek'] = 'Přihlášení';
        if($_POST)
        {
            try
            {
                $SpravceUzivatelu->prihlas($_POST['Login'], $_POST['heslo']);
                $this->pridejZpravu('Byl jste úspěšně přihlášen.');
                if($_SESSION['uzivatel']['admin'])
                {
                    $this->presmeruj('administraceadmin');
                }
                else if($_SESSION['uzivatel']['recenzent'])
                {
                    $this->presmeruj('administraceadmin');
                }
                else
                {
                    $this->presmeruj('administrace');
                }
            }
            catch(ChybaUzivatele $chyba)
            {
                $this->pridejZpravu($chyba->getMessage());
            }

        }

        $this->pohled = 'prihlaseni';
    }
}
?>