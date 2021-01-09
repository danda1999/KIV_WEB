<?php
/**
 * @author Daniel Cífka
 * @version 2021-1-9
 * Tento model je pouze prostřední mezi kontrolerem a modelem pro komunikaci s databzí a jeho hlavní účelem je zpřehlednit
 * pozdější hledaní oprav v modelu přímé komunikace s databází
 */
class SpravceUzivatelu
{
    public function vratOtisk($heslo)
    {
        return password_hash($heslo, PASSWORD_DEFAULT);
    }

    public function registruj($login, $jmeno, $prijmeni, $email, $heslo, $kontrolaHesla,$rok)
    {
        if($rok != date('Y'))
        {
            throw new ChybaUzivatele('Chybně vyplněný antispam.');
        }
        if($heslo != $kontrolaHesla)
        {
            throw new ChybaUzivatele('Heslo nesouhlasí.');
        }

        try
        {
            DB::vlozUzivatele($login, $jmeno, $prijmeni, $email, $this->vratOtisk($heslo));
        }
        catch (PDOException $chyba)
        {
            throw new ChybaUzivatele('Uživatel s tímto jménem je již zaregistrovaný.');
        }
    }

    public function prihlas($login, $heslo)
    {
        $uzivatel = Db::vratUzivatelInfo($login);
        if (!$uzivatel || !password_verify($heslo, $uzivatel['heslo']))
        {
            
        }
        else
        {
            $_SESSION['uzivatel'] = $uzivatel;
        }
    }

    public function odhlas()
    {
        unset($_SESSION['uzivatel']);
    }

    public function vratUzivatele()
    {
        if (isset($_SESSION['uzivatel']))
            return $_SESSION['uzivatel'];
        return null;
    }

    public function odeberUzivatele($id)
    {
        DB::smazUzivatele($id);
    }

    public function uzivatele()
    {
        return DB::vratUzivateleSeznam($_SESSION['uzivatel']['login']);
    }
    public function zmenaHesla($noveHeslo)
    {
        DB::zmeneneHeslo($this->vratOtisk($noveHeslo));
    }

    public function opravneniRecenzent($id)
    {
        DB::recenzent($id);
    }
    public function opravneniAutor($id)
    {
        DB::autor($id);
    }
}
?>