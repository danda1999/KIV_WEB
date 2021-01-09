<?php
/**
 * @author Daniel Cífka
 * @version 2021-1-9
 * Tento model je pouze prostřední mezi kontrolerem a modelem pro komunikaci s databzí a jeho hlavní účelem je zpřehlednit
 * pozdější hledaní oprav v modelu přímé komunikace s databází
 */
class SpravceClanku
{
    public function vratClanek($url)
    {
        return DB::clanekJeden($url);
    }

    public function vractClankyRecenze()
    {
        return DB::clankyRecenze();
    }

    public function vratClanekRecenze($url)
    {
        return DB::clanekRecenze($url);
    }

    public function vratClankyPublikovane()
    {
        return DB::publikovaneClanky();
    }

    public function vratClanky()
    {
        return DB::adminClanky();
    }

    public function autorClanky()
    {
        return DB::clankyAutor();
    }


    public function ulozClanek($id, $titulek, $obsah, $url, $popisek,$klicova_slova, $soubor_cesta)
    {
        if (!$id)
            DB::vlozClanek($titulek, $obsah, $url, $popisek,$klicova_slova, $soubor_cesta);
        else
            DB::zmen($titulek, $obsah, $url, $popisek,$klicova_slova, $id);
    }

    public function ulozRecenzi($titulek, $url, $zajimavost, $pravdivost, $gramatika, $hodnoceni)
    {
        $zmena = 0;
        $recenzeTitulek = DB::recenzeTitulky();
        foreach($recenzeTitulek as $titulekRecenze)
        {
            if(($titulekRecenze['titulek'] == $titulek)&&($titulekRecenze['autor'] == $_SESSION['uzivatel']['login']))
            {
                DB::upravRecenzi($titulek, $zajimavost, $pravdivost, $gramatika, $hodnoceni);
                $zmena = 1;
                break;
            }
        }
        if($zmena == 0)
        {
            DB::vlozRecenzi($titulek, $url, $zajimavost, $pravdivost, $gramatika, $hodnoceni);
        }
    }

    public function publikuj($url)
    {
        DB::publikujCLanek($url);
    }

    public function odstranClanek($url)
    {
        DB::odstraneniClanek($url);
    }
    public function odstranRecenze($url)
    {
        DB::odstraneniRecenze($url);
    }
    public function recenezClanku($url)
    {
        return DB::recenzeClanek($url);
    }
}
?>