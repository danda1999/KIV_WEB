<?php
/**
* @author Daniel Cífka
* @version 2021-1-9
* Toto je hlavní kontroler pro trasovaní mého MVC modelu
* Ze získané url se převede na název kontroleru, který je tak zavolán a jeho funkcionalita se vykoná
*/
class SmerovacKontroler extends Kontroler
{
    protected $kontroler; // proměná pro získaný kontroler

    /**
     * @param parametry argumenty v url adrese za nazvem kontroler
     */
    public function zpracuj($parametry)
    {

        $naparsovanaURL = $this->parsujURL($parametry[0]); // získam zadanou rul
        $rawUrl = parse_url($parametry[0]); //naparsovanou url načtu do proměnný
        if(isset($rawUrl['query'])) //zjistím zdali existuje
        {
            $query = $rawUrl['query'];
            //rozděluji query od cesty
            $queryParam = [];
            $queryParamFromLeft = [];
            foreach (explode('&',$query) as $key => $value) 
            {
                $tempExp = explode('=', $value);
                $queryParam[$tempExp[0]] = $tempExp[1];
                $queryParamFromLeft[$key] = $tempExp[1];
                //vznikne
                //$path -> cesta index.php ... /uvod
                //$query -> bere to za ? vse 
                //$queryParam['path']  . .. ['url']
                //$queryParamFromLeft  . .. [0]   [1] [2]
            }
        }
        $path = $rawUrl['path'];
        
        //HEzke url
        if(empty($naparsovanaURL[0]))
        {
            $this->smeruj('uvod');
        }
        $tridaKontroleru = $this->notace(array_shift($naparsovanaURL)) . 'Kontroler';

        if(file_exists('kontrolery/' . $tridaKontroleru . '.php'))
        {
            $this->kontroler = new $tridaKontroleru;
        }
        //nehezke URL
        else
        {
            if('/index.php' == $path)
            {
                if(isset($queryParam['page']))
                {
                    $tridaKontroleru = $queryParam['page'].'Kontroler';
                    if(file_exists('kontrolery/' . $tridaKontroleru . '.php'))
                    {
                        $this->kontroler = new $tridaKontroleru;
                        array_shift($queryParamFromLeft);
                        $naparsovanaURL = $queryParamFromLeft;
                    }
                }
                else
                {
                    $this->smeruj('uvod');
                }
            }
            else{
                $this->smeruj('chyba');
            }
        }
        $this->kontroler->zpracuj($naparsovanaURL);

        /**
         * ze ziskaneho kontroler získá data do hlavičky a ty vloží jako sovje data se kteráma lze pak pracovat
         * 
         */
        $this->data['titulek'] = $this->kontroler->hlavicka['titulek'];
        $this->data['popis'] = $this->kontroler->hlavicka['popis'];
        $this->data['klicova_slova'] = $this->kontroler->hlavicka['klicova_slova'];
        /**
         * zde podle toho zdali je uživatel přihlášen a jeho pozice se načte do pohledu jeho návrh
         */
        if(isset($_SESSION['uzivatel'])&&($_SESSION['uzivatel']['admin']))
        {
            $this->pohled = 'navrhadmin';
        }
        else if(isset($_SESSION['uzivatel'])&&($_SESSION['uzivatel']['recenzent']))
        {
            $this->pohled = 'navrhrecenzent';
        }
        else if((isset($_SESSION['uzivatel']))&&(!$_SESSION['uzivatel']['recenzent'])&&(!$_SESSION['uzivatel']['admin']))
        {
            $this->pohled = 'navrh';
        }
        else
        {
            $this->pohled = 'navrh';
        }
    }

    /**
     * zde máme získáváme potřebnou url z prohlžeče
     * @param url načtená url
     */
    private function parsujURL($url)
    {
        /**
         * načteme podle lomítek rozdělíme na části a vratíme zpět
         */
        $naparsovanaURL = parse_url($url);
        $naparsovanaURL["path"] = ltrim($naparsovanaURL["path"], "/");
        $naparsovanaURL["path"] = trim($naparsovanaURL["path"]);

        $rozdelenaCesta = explode("/", $naparsovanaURL["path"]);

    
        return $rozdelenaCesta;
    }
    /**
     * funkce pouze předělává textovou podobu pohledu na nazev kontroler bez přípon, která je přidaná později
     * @param text rozdělená url
     */
    private function notace($text)
    {
        $veta = str_replace('-', ' ', $text);

        $veta = ucwords($veta);
        $veta = str_replace(' ', '', $veta);

        return $veta; // hotový název vracíme
    }
}
?>