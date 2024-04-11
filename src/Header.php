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

        $menu = '<div>';
        $menu .= '<nav class="nav justify-content-start">';
        $menu .= '<ul class="nav">';
        foreach ($menuItems as $item) {
            $menu .= '<li><a class="nav-link" href="' . $item['url'] . '">' . $item['text'] . '</a></li>';
        }
        $menu .= '</ul>';
        $menu .= '</nav>';
        $menu .= '</div>';

        return $menu;
    }
}
?>

