<?php
class RegistraceKontroler extends Kontroler
{
    public function zpracuj($parametry)
    {
        // Hlavička stránky
        $this->hlavicka['titulek'] = 'Registrace';
        if ($_POST)
        {
            try
            {
                $spravceUzivatelu = new SpravceUzivatelu();
                $spravceUzivatelu->registruj($_POST['login'], $_POST['jmeno'], $_POST['prijmeni'], $_POST['email'], $_POST['heslo'], $_POST['heslo_znovu'], $_POST['rok']);
                $spravceUzivatelu->prihlas($_POST['login'], $_POST['heslo']);
                $this->pridejZpravu('Byl jste úspěšně zaregistrován.');
                $this->presmeruj('administrace');
            }
            catch (ChybaUzivatele $chyba)
            {
                $this->pridejZpravu($chyba->getMessage());
            }
        }
        // Nastavení šablony
        $this->pohled = 'registrace';
    }
}
?>