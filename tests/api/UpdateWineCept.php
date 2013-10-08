<?php
$I = new ApiGuy($scenario);
$I->wantTo('update wine in my wine list');
$I->sendPUT('/wine/1', '{"name":"UPDATE BILLY BOOT","grapes":"Chardonnay","country":"Australia","region":"-","year":"2012","note":"Fresh, tropical fruit flavours and aromas, this Chardonnay is soft and round with a bright finish."}');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContains('{"status":"success","row_effected":"1"}');
