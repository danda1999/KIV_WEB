<?php
/**
 * @author Daniel Cífka
 * @version 2021-1-9
 * Tento kontroler je pouze pro výpis chyb, pokud daná url neni nalezená, nebo je špatně neco zadáno
 */
class ChybaKontroler extends Kontroler
{
    /**
     * @param parametry argumenty v url adrese za nazvem kontroler
     */
    public function zpracuj($parametry)
    {

        header("HTTP/1.0 404 Not Found");

        $this->hlavicka['titulek'] = 'Chyba 404';
        
        $this->pohled = 'chyba';
    }
}


?>