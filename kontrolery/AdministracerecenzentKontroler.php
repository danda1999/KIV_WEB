<?php
class AdministracerecenzentKontroler extends Kontroler
{
    public function zpracuj($parametry)
    {
        $this->hlavicka['titulek'] = 'Administrace';

        $spravceUzivatelu = new SpravceUzivatelu();
        if((!empty($parametry[0]))&& ($parametry[0] = 'odhlasit'))
        {
            $spravceUzivatelu->odhlas();
            $this->smeruj('prihlaseni');
        }
        $uzivatel = $spravceUzivatelu->vratUzivatele();
        $this->data['login'] = $uzivatel['login'];
        $this->data['recenzent'] = $uzivatel['recenzent'];

        $this->pohled = 'administracerecenzent';
    }
}
?>