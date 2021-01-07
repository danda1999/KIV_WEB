<?php
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
        $uzivatel = Db::dotazJeden('
            SELECT login, admin, heslo, recenzent
            FROM uzivatel
            WHERE login = ?
        ', array($login));
        if (!$uzivatel || !password_verify($heslo, $uzivatel['heslo']))
        {
            throw new ChybaUzivatele('Neplatné jméno nebo heslo.');
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
}
?>