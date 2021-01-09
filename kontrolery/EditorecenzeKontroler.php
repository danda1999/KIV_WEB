<?php
/**
 * @author Daniel Cífka
 * @version 2021-1-9
 * Kontroler pro editor dědí z abstraktního kontroleru a samostatne implementuje metodu zpracuj, která kontroluje některé parametry.
 * Např. zdali získaný argument za kontrolerem je nazev urcite funkce, ktera se má vykonnat
 * Dale zde do proměnný data ukladáme získaný data o článku, který je třeba komentovat
 */
class EditorecenzeKontroler extends Kontroler
{
    /**
     * @param parametry argumenty v url adrese za nazvem kontroler
     */
    public function zpracuj($parametry)
    {
        $this->hlavicka['titulek'] = 'Recenze článku';

        $spravceClanku = new SpravceClanku(); // instance modelu Správce článku

        /**
         * pole o informacích, potřebný pro výpis do inputu v pohledu
         */
        $clanek = array(
            'recenze_id' => '',
            'titulek' => '',
            'url' => '',
            'hodnoceni_zajimavost' => '',
            'hodnoceni_pravdivost' => '',
            'hodnoceni_gramatika' => '',
            'hodnoceni' => '',);

        /**
         * Pokud příjde něco z editoru recenzí tak se uloží do proměný, kterí se předají modelu
         * a presmerujeme na seznam článků možných k recenzi
         */
        if($_POST)
        {
            $titulek = $_POST['titulek'];
            $url = $_POST['url'];
            $zajimavost = $_POST['zajimavost'];
            $pravdivost = $_POST['pravdivost'];
            $gramatika = $_POST['gramatika'];
            $hodnoceni = $_POST['hodnoceni'];

            $spravceClanku->ulozRecenzi($titulek, $url, $zajimavost, $pravdivost, $gramatika, $hodnoceni);
            $this->smeruj('clanek');
        }
        /**
         * Pokud je v prvním parametru za kontrolerem nějaký prametr tak podle jeho hodnoty zjistím o která članek se jedná
         * A jeho určité informace vložím do inputu v pohledu
         */
        else if (!empty($parametry[0]))
        {
            $nactenyClanek = $spravceClanku->vratClanekRecenze($parametry[0]);
            if($nactenyClanek)
            {
                $recenze = $nactenyClanek; //ziskání potřebných dat o konkrétním článku
            }
        }

        $this->data['recenze'] = $recenze;
        $this->pohled = 'editorecenze'; //pohled editoru recenze

    }
}
?>