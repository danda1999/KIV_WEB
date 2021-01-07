<?php
class SpravceClanku
{
    public function vratClanek($url)
    {
        return DB::dotazJeden('
            SELECT `clanky_id`, `titulek`, `obsah`, `url`, `popisek`, `klicova_slova`, `soubor_cesta`
            FROM `clanky`
            WHERE `url` = ?
        ', array($url));
    }

    public function vractClankyRecenze()
    {
        return DB::dotazVsechny('
        SELECT `clanky_id`, `titulek`, `url`, `popisek`, `publikovani`
        FROM `clanky` WHERE `publikovani` = 0
        ORDER BY `clanky_id` DESC
        ');
    }

    public function vratClanekRecenze($url)
    {
        return DB::dotazJeden('
                SELECT `titulek`, `url` FROM `clanky` WHERE `url` = ?', array($url));
    }

    public function vratClankyPublikovane()
    {
        return DB::dotazVsechny('
        SELECT `clanky_id`, `titulek`, `url`, `popisek`
        FROM `clanky` WHERE `publikovani` = 1
        ORDER BY `clanky_id` DESC
        ');
    }

    public function vratClanky()
    {
        return DB::dotazVsechny('
        SELECT `clanky_id`, `titulek`, `url`, `popisek`, `publikovani`
        FROM `clanky`
        ORDER BY `clanky_id` DESC
        ');
    }

    public function autorClanky()
    {
        return DB::clankyAutor();
    }


    public function ulozClanek($id, $titulek, $obsah, $url, $popisek,$klicova_slova, $targetfolder)
    {
        if (!$id)
            DB::vlozClanek($titulek, $obsah, $url, $popisek,$klicova_slova, $targetfolder);
        else
            DB::zmen('clanky', $clanek, 'WHERE clanky_id = ?', array($id));
    }

    public function ulozRecenzi($titulek, $url, $zajimavost, $pravdivost, $gramatika, $hodnoceni)
    {
        DB::vlozRecenzi($titulek, $url, $zajimavost, $pravdivost, $gramatika, $hodnoceni);
    }

    public function publikuj($url)
    {
        DB::dotaz('
            UPDATE clanky SET publikovani = 1
            WHERE url = ?
        ', array($url));
    }

    public function odstranClanek($url)
    {
        DB::dotaz('
            DELETE FROM clanky
            WHERE url = ?
        ', array($url));
    }
    public function odstranRecenze($url)
    {
        DB::dotaz('
            DELETE FROM recenze
            WHERE url = ?
        ', array($url));
    }
    public function recenezClanku($url)
    {
        return DB::recenzeClanek($url);
    }

    public static function recenze()
    {
        return DB::recenze();
    }
}
?>