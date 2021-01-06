<?php
class AdministraceadminKontroler extends Kontroler
{
    public function zpracuj($parametry)
    {
        $this->overUzivatele();
        $this->hlavicka['titulek'] = 'Administrace';

        $spravceUzivatelu = new SpravceUzivatelu();
        if((!empty($parametry[0]))&& ($parametry[0] = 'odhlasit'))
        {
            $spravceUzivatelu->odhlas();
            $this->presmeruj('prihlaseni');
        }
        $uzivatel = $spravceUzivatelu->vratUzivatele();
        $this->data['login'] = $uzivatel['login'];
        $this->data['admin'] = $uzivatel['admin'];

        $this->pohled = 'administraceadmin';
    }
}
?>