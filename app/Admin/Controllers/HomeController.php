<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\InfoBox;
use Encore\Admin\Widgets\Collapse;
use Encore\Admin\Widgets\Box;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\Product;
use App\Models\Production;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        
        $content->header('控制面版');
        $content->description('数据概况');

        
        $content->row(function ($row) {

            
            $inventory_total = Inventory::sum('total');

            $today_inventory_total = Inventory::where('execution_at', '>=', Carbon::now()->today())->sum('total');
          
            $row->column(3, new InfoBox('库存总计'.' (今日'.$today_inventory_total.')', 'object-ungroup', 'aqua', '/admin/inventories', $inventory_total));
           

            $order_total = Order::sum('total');

            $today_order_total = Order::where('execution_at', '>=', Carbon::now()->today())->sum('total');
          
            $row->column(3, new InfoBox('订单总计'.' (今日'.($today_order_total/100).')', 'shopping-cart', 'blue', '/admin/orders', ($order_total/100)));
           
            
            $production_total = Production::sum('total');

            $today_production_total = Production::where('production_at', '>=', Carbon::now()->today())->sum('total');
          
            $row->column(3, new InfoBox('生产总计'.' (今日'.$today_production_total.')', 'cloud-upload', 'red', '/admin/productions', $production_total));
           

//             $point_total = PointLog::where('appid', '=', Admin::user()->id)->sum('change');
//             $today_point_total = PointLog::where('appid', '=', Admin::user()->id)->where('created_at', '>=', Carbon::now()->today())->sum('change');
//             // dd($today_point_total);
            
//             $yesterday = Carbon::now()->yesterday()->format('Ymd');
//             $yesterday_visitor = Visitor::where('appid', '=', Admin::user()->id)->where('did', '=', $yesterday)->count();
//             $yesterday_visitor_rp = Visitor::where('appid', '=', Admin::user()->id)->where('did', '=', -1*$yesterday)->count();

//             $today = Carbon::now()->today()->format('Ymd');
//             $today_visitor = Visitor::where('appid', '=', Admin::user()->id)->where('did', '=', $today)->count();
//             $today_visitor_rp = Visitor::where('appid', '=', Admin::user()->id)->where('did', '=', -1*$today)->count();
//  // $row->column(3, new InfoBox('订单', 'shopping-cart', 'green', '/admin/order', $order_count));
//             $row->column(3, new InfoBox('访客统计'.' (昨天'.$yesterday_visitor.'+'.$yesterday_visitor_rp.')', 'list', '', '/admin/visitor',  $today_visitor.'+'.$today_visitor_rp));
//             $row->column(3, new InfoBox('文章', 'book', 'yellow', '/admin/article', $article_count));
//             $row->column(3, new InfoBox('积分'.' (今天'.$today_point_total.')', 'list', '', '/admin/order', $point_total));

            // $row->column(3, new InfoBox('API Use Total', 'file', 'red', '/admin/api', Admin::user()->total_quota));
        });
        return $content;
            // ->title('Dashboard')
            // ->description('Description...')
            // ->row(Dashboard::title())
            // ->row(function (Row $row) {

            //     $row->column(4, function (Column $column) {
            //         $column->append(Dashboard::environment());
            //     });

            //     $row->column(4, function (Column $column) {
            //         $column->append(Dashboard::extensions());
            //     });

            //     $row->column(4, function (Column $column) {
            //         $column->append(Dashboard::dependencies());
            //     });
            // });
    }
}
