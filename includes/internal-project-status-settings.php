<?php
/**
 * [0] Default, needs to be same for all.
 * To control the percentage of the done steps when to check the project.
 */
global $roles_order_status;
global $roles_order_status_2;
global $roles_order_status_default;

$roles_order_status_default = "Nytt";

$roles_order_status = [];
$roles_order_status_2 = [];
$roles_order_status_2["sale-project-management"][0] = [ "internal_status" => $roles_order_status_default, "done" => 0 ];
$roles_order_status_2["sale-project-management"][1] = [ "internal_status" => "Grovplanerad", "done" => 24,'color'=>'blue'];
$roles_order_status_2["sale-project-management"][2] = [ "internal_status" => "Preliminärplanerad", "done" => 12,'color'=>'orange' ];
$roles_order_status_2["sale-project-management"][3] = [ "internal_status" => "Detaljplanerad", "done" => 36,'color'=>'green' ];



$roles_order_status["sale-administrator"][0] = [ "internal_status" => $roles_order_status_default, "done" => 0 ];
$roles_order_status["sale-administrator"][1] = [ "internal_status" => "Offertarbete pågår", "done" => 11 ];
$roles_order_status["sale-administrator"][2] = [ "internal_status" => "Offert skickad", "done" => 22 ];
$roles_order_status["sale-administrator"][3] = [ "internal_status" => "Kund kontaktad het", "done" => 33 ];
$roles_order_status["sale-administrator"][4] = [ "internal_status" => "Accepterad order", "done" => 44 ];
$roles_order_status["sale-administrator"][5] = [ "internal_status" => "Kund kontaktad kall", "done" => 55 ];
$roles_order_status["sale-administrator"][6] = [ "internal_status" => "Övrigt att fixa - kopia", "done" => 66 ];
$roles_order_status["sale-administrator"][7] = [ "internal_status" => "Övrigt att fixa - arkiverad", "done" => 77 ];
$roles_order_status["sale-administrator"][8] = [ "internal_status" => "Offert Nekad (konkurrent)", "done" => 88 ];
$roles_order_status["sale-administrator"][9] = [ "internal_status" => "Offert Nekad (annat skäl)", "done" => 100 ];

$roles_order_status["sale-salesman"][0] = [ "internal_status" => $roles_order_status_default, "done" => 0 ];
$roles_order_status["sale-salesman"][1] = [ "internal_status" => "Offertarbete pågår", "done" => 11 ];
$roles_order_status["sale-salesman"][2] = [ "internal_status" => "Offert skickad", "done" => 22 ];
$roles_order_status["sale-salesman"][3] = [ "internal_status" => "Kund ska kontaktas - het", "done" => 33 ];
$roles_order_status["sale-salesman"][4] = [ "internal_status" => "Accepterad order", "done" => 44 ];
$roles_order_status["sale-salesman"][5] = [ "internal_status" => "Kund ska kontaktas - kall", "done" => 55 ];
$roles_order_status["sale-salesman"][6] = [ "internal_status" => "Övrigt att fixa - kopia", "done" => 66 ];
$roles_order_status["sale-salesman"][7] = [ "internal_status" => "Övrigt att fixa - arkiverad", "done" => 77 ];
$roles_order_status["sale-salesman"][8] = [ "internal_status" => "Offert Nekad (konkurrent)", "done" => 88 ];
$roles_order_status["sale-salesman"][9] = [ "internal_status" => "Offert Nekad (annat skäl)", "done" => 100 ];

$roles_order_status["sale-economy"][0] = [ "internal_status" => $roles_order_status_default, "done" => 0 ];
$roles_order_status["sale-economy"][1] = [ "internal_status" => "Förskott & Sms", "done" =>  14];
$roles_order_status["sale-economy"][2] = [ "internal_status" => "Förskott", "done" => 28 ];
$roles_order_status["sale-economy"][3] = [ "internal_status" => "Sms", "done" => 42 ];
$roles_order_status["sale-economy"][4] = [ "internal_status" => "För genomgång", "done" => 56 ];
$roles_order_status["sale-economy"][5] = [ "internal_status" => "Avvikelser", "done" => 70 ];
$roles_order_status["sale-economy"][6] = [ "internal_status" => "Att fakturera", "done" => 84 ];
$roles_order_status["sale-economy"][7] = [ "internal_status" => "Fakturerat", "done" => 100 ];

$roles_order_status["sale-technician"][0] = [ "internal_status" => $roles_order_status_default, "done" => 0 ];
$roles_order_status["sale-technician"][1] = [ "internal_status" => "Pågående", "done" => 25 ];
$roles_order_status["sale-technician"][2] = [ "internal_status" => "Pågående", "done" => 50 ];
$roles_order_status["sale-technician"][3] = [ "internal_status" => "Att kontakta", "done" => 75 ];
$roles_order_status["sale-technician"][4] = [ "internal_status" => "Beställningar skickade", "done" => 100 ];

/* $roles_order_status["sale-project-management"][0] = [ "internal_status" => $roles_order_status_default, "done" => 0 ];
$roles_order_status["sale-project-management"][1] = [ "internal_status" => "Beställningar skickade", "done" => 12 ];
$roles_order_status["sale-project-management"][2] = [ "internal_status" => "Ordererkännande mottaget", "done" => 25 ];
$roles_order_status["sale-project-management"][3] = [ "internal_status" => "Att kontakta", "done" => 37 ];
$roles_order_status["sale-project-management"][4] = [ "internal_status" => "Planerade montage", "done" => 50 ];
$roles_order_status["sale-project-management"][5] = [ "internal_status" => "Montering pågår", "done" => 62 ];
$roles_order_status["sale-project-management"][6] = [ "internal_status" => "Avvikelser", "done" => 75 ];
$roles_order_status["sale-project-management"][7] = [ "internal_status" => "Ej inlämnade montage", "done" => 87 ];
$roles_order_status["sale-project-management"][8] = [ "internal_status" => "Restmontage", "done" => 100 ]; */
$roles_order_status["sale-project-management"][0] = [ "internal_status" => $roles_order_status_default, "done" => 0 ];
$roles_order_status["sale-project-management"][1] = [ "internal_status" => "Grovplanerad", "done" => 12,'color'=>'blue'];
$roles_order_status["sale-project-management"][2] = [ "internal_status" => "Preliminärplanerad", "done" => 24,'color'=>'orange' ];
$roles_order_status["sale-project-management"][3] = [ "internal_status" => "Detaljplanerad", "done" => 36,'color'=>'green' ];
$roles_order_status["sale-project-management"][4] = [ "internal_status" => "Egenkontroll ifylld", "done" => 48 ];
$roles_order_status["sale-project-management"][5] = [ "internal_status" => "Restmontage", "done" => 60 ];
$roles_order_status["sale-project-management"][6] = [ "internal_status" => "Klart montage OK enligt order", "done" => 72 ];
$roles_order_status["sale-project-management"][7] = [ "internal_status" => "Klart montage med avvikelse/ÄTA", "done" => 84 ];
$roles_order_status["sale-project-management"][8] = [ "internal_status" => "Returnerat jobb", "done" => 100 ];

$roles_order_status["sale-sub-contractor"][0] = [ "internal_status" => $roles_order_status_default, "done" => 0 ];
$roles_order_status["sale-sub-contractor"][1] = [ "internal_status" => "Grovplanerad", "done" => 12,'color'=>'blue'];
$roles_order_status["sale-sub-contractor"][2] = [ "internal_status" => "Preliminärplanerad", "done" => 24,'color'=>'orange' ];
$roles_order_status["sale-sub-contractor"][3] = [ "internal_status" => "Detaljplanerad", "done" => 36,'color'=>'green' ];
//$roles_order_status["sale-sub-contractor"][4] = [ "internal_status" => "Egenkontroll ifylld", "done" => 48 ];
$roles_order_status["sale-sub-contractor"][4] = [ "internal_status" => "Restmontage", "done" => 60 ];
$roles_order_status["sale-sub-contractor"][5] = [ "internal_status" => "Klart montage OK enligt order", "done" => 72 ];
$roles_order_status["sale-sub-contractor"][6] = [ "internal_status" => "Klart montage med avvikelse/ÄTA", "done" => 84 ];
$roles_order_status["sale-sub-contractor"][7] = [ "internal_status" => "Returnerat jobb", "done" => 100 ];