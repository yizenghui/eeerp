<?php

namespace App\Admin\Controllers;

use App\Models\Production;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Admin;

class ProductionController extends Controller
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
            ->header('生产')
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
            ->header('生产')
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
            ->header('生产')
            ->description('编辑')
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
            ->header('生产')
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
        $grid = new Grid(new Production);

        
        $class = config('admin.database.users_model');
        $admin_arr = collect([0=>'无'])->union($class::pluck('name','id'))->all();
        $product_arr = collect([0=>'无'])->union(Product::all()->pluck('title', 'id'))->all();

        $grid->id('ID')->totalRow('合计');
        $grid->product_id('产品')->using($product_arr);

        $grid->admin_id('分配管理员')->using($admin_arr);

        $grid->total('总计生产数')->totalRow(function ($total) {
            return "<span id='total' class='text-black text-bold'>{$total}</span>";
        });
        $grid->qualified('合格数')->totalRow(function ($qualified) {
            return "<span id='qualified' class='text-green text-bold'>{$qualified}</span>";
        });
        $grid->unqualified('不合格数')->totalRow(function ($unqualified) {
            return "<span id='unqualified' class='text-danger text-bold'>{$unqualified}</span>";
        });
        $grid->batch('批次号');
        $grid->production_at('生产日期');
        $grid->created_at('Created at')->hide();
        $grid->updated_at('Updated at')->hide();


        $grid->filter(function($filter) use($admin_arr,$product_arr){

            // 去掉默认的id过滤器
            // $filter->disableIdFilter();
        
            $filter->column(1/2, function ($filter)  {

                $filter->between('production_at','生产日期')->datetime();
                $filter->like('batch','批次');
                $filter->like('detailed','详细');
                $filter->like('remark','备注');
            });
            
            $filter->column(1/2, function ($filter) use($admin_arr,$product_arr) {
                $filter->between('total', '生产总数');
                $filter->between('qualified', '合格数');
                $filter->between('unqualified', '不合格数');
                unset($admin_arr[0]);
                unset($product_arr[0]);
                $filter->in('admin_id','管理员')->checkbox($admin_arr);
                $filter->in('product_id','产品')->checkbox($product_arr);
            });
        
        });

        
        $grid->quickCreate(function (Grid\Tools\QuickCreate $create) use($admin_arr,$product_arr) {

            $admin_arr[0] = "未选择";
            $product_arr[0] = "未选择";
            $create->select('product_id','请选择产品')->options($product_arr);
            
            $create->text('admin_id', '管理员')->attribute('type','hidden')->default(Admin::user()->id);
           
            $create->integer('total','总计');
            $create->integer('qualified','合格数');
            $create->integer('unqualified','不合格数');
            $create->datetime('production_at','生产日期')->default(date('Y-m-d H:i:s'));
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
        $show = new Show(Production::findOrFail($id));

        $show->id('ID');
        
        $class = config('admin.database.users_model');
        $admin_arr = collect([0=>'无'])->union($class::pluck('name','id'))->all();
        $show->admin_id('分配管理员')->using($admin_arr);
        
        $product_arr = collect([0=>'无'])->union(Product::all()->pluck('title', 'id'))->all();
        $show->product_id('产品')->using($product_arr);
        $show->total('总计');
        $show->qualified('合格数');
        $show->unqualified('不合格数');
        $show->production_at('生产日期');
        $show->remark('备注');
        $show->detailed('详细');

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
        $form = new Form(new Production);

        $form->display('ID');
        $class = config('admin.database.users_model');
        $admin_arr = collect([0=>'无'])->union($class::pluck('name','id'))->all();
        $form->select('admin_id','分配管理员')->options($admin_arr);
        
        $product_arr = collect([0=>'无'])->union(Product::all()->pluck('title', 'id'))->all();
        $form->select('product_id','产品')->options($product_arr);

        $form->number('total','总计生产数')->default(0);
        $form->number('qualified','合格数')->default(0);
        $form->number('unqualified','不合格数')->default(0);
        $form->text('batch','批次号');
        $form->datetime('production_at','生产日期');
        $form->textarea('remark','备注');
        $form->textarea('detailed','详细');
        $form->display('created_at','Created at');
        $form->display('updated_at','Updated at');

        return $form;
    }
}
