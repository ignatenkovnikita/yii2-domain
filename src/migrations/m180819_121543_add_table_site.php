<?php

use yii\db\Migration;

/**
 * Class m180819_121543_add_table_site
 */
class m180819_121543_add_table_site extends Migration
{

    const TABLE_SITE_DOMAIN = '{{%site_domain}}';


    

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(self::TABLE_SITE_DOMAIN, [
            'id' => $this->primaryKey(),
            'site_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'is_primary' => $this->boolean()->defaultValue(false),
        ], $tableOptions);


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE_SITE_DOMAIN);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180819_121543_add_table_site cannot be reverted.\n";

        return false;
    }
    */
}
