<?php
use yii\db\Migration;
/**
 * Handles the creation of table `{{%task}}`.
 */
class m190220_164316_create_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('{{%task}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'description' => $this->text()->notNull(),
            'project_id' => $this->integer(),
            'executor_id' => $this->integer(),
            'started_at' => $this->integer(),
            'completed_at' => $this->integer(),
            'creator_id' => $this->integer()->notNull(),
            'updater_id' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer(),
        ]);
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('{{%task}}');
    }
}
