<?php

namespace App\Admin\Actions\Grid;

use App\Models\Supplier\Supplier;
use Dcat\Admin\Actions\Response;
use Dcat\Admin\Grid\RowAction;
use Dcat\Admin\Traits\HasPermissions;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class DeleteSupplier extends RowAction
{
    /**
     * @return string
     */
	protected $title = '刪除';

    /**
     * Handle the action request.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function handle(Request $request)
    {
        // dump($this->getKey());
        $id = $this->getKey();

        //查詢供應商已關聯產品數量
        $supplier = Supplier::query()
            ->withCount(['warehouse_products'])
            ->where('id', $id)
            ->first();

        if($supplier->warehouse_products_count > 0){
            return $this->response()
                ->error('刪除失敗，供應商存在ITEM');
        }

        if(Supplier::find($id)->delete()){
            return $this->response()
                ->success('刪除成功')
                ->refresh();
        }else{
            return $this->response()
                ->error('刪除失敗');
        }

    }

    /**
	 * @return string|array|void
	 */
	public function confirm()
	{
		 return ['確認刪除?', 'ID - '.$this->getKey()];
	}

    /**
     * @param Model|Authenticatable|HasPermissions|null $user
     *
     * @return bool
     */
    protected function authorize($user): bool
    {
        return true;
    }

    /**
     * @return array
     */
    protected function parameters()
    {
        return [];
    }
}
