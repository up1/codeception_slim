<?php
$I = new ApiGuy($scenario);
$I->wantTo('create new wine into my wine list');
$I->sendPOST('/wines', '{"name":"BILLY BOOT","grapes":"Chardonnay","country":"Australia","region":"-","year":"2012","note":"Fresh, tropical fruit flavours and aromas, this Chardonnay is soft and round with a bright finish."}');
$I->seeResponseCodeIs(200);
$I->seeResponseContains('{"name":"BILLY BOOT","grapes":"Chardonnay","country":"Australia","region":"-","year":"2012","note":"Fresh, tropical fruit flavours and aromas, this Chardonnay is soft and round with a bright finish.","id":"2"}');
