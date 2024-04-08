<?php
// menu.php
class Header {
    public function generateMenu() {
        $menuItems = [
            ['url' => 'index.php', 'text' => 'Inicio'],
            ['url' => 'about.php', 'text' => 'Acerca de'],
            ['url' => 'contact.php', 'text' => 'Contacto'],
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

