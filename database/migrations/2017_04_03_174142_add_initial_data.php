<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInitialData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Create first three tables.
            $data = array(
                array('id' => '1', 'name' => 'Super User', 'route_prefix' => 'users' ),
                array('id' => '2', 'name' => 'Funding Opportunities', 'route_prefix'=>'FundingOpportunities'),

            );
            DB::table('groups')->insert($data);


        //Create Super User.
        //Default password is admin
            $data = array(
              array('id' => 1, 'email' => 'webmaster@localhost', 'enabled' => true, 'name' => 'Super User',
                  'password' => '$2y$10$OSwT0FOe6/Sc9MQDZJdmC.IeB4p/2ttLw3Qa/PZQWmpxIAIc8B2bi', 'username' => 'admin', 'ldap_user' => false),
            );
            DB::table('users')->insert($data);


        //add super user to super user group.
            $data = array(
                array('user_id' => 1, 'group_id' => 1)
            );
            DB::table('group_user')->insert($data);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        App\Group::destroy(2);
        App\Group::destroy(1);
    }
}
