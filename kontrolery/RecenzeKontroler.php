<?php
/**
 * @author Daniel Cífka
 * @version 2021-1-9
 * Kontroler Recenze slouží k vypísu recenzí zvoleného článku, tak že získané data přidáme do zdědený proměný data
 * a tu pak dále používá pohled
 * Druhou funkcionalito je možnost publikování konkrétního článku na webu
 */
class RecenzeKontroler extends Kontroler
{
    /**
     * @param parametry argumenty v url adrese za nazvem kontroler
     */
    public function zpracuj ($parametry)
    {
        $spravceClanku = new SpravceClanku(); // instance pro komunikaci s modelem pro články

        $spravceUzivatele = new SpravceUzivatelu(); //instance pro omunikaci s modelem pro uživatele
        $uzivatel = $spravceUzivatele->vratUzivatele(); //vrátí informace o uživateli

        /**
         * pokud bude parametr za nazvem článku slovo publikuj zavolá se metoda publikuj s parametrem názvu článku
         */
        if((!empty($parametry[1])) && ($parametry[1] == 'publikuj'))
        {
            $spravceClanku->publikuj($parametry[0]);
            $this->smeruj('clanek'); //presmeruje na články
        }

        /**
         * pokud je zadná parametr článku tak získám jeho recenze z modelu, a pak je predám pohledu
         */
        if (!empty($parametry[0]))
        {
            $recenze = $spravceClanku->recenezClanku($parametry[0]);

            $this->hlavicka = array('titulek' => $parametry[0],'klicova_slova' => $parametry[0],'popis' => $parametry[0]);

            $this->data['nadpis'] = $parametry[0];
            $this->data['recenze'] = $recenze;
            $this->pohled = 'recenzetitulek'; //pohled na seznam recenzí článku
            
        }
    }
}