<?php
// menu.php
class Header {
    public function generateMenu() {
        $menuItems = [
            ['url' => 'deportistas.php', 'text' => 'Deportistas'],
            ['url' => 'programas.php', 'text' => 'Programas'],
            ['url' => 'about.php', 'text' => 'About'],
            // Agrega más elementos de menú según sea necesario
        ];

        $menu = '<header>';
        $menu .= '<nav>';
        $menu .= '<ul>';
        foreach ($menuItems as $item) {
            $menu .= '<li><a href="' . $item['url'] . '">' . $item['text'] . '</a></li>';
        }
        $menu .= '</ul>';
        $menu .= '</nav>';
        $menu .= '</header>';

        return $menu;
    }
}
?>

