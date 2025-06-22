<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%Track}}`.
 */
class m250614_121849_create_Track_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%Track}}', [
            'id' => $this->primaryKey(),
            'track_number' => $this->string()->notNull()->unique(),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
        $this->addColumn(
            '{{%Track}}',
            'updated_at',
            $this->timestamp()->defaultValue(null)->append('ON UPDATE CURRENT_TIMESTAMP')
        );
        $this->addColumn('{{%Track}}', 'status', "ENUM('new', 'in_progress', 'completed', 'failed', 'canceled')");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%Track}}');
    }
}
