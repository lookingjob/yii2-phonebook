<?php

use yii\db\Migration;

/**
 * Class m201222_174246_contact
 */
class m201222_174246_contact extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('contact', [
            'id' => $this->primaryKey(),
            'firstname' => $this->string(30)->notNull(),
            'lastname' => $this->string(30),
            'email' => $this->string(128),
            'birthday' => $this->date(),
        ]);

        $this->createIndex(
            'idx-contact-firstname',
            'contact',
            'firstname'
        );

        $this->createIndex(
            'idx-contact-lastname',
            'contact',
            'lastname'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('contact_phone');
        $this->dropTable('contact');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201222_174246_contact cannot be reverted.\n";

        return false;
    }
    */
}
