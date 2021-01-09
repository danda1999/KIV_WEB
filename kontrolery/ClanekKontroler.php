<?php
/**
* @author Daniel Cífka
* @version 2021-1-9
* Kontroler pro články dědí z abstraktního kontroleru a samostatne implementuje metodu zpravuj, která kontroluje některé parametry.
* Např. zdali získaný argument za kontrolerem je nazev urcite clanku, který se má vykonat a nebo zdali další parametry jsou případní funkce
* Dale pak rozhoduje který druh seznamu článků má být vykreslen. 
* Pokud je uživatel admin vypíší se všechny články
* Pokud je recenzent pouze nepoblikované články, které lze ohodnotit
* Pokud autor tak pouze jeho články
* Dale pak jo administrat
*/
class ClanekKontroler extends Kontroler
{
    /**
     * @param parametry argumenty v url adrese za nazvem kontroler
     * Příklad: localhost/clanek
     * Přílad: localhost/clanek/url_clanku/odstranit
     */
    public function zpracuj($parametry)
    {
        
        $spravceClanku = new SpravceClanku(); //tvorba promený modelu SpravceClanku

        $spravceUzivatelu = new SpravceUzivatelu(); //tvorba promený modelu SpravceUzivatleu
        $uzivatel = $spravceUzivatelu->vratUzivatele(); //ziska informace o zivateli

        /**
         * Zjistí zdali posledni argument je odstranit
         */
        if((!empty($parametry[1])) && ($parametry[1] == 'odstranit'))
        {   
            $clanek = $spravceClanku->vratClanek($parametry[0]); //vratí informace o clanku
            $spravceClanku->odstranClanek($parametry[0]); //odebere clanek
            $spravceClanku->odstranRecenze($parametry[0]); // odebere i jeho recenze, jelikož by zabírali místo
            if(unlink($clanek['soubor_cesta'])) //odebere spojený pdf soubor s tímto článkem
            {
                $this->smeruj('clanek'); //presmeruje na seznam clanku
            }
        }

        /**
         * pokud je prvni parametr za kontrolerem true kontrole preda ziskany data od modelu promenným hlavička a data.
         * a tyto získaný informace lze pak vypisovat v pohledu
         */
        else if (!empty($parametry[0]))
        {
            $clanek = $spravceClanku->vratClanek($parametry[0]);
            if (!$clanek)
            {
                $this->smeruj('chyba'); //pokud članek neexistuje presmerujeme se na chybu
            }
            $this->hlavicka = array(
                'titulek' => $clanek['titulek'],
                'klicova_slova' => $clanek['klicova_slova'],
                'popis' => $clanek['popisek'],
            );

            $this->data['titulek'] = $clanek['titulek'];
            $this->data['obsah'] = $clanek['obsah'];
            $this->data['soubor'] = $clanek['soubor_cesta'];

            $this->pohled = 'clanek';
        }
        /**
         * zjistuje zdali je uzivatel admin
         */
        else if ((isset($_SESSION['uzivatel']))&&($_SESSION['uzivatel']['admin']))
        {

            $clanky = $spravceClanku->vratClanky();
            $this->hlavicka['titulek'] = "Články Administrátor";
            $this->data['clanky'] = $clanky;
            $this->pohled = 'clankyadmin';
        }
        /**
         * recenzent
         */
        else if ((isset($_SESSION['uzivatel']))&&($_SESSION['uzivatel']['recenzent']))
        {
            $clanky = $spravceClanku->vractClankyRecenze();
            $this->hlavicka['titulek'] = "Články Recenzent";
            $this->data['clanky'] = $clanky;
            $this->pohled = 'clankyrecenzent';
        }
        /**
         * autor
         */
        else if ((isset($_SESSION['uzivatel']))&&(!$_SESSION['uzivatel']['recenzent'])&&(!$_SESSION['uzivatel']['admin']))
        {
            $clanky = $spravceClanku->autorClanky();
            $this->hlavicka['titulek'] = "Články Autor";
            $this->data['clanky'] = $clanky;
            $this->pohled = 'clankyautor';
        }
        /**
         * nepřihlášený uživatel
         */
        else
        {
            $clanky = $spravceClanku->vratClankyPublikovane();
            $this->hlavicka['titulek'] = "Články";
            $this->data['clanky'] = $clanky;
            $this->pohled = 'clanky';
        }
    }
}

?>