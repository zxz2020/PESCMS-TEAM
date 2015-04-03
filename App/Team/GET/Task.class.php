<?php

namespace App\Team\GET;

/**
 * 部门方法
 */
class Task extends Content {

    /**
     * 部门添加/编辑
     */
    public function action() {
        //列出用户
        $userList = \Model\Content::listContent('user');
        $this->assign('user', $userList);
        foreach ($userList as $key => $value) {
            //获取本部门的用户
            if ($value['user_department_id'] == $_SESSION['team']['user_department_id']) {
                $localUser[$value['user_id']] = $value['user_name'];
            }
            //将所有用户放到一个以用户ID的一维数组，方便查找
            $findUser[$value['user_id']] = $value['user_name'];
        }
        $this->assign('localUser', $localUser);
        $this->assign('findUser', $findUser);
        //列出部门
        foreach (\Model\Content::listContent('department') as $key => $value) {
            $department[$value['department_id']] = $value['department_name'];
        }
        $this->assign('department', $department);
        parent::action();
    }

    public function my() {
        $page = new \Expand\Team\Page;
        $total = count(\Model\Content::listContent('task', array('task_user_id' => $_SESSION['team']['user_id']), 'task_user_id = :task_user_id'));
        $count = $page->total($total);
        $page->handle();
        $list = \Model\Content::listContent('task', array('task_user_id' => $_SESSION['team']['user_id']), 'task_user_id = :task_user_id', 'task_id desc', "{$page->firstRow}, {$page->listRows}");
        $show = $page->show();
        $this->assign('page', $show);
        $this->assign('list', $list);
        $this->assign('title', \Model\Menu::getTitleWithMenu());
        $this->layout();
    }

}