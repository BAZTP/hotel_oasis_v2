<?php
  use Core\Database;
  use Core\DatabaseException;
  
  try {
    $db = Database::getInstance();
    $personal = $db->query("
                            SELECT
                              pp.PERS_ID,
                              pp.PERS_NOM,
                              pp.PERS_APE,
                              pp.PERS_CED,
                              pp.PERS_TELF,
                              pp.PERS_EMAIL, 
                              ptc.TIP_CAR_DES 
                            FROM 
                              pers_personal pp 
                            JOIN 
                              pers_tipo_cargo ptc 
                            ON 
                              pp.TIP_CAR_ID = ptc.TIP_CAR_ID;
                          ")->fetchAll();
  } catch (\Core\DatabaseException $e) {
    die($e->getMessage());
  }

  view('auth/personal/personal.view.php', [
    'head_title' => 'personal',
    'personal' => $personal
  ]);
?>