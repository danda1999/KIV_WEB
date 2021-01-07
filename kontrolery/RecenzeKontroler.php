<?php
class RecenzeKontroler extends Kontroler
{
    public function zpracuj ($parametry)
    {
        $spravceClanku = new SpravceClanku();

        $spravceUzivatele = new SpravceUzivatelu();
        $uzivatel = $spravceUzivatele->vratUzivatele();
        $this->data['admin'] = $uzivatel && $uzivatel['admin'];

        if((!empty($parametry[1])) && ($parametry[1] == 'publikuj'))
        {
            $this->overUzivatele(true);
            $spravceClanku->publikuj($parametry[0]);
            $this->smeruj('clanek');
        }
        if (!empty($parametry[0]))
        {
            $recenze = $spravceClanku->recenezClanku($parametry[0]);
            if(!$recenze)
            {
                $this->smeruj('chyba');
            }

            $this->hlavicka = array('titulek' => $parametry[0],'klicova_slova' => $parametry[0],'popis' => $parametry[0]);

            $this->data['recenze'] = $recenze;
            $this->pohled = 'recenzetitulek';
            
        }
        else
        {
            $recenze = $spravceClanku->recenze();
            $this->data['recenze'] = $recenze;
            $this->pohled = 'recenze';
        }
    }
}