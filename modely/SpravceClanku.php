<?php
class SpravceClanku
{
    public function vratClanek($url)
    {
        return Db::dotazJeden('
            SELECT `clanky_id`, `titulek`, `obsah`, `url`, `popisek`, `klicova_slova`
            FROM `clanky`
            WHERE `url` = ?
        ', array($url));
    }

    public function vratClankyPublikovane()
    {
        return Db::dotazVsechny('
        SELECT `clanky_id`, `titulek`, `url`, `popisek`
        FROM `clanky` WHERE `publikovani` = 1
        ORDER BY `clanky_id` DESC
        ');
    }

    public function vratClanky()
    {
        return Db::dotazVsechny('
        SELECT `clanky_id`, `titulek`, `url`, `popisek`
        FROM `clanky`
        ORDER BY `clanky_id` DESC
        ');
    }


    public function ulozClanek($id, $clanek)
    {
        if (!$id)
            Db::vloz('clanky', $clanek);
        else
            Db::zmen('clanky', $clanek, 'WHERE clanky_id = ?', array($id));
    }

    public function publikuj($url)
    {
        Db::dotaz('
            UPDATE clanky SET publikovani = 1
            WHERE url = ?
        ', array($url));
    }

    public function odstranClanek($url)
    {
        Db::dotaz('
            DELETE FROM clanky
            WHERE url = ?
        ', array($url));
    }
}
?>