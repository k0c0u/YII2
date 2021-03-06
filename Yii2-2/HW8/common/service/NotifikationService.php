<?php
namespace common\services;
use Yii;
use common\models\Project;
use common\models\User;
use yii\base\Component;
/**
 * Class NotificationService
 * @package common\services
 */
class NotificationService extends Component
{
    protected $emailService;
    public function __construct(EmailInterface $emailService, array $config = []) {
        $this->emailService = $emailService;
        parent::__construct($config);
    }
    /**
     * @param User    $user
     * @param Project $project
     * @param string  $role
     */
    public function sendMail(User $user, Project $project, string $role) {
        $to = $user->email;
        $subject = "New role " . $role;
        $viewHTML = 'assignRoleToProject-html';
        $viewText = 'assignRoleToProject-text';
        $data = ['user' => $user, 'project' => $project, 'role' => $role];
        //Yii::$app->emailService->send($to, $subject, $viewHTML, $viewText, $data);
        $this->emailService->send($to, $subject, $viewHTML, $viewText, $data);
    }
}