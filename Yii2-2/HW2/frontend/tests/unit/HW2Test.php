<?php
namespace frontend\tests;
use common\models\LoginForm;
use frontend\models\ContactForm;
class HW2Test extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;
    protected function _before() {
    }
    protected function _after() {
    }
    // tests
    public function testRun() {
        $testBoolean = true;
        $this->assertTrue($testBoolean, 'Сравнение с true');
        $testEqual = 24;
        $this->assertEquals(24, $testEqual, 'равно ожидаемому значению 24');
        $this->assertLessThan(107, $testEqual, 'меньше ожидаемого значения 107');
        $username = 'xxx';
        $model = new LoginForm();
        $model->setAttributes(['username' => $username,]);
        $this->assertAttributeEquals($username, 'username', $model);
        $arr = [
            'first' => 'xx',
            'second' => 'xx1',
        ];
        $this->assertArrayHasKey('first', $arr);
    }
}