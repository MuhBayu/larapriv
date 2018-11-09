<?php

return [
   'table_privileges' => 'privileges',
   'table_moduls' => 'privileges_moduls',
   'table_permissions' => 'privileges_permissions',

   'table_privileges_as' => 'privileges as p',
   'table_moduls_as' => 'privileges_moduls as pm',
   'table_permissions_as' => 'privileges_permissions as pp',

   'superadmin_prefix_allowed' => array(
      'privileges', 'admins'
   ),
];
