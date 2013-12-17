<?php
 return array(
     'modules' => array(
         'Application',
         'Ecrire',                  // <-- ajouter les modules (dire a ModuleManager que ce
     								//nouveau module existe)
     ),
     'module_listener_options' => array(
         'config_glob_paths'    => array(
             'config/autoload/{,*.}{global,local}.php',
         ),
         'module_paths' => array(
             './module',
             './vendor',
         ),
     ),
 );
