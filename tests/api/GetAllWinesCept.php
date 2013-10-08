<?php
$I = new ApiGuy($scenario);
$I->wantTo('perform get all wines and see all my wines');
$I->sendGET('/wines');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson('{"id":"1","name":"Hello!","grapes":"Just testing","country":"Australia","region":"Victoria","year":"2010","note":"Note"}');
