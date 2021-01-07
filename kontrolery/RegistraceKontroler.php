<?php
class RegistraceKontroler extends Kontroler
{
    public function zpracuj($parametry)
    {
        $this->hlavicka['titulek'] = 'Registrace';
        if ($_POST)
        {
            try
            {
                $spravceUzivatelu = new SpravceUzivatelu();
                $spravceUzivatelu->registruj($_POST['login'], $_POST['jmeno'], $_POST['prijmeni'], $_POST['email'], $_POST['heslo'], $_POST['heslo_znovu'], $_POST['rok']);
                $spravceUzivatelu->prihlas($_POST['login'], $_POST['heslo']);
                $this->smeruj('administrace');
            }
            catch (ChybaUzivatele $chyba)
            {
            }
        }
        
        $this->pohled = 'registrace';
    }
}
?>