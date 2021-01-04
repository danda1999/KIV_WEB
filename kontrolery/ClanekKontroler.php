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
            $this->overUzivatele(true);
            $spravceClanku->odstranClanek($parametry[0]);
            $this->pridejZpravu('Članek byl uspěšně odstraněn');
            $this->presmeruj($_SESSION['home_page2']);
        }
        else if((!empty($parametry[1])) && ($parametry[1] == 'publikuj'))
        {
            $this->overUzivatele(true);
            $spravceClanku->publikuj($parametry[0]);
            $this->pridejZpravu('Članek byl uspěšně publikovan');
            $this->presmeruj('claneky');
        }
        else if (!empty($parametry[0]))
        {
            // Získání článku podle URL
            $clanek = $spravceClanku->vratClanek($parametry[0]);
            // Pokud nebyl článek s danou URL nalezen, přesměrujeme na ChybaKontroler
            if (!$clanek)
                $this->presmeruj('chyba');

            // Hlavička stránky
            $this->hlavicka = array(
                'titulek' => $clanek['titulek'],
                'klicova_slova' => $clanek['klicova_slova'],
                'popis' => $clanek['popisek'],
            );

            // Naplnění proměnných pro šablonu
            $this->data['titulek'] = $clanek['titulek'];
            $this->data['obsah'] = $clanek['obsah'];

            // Nastavení šablony
            $this->pohled = 'clanek';
        }
        else if ($_SESSION['uzivatel']['admin'])
        {
            $clanky = $spravceClanku->vratClanky();
            $this->data['clanky'] = $clanky;
            $this->pohled = 'clankyadmin';
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