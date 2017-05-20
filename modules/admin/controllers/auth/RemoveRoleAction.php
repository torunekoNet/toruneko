<?php

/**
 * File: RemoveRoleAction.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/9 11:27
 * Description:
 */
class RemoveRoleAction extends RedAction
{

    public function run()
    {
        $roleId = $this->request->getQuery('auth', 0);
        $userId = $this->request->getQuery('user', 0);
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
            } else if ($role->removeUser($userId)) {
                $this->response(200, '取消角色成功');
            } else {
                $this->response(500, '取消角色失败');
            }
        } else {
            $this->response(403, '无权操作');
        }
    }
}