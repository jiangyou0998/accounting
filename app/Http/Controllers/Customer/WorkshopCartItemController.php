<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\WorkshopCat;
use App\Services\Order\WorkshopCartItemService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class WorkshopCartItemController extends Controller
{
    protected $workshopCartItemService;

    public function __construct(WorkshopCartItemService $workshopCartItemService)
    {
        $this->workshopCartItemService = $workshopCartItemService;
    }

    public function update(Request $request, $shopid)
    {
        $user = Auth::User();

        //除workshop外,都不能下單
        if (!$user->can('workshop')) {
            throw new AccessDeniedHttpException('權限不足');
        }

        $this->workshopCartItemService->update($request, $shopid ,$user);

    }

    //下單頁面
    public function cart(Request $request)
    {
        $user = Auth::User();
        $deptArr= ['CU' => '外客'];
        $dept = $request->dept;
        $deli_date = $request->deli_date;

        //除workshop外,都不能下單
        if ($user->can('workshop')) {
            $shopid = $request->shop;
        } else {
            throw new AccessDeniedHttpException('權限不足');
        }

        $items = $this->workshopCartItemService->getCartItemsAndCheckIsInvalid($shopid, $dept, $deli_date);
        $cats = WorkshopCat::getCatsNotExpired($deli_date , $shopid);
        $sampleItems = $this->workshopCartItemService->getSampleItemsAndCheckIsInvalid($shopid, $dept, $deli_date, count($items));
        $orderInfos = $this->workshopCartItemService->getOrderInfos($shopid , $dept, $deli_date, $deptArr[$dept]);

        return view('customer.order.cart', compact('items', 'cats', 'sampleItems', 'orderInfos'));
    }

    //ajax加載分組
    public function showGroup($catid, Request $request)
    {
        $groups = $this->workshopCartItemService->getGroups($catid, $request);

        return view('customer.order.cart_group', compact('groups'))->render();
    }

    //ajax加載產品
    public function showProduct($groupid, Request $request)
    {
        $shop_id = $request->shop_id;
        $shop_group_id = User::getShopGroupId($shop_id);
        $deli_date = $request->deli_date;

        $products = $this->workshopCartItemService->getProducts($groupid , $shop_group_id, $deli_date);
        $infos = $this->workshopCartItemService->getProductInfos($groupid);

        return view('customer.order.cart_product', compact('products','infos'))->render();
    }

}
