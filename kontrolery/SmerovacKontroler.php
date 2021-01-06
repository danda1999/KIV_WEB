<?php
class SmerovacKontroler extends Kontroler
{
    protected $kontroler;

    public function zpracuj($parametry)
    {
        $_SESSION['administrator'] = '/administrace';
        $_SESSION['home_page'] = '/uvod';
        $_SESSION['home_page2'] = 'localhost/administrace';
        $_SESSION['seznam_clanky'] = '/clanek';
        $_SESSION['kontaktovani'] = '/kontakt';
        $_SESSION['prihlaseni'] = '/prihlaseni';

        $naparsovanaURL = $this->parsujURL($parametry[0]);
        $rawUrl = parse_url($parametry[0]);
        if(isset($rawUrl['query']))
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
                //$queryParamFromLeft  . .. [0]   [1]
            }
        }
        $path = $rawUrl['path'];
        
        //HEzke url
        if(empty($naparsovanaURL[0]))
        {
            $this->presmeruj('uvod');
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
                    $this->presmeruj('uvod');
                }
            }
            else{
                $this->presmeruj('chyba');
            }
        }
        $this->kontroler->zpracuj($naparsovanaURL);


        $this->data['titulek'] = $this->kontroler->hlavicka['titulek'];
        $this->data['popis'] = $this->kontroler->hlavicka['popis'];
        $this->data['klicova_slova'] = $this->kontroler->hlavicka['klicova_slova'];
        $this->data['zpravy'] = $this->vratZpravy();
        if(isset($_SESSION['uzivatel'])&&($_SESSION['uzivatel']['admin']))
        {
            $this->pohled = 'navrhadmin';
        }
        else if(isset($_SESSION['uzivatel'])&&($_SESSION['uzivatel']['recenzent']))
        {
            $this->pohled = 'navrhadmin';
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

    private function parsujURL($url)
    {
        $naparsovanaURL = parse_url($url);
        $naparsovanaURL["path"] = ltrim($naparsovanaURL["path"], "/");
        $naparsovanaURL["path"] = trim($naparsovanaURL["path"]);

        $rozdelenaCesta = explode("/", $naparsovanaURL["path"]);

    
        return $rozdelenaCesta;
    }

    private function notace($text)
    {
        $veta = str_replace('-', ' ', $text);

        $veta = ucwords($veta);
        $veta = str_replace(' ', '', $veta);

        return $veta;
    }
}
?>