<?php
namespace frontend\tests\functional;
use frontend\tests\FunctionalTester;
class HW2Cest
{
    public function _before(FunctionalTester $I) {
    }
    public function _after(FunctionalTester $I) {
    }

    public function tryRun(FunctionalTester $I) {
        $I->amOnRoute('test/index');
        $I->see('front', 'div.container');

    }
}