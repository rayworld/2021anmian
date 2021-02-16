<?php

namespace app\data\command;

use app\data\service\UserService;
use think\admin\Command;
use think\admin\Exception;
use think\console\Input;
use think\console\Output;

class UserLevel extends Command
{
    protected function configure()
    {
        $this->setName('xdata:UserLevel');
        $this->setDescription('批量重新计算用户等级');
    }

    /**
     * @param Input $input
     * @param Output $output
     * @return void
     * @throws Exception
     */
    protected function execute(Input $input, Output $output)
    {
        try {
            [$total, $count] = [$this->app->db->name('DataUser')->count(), 0];
            foreach ($this->app->db->name('DataUser')->field('id')->cursor() as $user) {
                $this->queue->message($total, ++$count, "正在计算用户 [{$user['id']}] 的等级");
                UserService::instance()->syncLevel($user['id']);
                $this->queue->message($total, $count, "完成计算用户 [{$user['id']}] 的等级", 1);
            }
        } catch (\Exception $exception) {
            $this->queue->error($exception->getMessage());
        }
    }
}