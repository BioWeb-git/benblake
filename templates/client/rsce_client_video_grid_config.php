<?php
// templates/client/rsce_client_video_grid_config.php

return array(
    'label' => array('Grille de Vidéos (YouTube)', 'Affiche une mosaïque de vignettes vidéo avec liens YouTube.'),
    'contentCategory' => 'client',
    'standardFields' => array('cssID'),
    'fields' => array(
        'items' => array(
            'label' => array('Vidéos', 'Ajoutez les vidéos à afficher dans la grille.'),
            'elementLabel' => '%s',
            'inputType' => 'list',
            'fields' => array(
                'image' => array(
                    'label' => array('Image de couverture', 'Sélectionnez une image pour la vignette.'),
                    'inputType' => 'fileTree',
                    'eval' => array('filesOnly' => true, 'extensions' => 'jpg,jpeg,png,webp', 'fieldType' => 'radio', 'mandatory' => true),
                ),
                'title' => array(
                    'label' => array('Titre', 'Saisissez le titre de la vidéo.'),
                    'inputType' => 'text',
                    'eval' => array('mandatory' => true),
                ),
                'youtube_id' => array(
                    'label' => array('ID YouTube', 'Saisissez l\'identifiant de la vidéo YouTube (ex: Bbor3ToEHqY).'),
                    'inputType' => 'text',
                    'eval' => array('mandatory' => true),
                ),
            ),
        ),
    ),
);
