<?php
class UvodKontroler extends Kontroler
{
    public function zpracuj($parametry)
    {
        $this->hlavicka['titulek'] = 'Uvod';
        $this->pohled = 'uvod';
    }
}
?>