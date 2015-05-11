<?php

use yii\db\Schema;
use yii\db\Migration;

class m150505_054532_add_column_file_comments_table extends Migration
{
    public function up()
    {
        $this->addColumn('comments','attach_file', 'text');
        return true;
    }

    public function down()
    {
        $this->dropColumn('comments','attach_file');

        return true;
    }
    
    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }
    
    public function safeDown()
    {
    }
    */
}
