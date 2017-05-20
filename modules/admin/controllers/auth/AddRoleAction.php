<?php

/**
 * File: AddRoleAction.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/9 11:22
 * Description:
 */
class AddRoleAction extends RedAction
{

    public function run()
    {
        $roleId = $this->request->getPost('role', 0);
        $userId = $this->request->getPost('user', 0);
        $userAllow = false;

        $targetGroup = $this->auth->getGroupByUserId($userId);
        $myGroup = $this->auth->getGroupByUserId($this->user->getId());

        if (empty($targetGroup)) $userAllow = true;

        foreach ($myGroup as $item) {
            if ($userAllow) break;
            foreach ($targetGroup as $target) {
                $userAllow = ($item->getLft() < $target->getLft() && $target->getRgt() < $item->getRgt());
                if ($userAllow) break;
            }
        }

        if ($userAllow) {
            $role = $this->auth->getRoleByPk($roleId);
            if ($role == false) {
                $this->response(404, '参数错误');
            } else if ($role->addUser($userId)) {
                $this->response(200, '赋予角色成功');
            } else {
                $this->response(500, '赋予角色失败');
            }
        } else {
            $this->response(403, '无权操作');
        }
    }
}