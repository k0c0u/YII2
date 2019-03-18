<?php
namespace common\services;
use common\models\Project;
use common\models\ProjectUser;
use common\models\Task;
use common\models\User;
use Yii;
use yii\base\Component;
class TaskService extends Component
{

    public function canManage(Project $project, User $user) {
        return Yii::$app->projectService->hasRole($project, $user, ProjectUser::ROLE_MANAGER);
    }

    public function canTake(Task $task, User $user) {
        $idAccessToTask = Yii::$app->projectService->hasRole(Project::findOne($task->project_id), $user, ProjectUser::ROLE_DEVELOPER);
        $isFreeTask = !($task->executor_id);
        return $idAccessToTask && $isFreeTask;
    }

    public function canComplete(Task $task, User $user) {
        return (($task->executor_id === $user->id) && !($task->completed_at));
    }

    public function takeTask(Task $task, User $user) {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $task->started_at = time();
            $task->executor_id = $user->id;
            $task->save();
            Yii::$app->session->setFlash('success', 'Task "' . $task->title . '" was take!');
            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollback();
            Yii::$app->session->setFlash('warning', 'Сomrade. Task "' . $task->title . '" was not take! Please try later. =(');
            return false;
        }
    }

    public function completeTask(Task $task) {
        $task->completed_at = time();
        Yii::$app->session->setFlash('success', 'Task "' . $task->title . '" was complete!');
        return ($task->save());
    }
}