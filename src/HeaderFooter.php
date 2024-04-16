<?php
class HeaderFooter {
    // metodo que crea el menu con los enlaces y el usuario de sesion actual
    public function generarMenu() {
        // creo el objeto que contendra los enlaces y texto
        $menuItems = [
            ['url' => 'deportistas.php', 'text' => 'Deportistas'],
            ['url' => 'programas.php', 'text' => 'Programas'],
            ['url' => 'about.php', 'text' => 'About'],
            // Agrega más elementos de menú según sea necesario
        ];
        // inicio el menu
        $menu = '<div >';
        $menu .= '<nav class="nav justify-content-start p-2">';
        $menu .= '<li class="nav"><img class="img-thumbnail" style="width: 50px; height: 50px" src="../logoPR.jpg"></li>';
        // por cada elemento del objeto creare una linea
        foreach ($menuItems as $item) {
            $menu .= '<li><a class="nav-link" href="' . $item['url'] . '">' . $item['text'] . '</a></li>';
        }
        $menu .= '</ul>';
        $menu .= '</nav>';
        $menu .= '</div>';
        // muestro el usuario actual y el boton de cerrar sesion
        $menu .= '<div class="d-inline-flex p-2 "><input type="text" size="15px" value="' . $_SESSION['usuario'] . '" class="form-control mr-2 bg-light text-info font-weight-bold" disabled>
                    <a href="../src/cerrar.php" class="btn btn-info mr-2">Salir</a></div>';
        return $menu;
    }

    // metodo que crea el footer
    public function generarFooter() {

        $footer = '<p style="font-size: x-small">Jorge Martinez</p>';
        $footer .= '<p style="font-size: x-small">I.E.S Politecnico Estella 2024</p>';
        return $footer;
    }
}
?>

