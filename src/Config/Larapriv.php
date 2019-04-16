<?php

return [
   'table_privileges' => 'privileges',
   'table_moduls' => 'privileges_moduls',
   'table_permissions' => 'privileges_permissions',

   'table_privileges_alias' => 'privileges as p',
   'table_moduls_alias' => 'privileges_moduls as pm',
   'table_permissions_alias' => 'privileges_permissions as pp',

   'excluded_prefix' => array(
      'privileges', 'admins'
   ),
];
