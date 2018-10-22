<?php

namespace backend;

use backend\AcceptanceTester;


class SigninCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function loginSuccess(AcceptanceTester $I)
    {
        $I->amOnPage('/backend/web/site/login');
        $I->see('Логин');
        $I->fillField('LoginForm[username]','admin');
        $I->fillField('#loginform-password','lnmsubct6d');
        $I->click('button[name="login-button"]');
      //  $I->see('#admin-catalog');
    }
}
