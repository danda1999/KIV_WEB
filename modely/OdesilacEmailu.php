<?php
class OdesilacEmailu
{
    public function odesli($komu, $predmet, $zprava, $od)
    {
        $hlavicka = "From: " . $od;
        $hlavicka .= "\nMIME-Version: 1.0\n";
        $hlavicka .= "Content-Type: text/html; charset=\"utf-8\"\n";
        if(!mb_send_mail($komu, $predmet, $zprava, $hlavicka))
        {
            throw new ChybaUzivatele('Email se nepodařilo odeslat.');
        }
    }

    public function odesliSAntispamem($rok, $komu, $predmet, $zprava, $od)
    {
        if($rok != date("Y"))
        {
            throw new ChybaUzivatele('Chybně vyplněný antispam.');
        }
        $this->odesli($komu, $predmet, $zprava, $od);
    }
}
?>