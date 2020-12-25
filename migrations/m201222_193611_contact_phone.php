<?php

use yii\db\Migration;

/**
 * Class m201222_193611_contact_phone
 */
class m201222_193611_contact_phone extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('contact_phone', [
            'id' => $this->primaryKey(),
            'contact_id' => $this->integer()->notNull(),
            'phone' => $this->string(19),
        ]);

        $this->createIndex(
            'idx-contact-phone_phone',
            'contact_phone',
            'phone'
        );

        $this->addForeignKey(
            'fk-contact-phone_contact_id',
            'contact_phone',
            'contact_id',
            'contact',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-contact-phone_contact_id',
            'contact_phone'
        );

        $this->dropTable('contact_phone');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201222_193611_contact_phone cannot be reverted.\n";

        return false;
    }
    */
}
