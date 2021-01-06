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

    public static function vlozClanek($titulek, $obsah, $url, $popisek, $klicova_slova)
    {
        $sql = "INSERT INTO clanky (titulek, obsah, url, popisek, klicova_slova) VALUES (?, ?, ?, ?, ?)";
        $navrat = self::$spojeni->prepare($sql);
        $navrat->execute([$titulek, $obsah, $url, $popisek, $klicova_slova]);
        return $navrat->rowCount();
    }
    public static function vlozRecenzi($titulek, $hodnoceni)
    {
        $sql = "INSERT INTO recenze (titulek, hodnoceni, autor, datum) VALUES (?,?, ?, ?)";
        $navrat= self::$spojeni->prepare($sql);
        $navrat->execute([$titulek, $hodnoceni, $_SESSION['uzivatel']['login'], date("Y-m-d")]);
        return $navrat->rowCount();
    }

    public static function zmen($tabulka, $hodnoty = array(), $podminka, $parametry = array())
    {
        return self::dotaz("UPDATE `$tabulka` SET `".
            implode('` = ?, `', array_keys($hodnoty)).
            "` = ? " . $podminka,
            array_merge(array_values($hodnoty), $parametry));
    }

    public static function recenzeClanek($titulek)
    {
        $sql = "SELECT titulek, hodnoceni, autor, datum FROM recenze WHERE titulek = ?";
        $navrat = self::$spojeni->prepare($sql);
        $navrat->execute([$titulek]);
        return $navrat->fetchAll();
    }
    public static function recenze()
    {
        $sql = "SELECT titulek, hodnoceni, autor, datum FROM recenze ORDER BY `datum` DESC";
        $navrat = self::$spojeni->prepare($sql);
        $navrat->execute([]);
        return $navrat->fetchAll();
    }
}
?>