<?php

namespace app\index\controller;

use think\admin\Controller;

/**
 * 生成用户凭证
 * Class Voucher
 * @package app\index\controller
 */
class Voucher extends Controller {

  /**
   * 绑定数据表
   * @var string
   */
  private $table = 'SystemUser';

/**
 * 系统用户管理
 * @throws \think\db\exception\DataNotFoundException
 * @throws \think\db\exception\DbException
 * @throws \think\db\exception\ModelNotFoundException
 */
  public function index() {

    //把要输出的饿变量放入数组
    $data['total_amount']  = 888;
    $data['total_amount1'] = 999;
    $this->assign('data', $data);

    $this->title = '电费分摊凭证管理';
    $query       = $this->_query($this->table);
    $query->equal('status')->dateBetween('login_at,create_at');
    $query->like('username,contact_phone#phone,contact_mail#mail');

    // 加载对应数据列表
    $this->type = input('type', 'all');
    $query->where(['is_deleted' => 0, 'status' => 1]);

    // 列表排序并显示
    $query->order('sort desc,id desc')->page();

    return $this->fetch();
  }

  /**
   * 添加系统用户
   * @throws \think\db\exception\DataNotFoundException
   * @throws \think\db\exception\DbException
   * @throws \think\db\exception\ModelNotFoundException
   */
  public function add() {
    $this->_applyFormToken();
    $this->_form($this->table, 'form');
  }
}