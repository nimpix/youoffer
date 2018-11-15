<?php namespace backend;

use backend\models\Users;
use Faker\Factory;

class valuesTest extends \Codeception\Test\Unit
{
    /**
     * @var \backend\UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
        $faker = Factory::create();
        $names = array();

        for($i=0;$i<20;$i++){
            $names[] = $faker->name;
        }
    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature()
    {
    
    }
}