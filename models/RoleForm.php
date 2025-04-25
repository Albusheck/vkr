<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\rbac\Item;
use app\models\User;

class RoleForm extends Model
{
    public $userId;
    public $roleName;

    // Список всех пользователей и ролей
    public function getUsers()
    {
        return ArrayHelper::map(User::find()->all(), 'id', 'email'); // Возвращаем список пользователей
    }

    public function getRoles()
    {
        $auth = Yii::$app->authManager;
        $roles = $auth->getRoles();
        return ArrayHelper::map($roles, 'name', 'name');
    }

    // Назначение роли
    public function assignRole()
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($this->roleName);
        $user = User::findOne($this->userId);

        if ($role && $user) {
            $auth->assign($role, $user->id);
            return true;
        }

        return false;
    }

    // Снятие роли
    public function revokeRole()
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($this->roleName);
        $user = User::findOne($this->userId);

        if ($role && $user) {
            $auth->revoke($role, $user->id);
            return true;
        }

        return false;
    }

    public function rules()
    {
        return [
            [['userId', 'roleName'], 'required'],
            ['roleName', 'in', 'range' => array_keys($this->getRoles())],
            ['userId', 'in', 'range' => array_keys($this->getUsers())],
        ];
    }

    public static function getUsersWithRoles()
    {
        $users = User::find()->all();
        $authManager = Yii::$app->authManager;

        $result = [];

        foreach ($users as $user) {
            $roles = $authManager->getRolesByUser($user->id);
            $result[] = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'roles' => array_keys($roles),
            ];
        }

        return $result;
    }
}
