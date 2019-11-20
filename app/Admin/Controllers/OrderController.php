<?php

namespace App\Admin\Controllers;

use App\Models\Order;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Admin;

class OrderController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('订单')
            ->description('列表')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('订单')
            ->description('查看')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('订单')
            ->description('修改')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('订单')
            ->description('添加')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Order);

        $grid->id('ID');

        
        $grid->total('订单总金额');
        $grid->actual('实际收到');
        $grid->discount('优惠金额');
        $grid->royalty('分成金额');
        $grid->arrears('拖欠金额');
        $grid->refund('退款金额');
        $grid->order_user('下单用户');
        $grid->order_linkman('联系人');
        $grid->order_contact('联系方式');
        $grid->execution_at('交易时间');


        $grid->created_at('Created at')->hide();
        $grid->updated_at('Updated at')->hide();

        $grid->quickCreate(function (Grid\Tools\QuickCreate $create) {
            $create->text('admin_id', '管理员')->attribute('type','hidden')->default(Admin::user()->id);
            $create->text('total','订单金额');
            $create->text('order_contact','联系方式');
            $create->datetime('execution_at','交易时间')->default(date('Y-m-d H:i:s'));

            $create->text('intro','描述');
        });
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Order::findOrFail($id));

        $show->id('ID');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Order);


        $form->display('ID');
        
        $class = config('admin.database.users_model');
        $admin_arr = collect([0=>'无'])->union($class::pluck('name','id'))->all();
        $form->select('admin_id','分配管理员')->options($admin_arr);
        $form->currency('total','订单总金额')->default(0)->symbol('￥');
        $form->currency('actual','实际收到')->default(0)->symbol('￥');
        $form->currency('discount','优惠金额')->default(0)->symbol('￥');
        $form->currency('royalty','分成金额')->default(0)->symbol('￥');
        $form->currency('arrears','拖欠金额')->default(0)->symbol('￥');
        $form->currency('refund','退款金额')->default(0)->symbol('￥');
        $form->text('order_user','下单用户');
        $form->text('order_linkman','联系人');
        $form->text('order_contact','联系方式');
        $form->text('order_address','联系地址');
        $form->datetime('execution_at','交易时间');
        $form->textarea('remark','备注');
        $form->textarea('detailed','详细');
        $form->display('created_at','Created at');
        $form->display('updated_at','Updated at');

        return $form;
    }
}
