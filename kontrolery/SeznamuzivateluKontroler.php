<?php
/**
 * @author Daniel Cífka
 * @version 2021-1-9
 * Máme zde kontroler pro výpis uživatelů
 * Hlavní logika je pouze v tom, pokud na konci url jedna ze 3 možností, tak se vykoná její funkcionalita v databázi.
 * Pouze se zde z parametrů v url zjistuje o jakého se jedná uživatele a jakou se jedná činnost
 */
class SeznamuzivateluKontroler extends Kontroler
{
    /**
     * @param parametry argumenty v url adrese za nazvem kontroler
     */
    public function zpracuj($parametry)
    {
        $this->hlavicka['titulek'] = 'Seznam uživatelů';
        $spravceUzivatelu = new SpravceUzivatelu(); //instance pro komunikaci s modlem Správce užiatelů

        /**
         * Pokud je poslední parametr odstranit, tak se daný uživatel podle predaneho id v parametru 0 odstraní
         */
        if((!empty($parametry[1]))&&($parametry[1] == 'odstranit'))
        {
            $spravceUzivatelu->odeberUzivatele($parametry[0]);
            $this->smeruj('seznamuzivatelu');
        }
        /**
         * Pokud je poslední parametr autor, tak se uživately podle predaneho id v parametru 0 zmení pozice na autora
         */
        else if((!empty($parametry[1]))&&($parametry[1] == 'autor'))
        {
            $spravceUzivatelu->opravneniAutor($parametry[0]);
            $this->smeruj('seznamuzivatelu');
            
        }
        /**
         * Pokud je poslední parametr autor, tak se uživately podle predaneho id v parametru 0 zmení pozice na recenzenta
         */
        else if((!empty($parametry[1]))&&($parametry[1] == 'recenzent'))
        {
            $spravceUzivatelu->opravneniRecenzent($parametry[0]);
            $this->smeruj('seznamuzivatelu');
        }
        /**
         * Vypis seznamu uživatelů
         */
        else
        {
            $uzivatele = $spravceUzivatelu->uzivatele();
            $this->data['uzivatele'] = $uzivatele;
            $this->pohled = 'seznamuzivatelu';
        }
    }
}