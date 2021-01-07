<?php
class ClanekKontroler extends Kontroler
{
    public function zpracuj($parametry)
    {
        $spravceClanku = new SpravceClanku();

        $spravceUzivatelu = new SpravceUzivatelu();
        $uzivatel = $spravceUzivatelu->vratUzivatele();
        $this->data['admin'] = $uzivatel && $uzivatel['admin'];
        if((!empty($parametry[1])) && ($parametry[1] == 'odstranit'))
        {
            $spravceClanku->odstranClanek($parametry[0]);
            $spravceClanku->odstranRecenze($parametry[0]);
            $this->smeruj('clanek');
        }
        else if (!empty($parametry[0]))
        {
            $clanek = $spravceClanku->vratClanek($parametry[0]);
            if (!$clanek)
            {
                $this->smeruj('chyba');
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
        else if ((isset($_SESSION['uzivatel']))&&($_SESSION['uzivatel']['admin']))
        {
            $clanky = $spravceClanku->vratClanky();
            $this->data['clanky'] = $clanky;
            $this->pohled = 'clankyadmin';
        }
        else if ((isset($_SESSION['uzivatel']))&&($_SESSION['uzivatel']['recenzent']))
        {
            $clanky = $spravceClanku->vractClankyRecenze();
            $this->data['clanky'] = $clanky;
            $this->pohled = 'clankyrecenzent';
        }
        else if ((isset($_SESSION['uzivatel']))&&(!$_SESSION['uzivatel']['recenzent'])&&(!$_SESSION['uzivatel']['admin']))
        {
            $clanky = $spravceClanku->autorClanky();
            $this->data['clanky'] = $clanky;
            $this->pohled = 'clankyautor';
        }
        else
        {
            $clanky = $spravceClanku->vratClankyPublikovane();
            $this->data['clanky'] = $clanky;
            $this->pohled = 'clanky';
        }
    }
}

?>