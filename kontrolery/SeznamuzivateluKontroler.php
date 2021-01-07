<?php
class SeznamuzivateluKontroler extends Kontroler
{
    public function zpracuj($parametry)
    {
        $spravceUzivatelu = new SpravceUzivatelu();
        $uzivatel = $spravceUzivatelu->vratUzivatele();
        $this->data['admin'] = $uzivatel && $uzivatel['admin'];
        if((!empty($parametry[1]))&&($parametry[1] == 'odstranit'))
        {
            $spravceUzivatelu->odeberUzivatele($parametry[0]);
            $this->smeruj('seznamuzivatelu');
        }
        else
        {
            $uzivatele = $spravceUzivatelu->uzivatele();
            $this->data['uzivatele'] = $uzivatele;
            $this->pohled = 'seznamuzivatelu';
        }
    }
}