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
  private $table = 'VoucherElec';

/**
 * 凭证管理
 * @auth true
 * @menu true
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
    //$query->equal('is_deleted')->dateBetween('login_at,create_at');
    //$query->like('username,contact_phone#phone,contact_mail#mail');

    // 加载对应数据列表
    $this->type = input('type', 'all');
    $query->where(['is_deleted' => 0]);

    // 列表排序并显示
    $query->order('id desc')->page();

    return $this->fetch();
  }

  /**
   * 添加凭证
   * @auth true
   * @throws \think\db\exception\DataNotFoundException
   * @throws \think\db\exception\DbException
   * @throws \think\db\exception\ModelNotFoundException
   */
  public function add() {
    $this->_applyFormToken();
    $this->_form($this->table, 'form');
  }

  /**
   * 编辑凭证
   * @auth true
   * @throws \think\db\exception\DataNotFoundException
   * @throws \think\db\exception\DbException
   * @throws \think\db\exception\ModelNotFoundException
   */
  public function edit() {
    $this->_applyFormToken();
    $this->_form($this->table, 'form');
  }

  /**
   * 删除凭证
   * @auth true
   * @throws \think\db\exception\DbException
   */
  public function remove() {
    $this->_applyFormToken();
    $this->_delete($this->table);
  }
}