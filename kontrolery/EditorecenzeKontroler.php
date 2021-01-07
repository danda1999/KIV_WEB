<?php
class EditorecenzeKontroler extends Kontroler
{
    public function zpracuj($parametry)
    {
        $this->hlavicka['titulek'] = 'Recenze';

        $spravceClanku = new SpravceClanku();

        $recenze = array('titulek'=>'','hodnoceni'=>'');

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
        else if (!empty($parametry[0]))
        {
            $nactenyClanek = $spravceClanku->vratClanekRecenze($parametry[0]);
            if($nactenyClanek)
            {
                $recenze = $nactenyClanek;
            }
        }

        $this->data['recenze'] = $recenze;
        $this->pohled = 'editorecenze';

    }
}
?>