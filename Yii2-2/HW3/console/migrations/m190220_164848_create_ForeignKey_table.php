<?php
use yii\db\Migration;
/**
 * Handles the creation of table `{{%ForeignKey}}`.
 */
class m190220_164848_create_ForeignKey_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->addForeignKey('fx_task_user_1', 'task', ['executor_id'], 'user', ['id']);
        $this->addForeignKey('fx_task_user_2', 'task', ['creator_id'], 'user', ['id']);
        $this->addForeignKey('fx_task_user_3', 'task', ['updater_id'], 'user', ['id']);
        $this->addForeignKey('fx_project_user_1', 'project', ['creator_id'], 'user', ['id']);
        $this->addForeignKey('fx_project_user_2', 'project', ['updater_id'], 'user', ['id']);
        $this->addForeignKey('fx_project-user_user', 'project_user', ['user_id'], 'user', ['id']);
        $this->addForeignKey('fx_project-user_project', 'project_user', ['project_id'], 'project', ['id']);
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropForeignKey('fx_task_user_1', 'task');
        $this->dropForeignKey('fx_task_user_2', 'task');
        $this->dropForeignKey('fx_task_user_3', 'task');
        $this->dropForeignKey('fx_project_user_1', 'project');
        $this->dropForeignKey('fx_project_user_2', 'project');
        $this->dropForeignKey('fx_project-user_user', 'project_user');
        $this->dropForeignKey('fx_project-user_project', 'project_user');
    }
}
