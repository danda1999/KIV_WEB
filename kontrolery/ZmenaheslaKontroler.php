<?php
/**
 * @author Daniel Cífka
 * @version 2021-1-9
 * Kontroler pro zmenu hesla je pouze prostředník který získaný data z formuláře předá modelu pro správu uživatele
 */
class ZmenaheslaKontroler extends Kontroler
{
    /**
     * @param parametry argumenty v url adrese za nazvem kontroler
     */
    public function zpracuj($parametry)
    {
        $SpravceUzivatelu = new SpravceUzivatelu();

        $this->hlavicka['titulek'] = 'Změna Hesla';

        if($_POST)
        {
            if($_POST['rok'] == date('Y')) //kontrola souhlasu roků
            {
                if($_POST['heslo'] == $_POST['heslo_znovu']) //kontrola souhlasu hesel
                {
                    if(!password_verify($_POST['heslo'], $_SESSION['uzivatel']['heslo'])) //kontrola zdali nejsou hesla stejný se stávajícím
                    {
                        $SpravceUzivatelu->zmenaHesla($_POST['heslo']); //uživateli změní heslo
                        /**
                         * zde docjde kodhlašení uživatele, kvůli kontroler změně hesla a správnému zadaní loginu
                         */
                        if($_SESSION['uzivatel']['admin'])
                        {
                            $this->smeruj('administraceadmin/odhlasit');
                        }
                        else if($_SESSION['uzivatel']['recenzent'])
                        {
                            $this->smeruj('administracerecenzent/odhlasit');
                        }
                        else
                        {
                            $this->smeruj('administrace/odhlasit');
                        }
                    }
                    else
                    {
                        $this->smeruj('prihlaseni');
                    }
                }
            }
            else
            {
                $this->smeruj('zmenahesla');
            }
        }

        $this->pohled = 'zmenahesla';
    }
}