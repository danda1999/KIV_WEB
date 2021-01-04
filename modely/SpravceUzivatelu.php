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

        $uzivatel = array('Login' => $login, 'Jmeno' => $jmeno, 'Prijmeni' => $prijmeni, 'Email' => $email, 'heslo' => $this->vratOtisk($heslo));
        try
        {
            DB::vloz('uzivatel', $uzivatel);
        }
        catch (PDOException $chyba)
        {
            throw new ChybaUzivatele('Uživatel s tímto jménem je již zaregistrovaný.');
        }
    }

    public function prihlas($login, $heslo)
    {
        $uzivatel = Db::dotazJeden('
            SELECT ID_Uzivatele, Login, admin, heslo
            FROM uzivatel
            WHERE Login = ?
        ', array($login));
        if (!$uzivatel || !password_verify($heslo, $uzivatel['heslo']))
            throw new ChybaUzivatele('Neplatné jméno nebo heslo.');
        $_SESSION['uzivatel'] = $uzivatel;
    }

    // Odhlásí uživatele
    public function odhlas()
    {
        unset($_SESSION['uzivatel']);
    }

    // Vrátí aktuálně přihlášeného uživatele
    public function vratUzivatele()
    {
        if (isset($_SESSION['uzivatel']))
            return $_SESSION['uzivatel'];
        return null;
    }
}
?>