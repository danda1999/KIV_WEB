<?php
    abstract class Kontroler
    {
        protected $data = array();
        protected $pohled = "";
        protected $hlavicka = array('titulek' => '', 'klicova_slova' => '', 'popis' => '');

        abstract function zpracuj($parametry);

        public function pohled()
        {
            if($this->pohled)
            {
                extract($this->xss($this->data));
                extract($this->data, EXTR_PREFIX_ALL, "");
                require("pohledy/" . $this->pohled . ".phtml");
            }
        }

        public function smeruj($url)
        {
            header("Location: /$url");
            header("Connection: close");
            exit;
        }

        private function xss($x = null)
        {
            if(!isset($x))
            {
                return null;
            }
            elseif (is_string($x))
            {
                return htmlspecialchars($x, ENT_QUOTES);
            }
            elseif(is_array($x))
            {
                foreach($x as $k => $v)
                {
                    $x[$k] = $this->xss($v);
                }
                return $x;
            }
            else
            {
                return $x;
            }
        }

        public function overUzivatele($admin = false, $recenzent = false)
        {
            $spravceUzivatelu = new SpravceUzivatelu();
            $uzivatel = $spravceUzivatelu->vratUzivatele();
            if (!$uzivatel || ($admin && !$uzivatel['admin']))
            {
                $this->smeruj('prihlaseni');
            }
        }
    }
?>