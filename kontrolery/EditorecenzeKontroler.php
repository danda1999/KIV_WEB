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
            $hodnoceni = $_POST['hodnoceni'];

            $spravceClanku->ulozRecenzi($titulek, $hodnoceni);
            $this->pridejZpravu('Recenze byla uložena');
            $this->presmeruj('clanek');
        }
        else if (!empty($parametry[0]))
        {
            $nactenyClanek = $spravceClanku->vratClanekRecenze($parametry[0]);
            if($nactenyClanek)
            {
                $recenze = $nactenyClanek;
            }
            else
            {
                $this->pridejZpravu('Článek pro recenzi nebyl nalezen');
            }
        }

        $this->data['recenze'] = $recenze;
        $this->pohled = 'editorecenze';

    }
}
?>