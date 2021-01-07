<?php
class DB
{
    private static $spojeni;

    private static $nastaveni = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
    PDO::ATTR_EMULATE_PREPARES => false,);


    public static function pripoj($host, $uzivatel, $heslo, $databaze)
    {
        self::$spojeni = @new PDO("mysql:host=$host;dbname=$databaze",
            $uzivatel,
            $heslo, 
            self::$nastaveni
        );
    }

    public static function dotazJeden($dotaz, $parametry = array())
    {
        $navrat = self::$spojeni->prepare($dotaz);
        $navrat->execute($parametry);
        return $navrat->fetch();
    }

    public static function dotazVsechny($dotaz, $parametry = array())
    {
        $navrat = self::$spojeni->prepare($dotaz);
        $navrat->execute($parametry);
        return $navrat->fetchAll();
    }

    public static function dotazSamotny($dotaz, $parametry = array())
    {
        $vysledek = self::dotazJeden($dotaz, $parametry);
        return $vysledek[0];
    }

    public static function dotaz($dotaz, $parametry = array())
    {
        $navrat = self::$spojeni->prepare($dotaz);
        $navrat->execute($parametry);
        return $navrat->rowCount();
    }

    public static function vlozUzivatele($login, $jmeno, $prijmeni, $email, $heslo)
    {
        $sql = "INSERT INTO uzivatel (login, jmeno, prijmeni, email, heslo) VALUES (?, ?, ?, ?, ?)";
        $navrat = self::$spojeni->prepare($sql);
        $navrat->execute([$login, $jmeno, $prijmeni, $email, $heslo]);
        return $navrat->rowCount();
    }

    public static function vlozClanek($titulek, $obsah, $url, $popisek, $klicova_slova, $targetfolder)
    {
        $sql = "INSERT INTO clanky (titulek, obsah, url, popisek, klicova_slova, soubor_cesta, autor) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $navrat = self::$spojeni->prepare($sql);
        $navrat->execute([$titulek, $obsah, $url, $popisek, $klicova_slova, $targetfolder, $_SESSION['uzivatel']['login']]);
        return $navrat->rowCount();
    }
    public static function vlozRecenzi($titulek, $url, $zajimavost, $pravdivost, $gramatika, $hodnoceni)
    {
        $sql = "INSERT INTO recenze (titulek, url, hodnoceni_zajimavost, hodnoceni_pravdivost, hodnoceni_gramatika, hodnoceni, autor, datum) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $navrat= self::$spojeni->prepare($sql);
        $navrat->execute([$titulek, $url, $zajimavost, $pravdivost, $gramatika, $hodnoceni, $_SESSION['uzivatel']['login'], date("Y-m-d")]);
        return $navrat->rowCount();
    }

    public static function zmen($tabulka, $hodnoty = array(), $podminka, $parametry = array())
    {
        return self::dotaz("UPDATE `$tabulka` SET `".
            implode('` = ?, `', array_keys($hodnoty)).
            "` = ? " . $podminka,
            array_merge(array_values($hodnoty), $parametry));
    }

    public static function recenzeClanek($url)
    {
        $sql = "SELECT titulek, url, hodnoceni, hodnoceni_zajimavost, hodnoceni_pravdivost, hodnoceni_gramatika, autor, datum FROM recenze WHERE url = ?";
        $navrat = self::$spojeni->prepare($sql);
        $navrat->execute([$url]);
        return $navrat->fetchAll();
    }
    public static function recenze()
    {
        $sql = "SELECT titulek, url, hodnoceni, autor, datum FROM recenze ORDER BY `datum` DESC";
        $navrat = self::$spojeni->prepare($sql);
        $navrat->execute([]);
        return $navrat->fetchAll();
    }

    public static function clankyAutor()
    {
        $sql = "SELECT clanky_id, titulek, url, popisek, publikovani FROM clanky WHERE autor = ?";
        $navrat = self::$spojeni->prepare($sql);
        $navrat->execute([$_SESSION['uzivatel']['login']]);
        return $navrat->fetchAll();
    }

    public static function smazUzivatele($id)
    {
        $sql = "DELETE FROM uzivatel WHERE uzivatel_id = ?";
        $navrat = self::$spojeni->prepare($sql);
        $navrat->execute([$id]);
        return $navrat->rowCount();
    }

    public static function vratUzivateleSeznam($login)
    {
        $sql = "SELECT uzivatel_id, login, jmeno, prijmeni, email, admin, recenzent FROM uzivatel WHERE NOT login = ? ORDER BY uzivatel_id DESC";
        $navrat = self::$spojeni->prepare($sql);
        $navrat->execute([$login]);
        return $navrat->fetchAll();
    }
}
?>