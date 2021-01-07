<?php
class EditorKontroler extends Kontroler
{
    public function zpracuj($parametry)
    {
        $this->hlavicka['titulek'] = 'Editor článků';

        $spravceClanku = new SpravceClanku();

        $clanek = array(
            'clanky_id' => '',
            'titulek' => '',
            'obsah' => '',
            'url' => '',
            'popisek' => '',
            'klicova_slova' => '',
        );

        if ($_POST)
        {
            $clanek_id = $_POST['clanky_id'];
            $titulek = $_POST['titulek'];
            $obsah = $_POST['obsah'];
            $url = $_POST['url'];
            $popisek = $_POST['popisek'];
            $klicova_slova = $_POST['klicova_slova'];



            $soubor_cesta = "clankypdf/";

            $soubor_cesta = $soubor_cesta . basename( $_FILES['soubor']['name']);


            $spravceClanku->ulozClanek($clanek_id,$titulek, $obsah, $url, $popisek,$klicova_slova, $targetfolder);
            $this->smeruj('clanek');
        }
        else if (!empty($parametry[0]))
        {
            $nactenyClanek = $spravceClanku->vratClanek($parametry[0]);
            if ($nactenyClanek)
            {
                $clanek = $nactenyClanek;
            }
            
        }

        $this->data['clanek'] = $clanek;
        $this->pohled = 'editor';
    }
}
?>