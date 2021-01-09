<?php
/**
 * @author Daniel Cífka
 * @version 2021-1-9
 * Administrace kontroler dědí z abstraktního kontroleru a samostatne implementuje metodu zpravuj, která kontroluje některé parametry.
 * Např. zdali získaný argument za kontrolerem je nazev urcite funkce, ktera se má vykonnat
 * Dale zde do proměnný data ukladáme získaný data o uživateli, který je přihlášený
 */
class AdministraceadminKontroler extends Kontroler
{
    /**
     * @param parametry argumenty v url adrese za nazvem kontroler
     * Příklad: localhost/administraceadmin/odhlasit
     */
    public function zpracuj($parametry)
    {
        $this->hlavicka['titulek'] = 'Administrace Administrátor'; //predaný titulek názvu stránky

        $spravceUzivatelu = new SpravceUzivatelu(); //tvorba proměnný model SpravceUzivatelu

        /**
         * Zjisštění, zdali je poslední argument odhlásit
         */
        if((!empty($parametry[0]))&& ($parametry[0] = 'odhlasit'))
        {
            $spravceUzivatelu->odhlas(); //odhlási uzivtale
            $this->smeruj('uvod'); //přesmeruje na úvodní stranu
        }
        /**
         * pokud je už uživatel přihlášený a znovu se přihlásí na profil, tak se pouze vráti jeho informace v $_SESSION
         */
        $uzivatel = $spravceUzivatelu->vratUzivatele(); 
        $this->data['uzivatel'] = $uzivatel; //vloží se do dat

        $this->pohled = 'administraceadmin'; //předá se informace o pohledu a vykreslíse
    }
}
?>