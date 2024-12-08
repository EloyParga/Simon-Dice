<?php
function pintar_circulos($col1, $col2, $col3, $col4) {
    echo '<div style="display: flex; gap: 10px;">';
        echo '<div style="width: 50px; height: 50px; border-radius: 50%; background-color: ' . $col1 . '; border: 2px solid black;"></div>';
        echo '<div style="width: 50px; height: 50px; border-radius: 50%; background-color: ' . $col2 . '; border: 2px solid black;"></div>';
        echo '<div style="width: 50px; height: 50px; border-radius: 50%; background-color: ' . $col3 . '; border: 2px solid black;"></div>';
        echo '<div style="width: 50px; height: 50px; border-radius: 50%; background-color: ' . $col4 . '; border: 2px solid black;"></div>';
    echo '</div>';
}
?>
