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

            $spravceClanku->ulozClanek($clanek_id,$titulek, $obsah, $url, $popisek,$klicova_slova);
            $this->pridejZpravu('Článek byl úspěšně uložen.');
            $this->presmeruj('clanek');
        }
        else if (!empty($parametry[0]))
        {
            $nactenyClanek = $spravceClanku->vratClanek($parametry[0]);
            if ($nactenyClanek)
                $clanek = $nactenyClanek;
            else
                $this->pridejZpravu('Článek nebyl nalezen');
        }

        $this->data['clanek'] = $clanek;
        $this->pohled = 'editor';
    }
}
?>