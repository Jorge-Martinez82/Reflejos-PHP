<?php
// menu.php
class Footer {
    public function generateFooter() {

        $footer = '<div class="footer fixed-bottom bg-dark text-white text-center d-flex justify-content-between p-1" style="height: 30px">
                    <p style="font-size: x-small">Jorge Martinez</p>';
        $footer .= '<p style="font-size: x-small">I.E.S Politecnico Estella 2024</p></div>';

        return $footer;
    }
}

