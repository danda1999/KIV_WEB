<?php
/**
 * @author Daniel Cífka
 * @version 2021-1-9
 * Zde je model, který přimo komunikue s databzí pomocí komunikace PDO
 * Jelikož jsou nazvy funckí velmi výstižné a tak podle nich lze odvodit co je jeich funckí
 * SELECT ... příkaz select vrací políčka uvedený za ním z tabulky co je za příkazem FROM, pokud je zde i podmínka, tak vrací pouze
 * data obsahujcí tuto podmínku
 * UPDATE .... nahrazuje stavajcí hodnotou nějakou novou, která je předaná nebo definovaná
 * DELETE ..... odstraní řádek obsahujcí předanou informaci
 */
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

    public static function clanekJeden($url)
    {
        $sql = "SELECT clanky_id, titulek, obsah, url, popisek, klicova_slova, soubor_cesta FROM clanky WHERE url = ?"; 
        $navrat = self::$spojeni->prepare($sql);
        $navrat->execute([$url]);
        return $navrat->fetch();
    }

    public static function clankyRecenze()
    {
        $sql = "SELECT clanky_id, titulek, url, popisek, publikovani FROM clanky WHERE publikovani = 0";
        $navrat = self::$spojeni->prepare($sql);
        $navrat->execute([]);
        return $navrat->fetchAll();
    }

    public static function clanekRecenze($url)
    {
        $sql = "SELECT titulek, url FROM clanky WHERE url = ?";
        $navrat = self::$spojeni->prepare($sql);
        $navrat->execute([$url]);
        return $navrat->fetch();
    }

    public static function publikovaneClanky()
    {
        $sql = "SELECT clanky_id, titulek, url, popisek FROM clanky WHERE publikovani = 1";
        $navrat = self::$spojeni->prepare($sql);
        $navrat->execute([]);
        return $navrat->fetchAll();
    }

    public static function adminClanky()
    {
        $sql = "SELECT clanky_id, titulek, url, popisek, publikovani FROM clanky ORDER BY clanky_id DESC";
        $navrat = self::$spojeni->prepare($sql);
        $navrat->execute([]);
        return $navrat->fetchAll();
    }

    public static function vlozUzivatele($login, $jmeno, $prijmeni, $email, $heslo)
    {
        $sql = "INSERT INTO uzivatel (login, jmeno, prijmeni, email, heslo) VALUES (?, ?, ?, ?, ?)";
        $navrat = self::$spojeni->prepare($sql);
        $navrat->execute([$login, $jmeno, $prijmeni, $email, $heslo]);
        return $navrat->rowCount();
    }

    public static function vlozClanek($titulek, $obsah, $url, $popisek, $klicova_slova, $soubor_cesta)
    {
        $sql = "INSERT INTO clanky (titulek, obsah, url, popisek, klicova_slova, soubor_cesta, autor) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $navrat = self::$spojeni->prepare($sql);
        $navrat->execute([$titulek, $obsah, $url, $popisek, $klicova_slova, $soubor_cesta, $_SESSION['uzivatel']['login']]);
        return $navrat->rowCount();
    }
    public static function vlozRecenzi($titulek, $url, $zajimavost, $pravdivost, $gramatika, $hodnoceni)
    {
        $sql = "INSERT INTO recenze (titulek, url, hodnoceni_zajimavost, hodnoceni_pravdivost, hodnoceni_gramatika, hodnoceni, autor, datum) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $navrat= self::$spojeni->prepare($sql);
        $navrat->execute([$titulek, $url, $zajimavost, $pravdivost, $gramatika, $hodnoceni, $_SESSION['uzivatel']['login'], date("Y-m-d")]);
        return $navrat->rowCount();
    }

    public static function zmen($titulek, $obsah, $url, $popisek, $klicova_slova, $id)
    {
        $sql = "UPDATE clanky SET titulek = ?, url = ?, popisek = ?, klicova_slova = ?, obsah = ? WHERE clanky_id = ?";
        $navrat = self::$spojeni->prepare($sql);
        $navrat->execute([$titulek,  $url, $popisek, $klicova_slova, $obsah, $id]);
        return $navrat->rowCount();
    }

    public static function recenzeClanek($url)
    {
        $sql = "SELECT titulek, url, hodnoceni, hodnoceni_zajimavost, hodnoceni_pravdivost, hodnoceni_gramatika, autor, datum FROM recenze WHERE url = ?";
        $navrat = self::$spojeni->prepare($sql);
        $navrat->execute([$url]);
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
    public static function vratUzivatelInfo($login)
    {
        $sql = "SELECT uzivatel_id, login, jmeno, prijmeni, email, heslo, admin, recenzent FROM uzivatel WHERE login = ?";
        $navrat = self::$spojeni->prepare($sql);
        $navrat->execute([$login]);
        return $navrat->fetch();
    }

    public static function publikujClanek($url)
    {
        $sql = "UPDATE clanky SET publikovani = 1 WHERE url = ?";
        $navrat = self::$spojeni->prepare($sql);
        $navrat->execute([$url]);
        return $navrat->rowCount();
    }
    public static function odstraneniClanek($url)
    {
        $sql = "DELETE FROM clanky WHERE url = ?";
        $navrat = self::$spojeni->prepare($sql);
        $navrat->execute([$url]);
        return $navrat->rowCount();
    }
    public static function odstraneniRecenze($url)
    {
        $sql = "DELETE FROM recenze WHERE url = ?";
        $navrat = self::$spojeni->prepare($sql);
        $navrat->execute([$url]);
        return $navrat->rowCount();
    }

    public static function recenzeTitulky()
    {
        $sql = "SELECT titulek FROM recenze";
        $navrat = self::$spojeni->prepare($sql);
        $navrat->execute([]);
        return $navrat->fetchAll();
    }

    public static function upravRecenzi($titulek, $zajimavost, $pravdivost, $gramatika, $hodnoceni)
    {
        $sql = "UPDATE recenze SET hodnoceni_zajimavost = ?, hodnoceni_pravdivost = ?, hodnoceni_gramatika = ?, hodnoceni = ? WHERE titulek = ?";
        $navrat = self::$spojeni->prepare($sql);
        $navrat->execute([$zajimavost, $pravdivost, $gramatika, $hodnoceni, $titulek]);
        return $navrat->rowCount();
    }

    public static function zmeneneHeslo($noveHeslo)
    {
        $sql = "UPDATE uzivatel SET heslo = ? WHERE login = ?";
        $navrat = self::$spojeni->prepare($sql);
        $navrat->execute([$noveHeslo, $_SESSION['uzivatel']['login']]);
        return $navrat->rowCount();
    }

    public static function recenzent($id)
    {
        $sql = "UPDATE uzivatel SET recenzent = 1 WHERE uzivatel_id = ?";
        $navrat = self::$spojeni->prepare($sql);
        $navrat->execute([$id]);
        return $navrat->rowCount();
    }
    public static function autor($id)
    {
        $sql = "UPDATE uzivatel SET recenzent = 0 WHERE uzivatel_id = ?";
        $navrat = self::$spojeni->prepare($sql);
        $navrat->execute([$id]);
        return $navrat->rowCount();
    }
}
?>