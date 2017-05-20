<?php

/**
 * File: AddGroupAction.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/9 11:28
 * Description:
 */
class AddGroupAction extends RedAction
{

    public function run()
    {
        $groupId = $this->request->getPost('group', 0);
        $userId = $this->request->getPost('user', 0);
        $userAllow = false;
        $groupAllow = false;

        $targetGroup = $this->auth->getGroupByUserId($userId);
        $myGroup = $this->auth->getGroupByUserId($this->user->getId());

        if (empty($targetGroup)) $userAllow = true;

        foreach ($myGroup as $item) {
            if ($userAllow && $groupAllow) break;

            if ($groupAllow == false) {
                if ($item->hasChild($groupId)) $groupAllow = true;
            }

            if ($userAllow == false) {
                foreach ($targetGroup as $target) {
                    $userAllow = ($item->getLft() < $target->getLft() && $target->getRgt() < $item->getRgt());
                    if ($userAllow == true) break;
                }
            }
        }

        if ($userAllow && $groupAllow) {
            $group = $this->auth->getGroupByPk($groupId);
            if ($group == false) {
                $this->response(404, '参数错误');
            } else if ($group->addUser($userId)) {
                $this->response(200, '加入用户组成功');
            } else {
                $this->response(500, '移出用户组失败');
            }
        } else {
            $this->response(403, '无权操作');
        }
    }
}