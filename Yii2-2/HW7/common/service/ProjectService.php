<?php
namespace common\services;
use common\models\Project;
use common\models\User;
use yii\base\Component;
use yii\base\Event;
/**
 * Class AssignRoleEvent
 * @package common\services
 */
class AssignRoleEvent extends Event
{
    public $project;
    public $user;
    public $role;
    /**
     * @return array
     */
    public function dump() {
        return [
            'project' => $this->project->id,
            'user' => $this->user->id,
            'role' => $this->role,
        ];
    }
}
/**
 * Class ProjectService
 * @package common\services
 */
class ProjectService extends Component
{
    const EVENT_ASSIGN_ROLE = 'event_assign_role';
    //public function getRoles(Project $project, User $user) {
    //    return $project->getProjectUsers()->byUser($user->id)->select('role')->column();
    //}
    //
    //public function hasRole(Project $project, User $user, $role) {
    //    return in_array($role, $this->getRoles($project, $user));
    //}
    //
    //public function takeTask(Task $task, User $user) {
    //    $task->executor_id = $user->id;
    //    $task->started_at = time();
    //    return $task->save();
    //}
    /**
     * @param Project $project
     * @param User    $user
     * @param string  $role
     */
    public function assignRole(Project $project, User $user, string $role) {
        $event = new AssignRoleEvent();
        $event->project = $project;
        $event->user = $user;
        $event->role = $role;
        $this->trigger(self::EVENT_ASSIGN_ROLE, $event);
    }
}