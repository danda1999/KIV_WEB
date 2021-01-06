<?php
class SpravceClanku
{
    public function vratClanek($url)
    {
        return DB::dotazJeden('
            SELECT `clanky_id`, `titulek`, `obsah`, `url`, `popisek`, `klicova_slova`
            FROM `clanky`
            WHERE `url` = ?
        ', array($url));
    }

    public function vratClanekRecenze($url)
    {
        return DB::dotazJeden('
                SELECT `titulek` FROM `clanky` WHERE `url` = ?', array($url));
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


    public function ulozClanek($id, $titulek, $obsah, $url, $popisek,$klicova_slova)
    {
        if (!$id)
            DB::vlozClanek($titulek, $obsah, $url, $popisek,$klicova_slova);
        else
            DB::zmen('clanky', $clanek, 'WHERE clanky_id = ?', array($id));
    }

    public function ulozRecenzi($titulek, $recenze)
    {
        DB::vlozRecenzi($titulek, $recenze);
    }

    public function publikuj($titulek)
    {
        DB::dotaz('
            UPDATE clanky SET publikovani = 1
            WHERE titulek = ?
        ', array($titulek));
    }

    public function odstranClanek($url)
    {
        DB::dotaz('
            DELETE FROM clanky
            WHERE url = ?
        ', array($url));
    }
    public function recenezClanku($titulek)
    {
        return DB::recenzeClanek($titulek);
    }

    public static function recenze()
    {
        return DB::recenze();
    }
}
?>