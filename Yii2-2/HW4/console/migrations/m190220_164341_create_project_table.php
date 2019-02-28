<?php
use yii\db\Migration;
/**
 * Handles the creation of table `{{%project}}`.
 */
class m190220_164341_create_project_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('{{%project}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'description' => $this->text()->notNull(),
            'active' => $this->boolean()->notNull()->defaultValue(0),
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
        $this->dropTable('{{%project}}');
    }
}
