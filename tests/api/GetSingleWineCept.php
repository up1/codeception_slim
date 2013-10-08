<?php
$I = new ApiGuy($scenario);
$I->wantTo('perform get my first wine in my wine list');
$I->sendGET('/wine/1');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseIsJson('{"id":"1","name":"Hello!","grapes":"Just testing","country":"Australia","region":"Victoria","year":"2010","note":"Note"}');
