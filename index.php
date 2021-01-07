<?php

    session_start();

    define("SERVER", "localhost");
    define("UZIVATEL", "root");
    define("HESLO","");
    define("DATABAZE", "web");

    mb_internal_encoding("UTF-8");

    function autoloadFunkce($trida)
    {
        if(preg_match('/Kontroler$/', $trida))
        {
            require("kontrolery/" . $trida . ".php");
        }
        else
        {
            require("modely/" . $trida . ".php");
        }
    }

    spl_autoload_register("autoloadFunkce");

    DB::pripoj(SERVER, UZIVATEL, HESLO, DATABAZE);
    $smerovac = new SmerovacKontroler();
    $smerovac->zpracuj(array($_SERVER['REQUEST_URI']));
    $smerovac->pohled(); 
?>