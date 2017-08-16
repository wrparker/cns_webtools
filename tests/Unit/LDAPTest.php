<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
//use App\Classes\LDAP_Autehnticator;


class LDAPTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testTestUserLDAPInfoExists()
    {
        if (env('AUTH_LDAP_ENABLED') == 1) {
            $info = \App\Classes\LDAP_authenticator::LDAPGetUserInfoForUIN(\App\Classes\LDAP_authenticator::LDAPEID2UIN('test'));
            $this->assertNotEquals(false, $info, 'Error!  LDAP lookup did not work for test.');
        }
        $this->assertTrue(true);
    }
}
