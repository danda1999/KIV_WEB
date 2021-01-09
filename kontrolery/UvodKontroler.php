<?php
/**
 * @author Daniel Cífka
 * @version 2021-1-9
 * kontroler pro úvod pouze volá pohled uvodu, kde je uvítací text pro uživatele
 */
class UvodKontroler extends Kontroler
{
    /**
    * @param parametry argumenty v url adrese za nazvem kontroler
    */
    public function zpracuj($parametry)
    {
        $this->hlavicka['titulek'] = 'Úvod';
        $this->pohled = 'uvod';
    }
}
?>