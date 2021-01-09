<?php
/**
 * @author Daniel Cífka
 * @version 2021-1-9
 * Zde se nachazí abstraktní konntrole, který obsahuje proměnný ohledně hlavičky, pohledu, který má být vykreslen a nakonec získaný data
 * Funkčnost kontroleru má za praci vykreslení získaneho pohledu a naleznout potřebný pohled a ochranu proti xss útoku.
 */
    abstract class Kontroler
    {
        protected $data = array(); /**pole pro získaná data */
        protected $pohled = ""; /**pohled pro vyreslení potřebné stránky */
        protected $hlavicka = array('titulek' => '', 'klicova_slova' => '', 'popis' => ''); /**zakladní hlavičkvé informace o strínce */

        abstract function zpracuj($parametry); /**abstraktní metoda zpracuj, propojení modelu a pohledu a kontrola příchozích dat */

        /**
         * Funkce pohled nalezne potřebný pohled a vypíše ho, ale předtím data překontrolu pro ochranu proti xss útoku
         * 
         */
        public function pohled()
        {
            if($this->pohled)
            {
                extract($this->xss($this->data));
                extract($this->data, EXTR_PREFIX_ALL, "");
                require("pohledy/" . $this->pohled . ".phtml");
            }
        }
        /**
         * Metode smeru pouze přesmeruje uživatele na potřebnou stránku
         * @param url ziskaná url, podle který se presmeruje
         */
        public function smeruj($url)
        {
            header("Location: /$url");
            header("Connection: close");
            exit;
        }
        
        /**
         * automatická funkce pro kontrolu xss utoku, tedy nelze z napadnout web xss útokem
         * @param x předaný text
         */
        private function xss($x = null)
        {
            if(!isset($x)) //pokud nei zadny text vraci null
            {
                return null;
            }
            elseif (is_string($x)) // kontrola získaneho řetězce
            {
                return htmlspecialchars($x, ENT_QUOTES);
            }
            elseif(is_array($x)) //kontrola získaného pole
            {
                foreach($x as $k => $v)
                {
                    $x[$k] = $this->xss($v);
                }
                return $x;
            }
            else // pokud je promena neco jineho nez text vrati proměnnou rovnou
            {
                return $x;
            }
        }
    }
?>