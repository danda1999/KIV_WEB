<?php
/**
 * @author Daniel Cífka
 * @version 2021-1-9
 * Administrace kontroler dědí z abstraktního kontroleru a samostatne implementuje metodu zpravuj, která kontroluje některé parametry.
 * Např. zdali získaný argument za kontrolerem je nazev urcite funkce, ktera se má vykonnat
 * Dale zde do proměnný data ukladáme získaný data o článku, který je potřeba editovat.
 * Tento editor pracuje na stejním principu jako je editorRecenze, jelikož editorRecenze byl pouze poupraven z tohoto
 * 
 */
class EditorKontroler extends Kontroler
{
    /**
    * @param parametry argumenty v url adrese za nazvem kontroler
    */
    public function zpracuj($parametry)
    {
        
        $this->hlavicka['titulek'] = 'Editor článků';

        $spravceClanku = new SpravceClanku();

        /** Pole potřebných informací */
        $clanek = array(
            'clanky_id' => '',
            'titulek' => '',
            'obsah' => '',
            'url' => '',
            'popisek' => '',
            'klicova_slova' => '',
        );

        /**
         * ziskané informace z formuláře
         */
        if ($_POST)
        {
            $clanek_id = $_POST['clanky_id'];
            $titulek = $_POST['titulek'];
            $obsah = $_POST['obsah'];
            $url = $_POST['url'];
            $popisek = $_POST['popisek'];
            $klicova_slova = $_POST['klicova_slova'];



            $soubor_cesta = "clankypdf/";

            $soubor_cesta = $soubor_cesta . basename( $_FILES['soubor']['name']); //cesta k souboru uploadnutý na server do určité složky
            move_uploaded_file($_FILES['soubor']['tmp_name'], $soubor_cesta); //do složky pridaný konkrétní soubor


            $spravceClanku->ulozClanek($clanek_id,$titulek, $obsah, $url, $popisek,$klicova_slova, $soubor_cesta); //uložen článku do databáze
            $this->smeruj('clanek');
        }

        /**
         * Pokud je v argumentu nejaký název článku tak pokud bychom u něj neco změnili, tak se nebude přidávat, ale pouze ze uprví stavajcí
         * článek v databázi
         */
        else if (!empty($parametry[0]))
        {
            $nactenyClanek = $spravceClanku->vratClanek($parametry[0]); //ziskaní dat o článku
            if ($nactenyClanek)
            {
                $clanek = $nactenyClanek;
            }
            
        }

        $this->data['clanek'] = $clanek; //předání dat pohledu
        $this->pohled = 'editor';
    }
}
?>