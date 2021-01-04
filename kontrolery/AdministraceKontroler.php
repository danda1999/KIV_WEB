<?php
class AdministraceKontroler extends Kontroler
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
        $this->data['Login'] = $uzivatel['Login'];
        $this->data['admin'] = $uzivatel['admin'];

        $this->pohled = 'administrace';
    }
}
?>