<?php

namespace App\Http\Controllers\Library;


use App\Http\Controllers\Controller;
use App\Models\Library\Library;
use App\Models\Library\LibraryGroup;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
//        $id = Auth::id();
//        $groupIds = User::with('front_groups')->find($id);
//        $groupIds = User::with('front_groups')->where('id',$id)->first();
//        dump($groupIds->front_groups()->pluck('id'));
//        $temp = LibraryGroup::with('libraries')->has('libraries')->get()->toArray();
//        dump($temp);

//        $arr = LibraryGroup::all()->pluck('parent_id','id')->toArray();
//        dd($arr);

        $childIds = LibraryGroup::has('libraries')->get()->pluck('id')->toArray();
//        dd($childIds);

//        //獲取所有id(包括父級id)
//        $ids = [];
//        foreach ($childIds as $id){
//            array_push($ids,$id);
//            while($arr[$id]) {
//                $id = $arr[$id];
//                array_push($ids,$id);
//            }
//        }
//
//        $ids = array_unique($ids);

        $ids = $this->getIdsAndParentIds($childIds);

        $data = LibraryGroup::whereIn('id',$ids)->orderBy('order')->get()->toArray();

        $library_groups = [];
        if(!empty($data)){
            $library_groups = LibraryGroup::generateTree($data);
        }
//        dump($library_groups);
//        dd($ids);


//        $library_groups = $this->hasLibraries();
//        foreach ($library_groups as $key => $library_group){
//            if($library_group->allChildrenMenu->count() === 0) {
//               unset($library_groups[$key]);
//            }
//        }
//        dump($library_groups->toArray());

        return view('libraries.index',compact('library_groups'));
    }

    public function child_index($id)
    {
        $childIds = LibraryGroup::has('libraries')->get()->pluck('id')->toArray();

        $ids = $this->getIdsAndParentIds($childIds ,$id);

        //當前分類下的子分類
        $child_groups = LibraryGroup::whereIn('id', $ids)
            ->where('parent_id', $id)
            ->orderBy('order')
            ->get()
            ->pluck('title','id');

//        $libraries = Library::canView()->where('group_id',$id)->get();
//        $libraries = Library::where('group_id',$id)->canView()->get();
        $library_groups = LibraryGroup::with('libraries')
            ->where('id',$id)->first();
        $library_groups->child = $child_groups;
//        dump($library_groups->toArray());
//        dump($child_groups);
//        return 111;

        return view('libraries.child_index', compact('library_groups'));
    }

    public function search(Request $request){

        $keyword = $request->input('keyword');
        //獲取所有分組名
        $library_groups = LibraryGroup::selectOptionsWithoutMain();
        
        $libraries = Library::whereRaw('lower(name) like lower(?)', ["%{$keyword}%"])->canView()->get();

        //加入分組名
        foreach ($libraries as $library){
            $library->group_name = $library_groups[$library->group_id];
        }
//        dump($libraries->toArray());

        return view('libraries.search', compact('libraries'));
    }
//    protected function hasLibraries($nodes = [], $parentIds = [])
//    {
//        if (empty($nodes)) {
//            $nodes = LibraryGroup::with('allChildrenMenu')
//                ->where('parent_id',0)
//                ->get();
//
////            $nodes = LibraryGroup::where('parent_id',0)
////                ->get();
//        }
////        dd($nodes->toArray());
//
//        if (empty($parentIds)) {
//            $parentIds = LibraryGroup::has('libraries')->get()->pluck('id')->toArray();
//        }
//
////        dump($parentIds);
//
//        foreach ($nodes as $key => $node) {
//
//            $child = $node;
//            if(in_array($node->id,$parentIds)){
////                dump($node->title);
////                dump($node->toArray());
////                dump($node->allChildrenMenu);
////                dump('菜單-'.$node->title);
//            }else{
////                dump('不在分組-'.$node->title);
//                if($node->allChildrenMenu->count() > 0){
////                dump('遞歸-'.$node->title.$node->allChildrenMenu->count());
////                dump($nodes->toArray());
//                    $child = $this->hasLibraries($node->allChildrenMenu,$parentIds);
////                    if (empty($child)) {
////                        $nodes->forget($key);
////                    }
////                dump($child->toArray());
//                }else{
//                    $nodes->forget($key);
//                }
//            }
//
////            dump($child->toArray());
//
//
//
//
//
//        }
//
//        return $nodes;
//
//    }
    /**
     *
     *
     * @param array $childIds 所有有library的子分類id
     * @param integer $current_id 當前分類id
     *
     * @return array
     */
    private function getIdsAndParentIds($childIds, $current_id = null)
    {
        $arr = LibraryGroup::all()->pluck('parent_id', 'id')->toArray();

        //獲取所有id(包括父級id)
        $ids = [];
        foreach ($childIds as $id) {

            if ($current_id) {
                $temp = [];
                array_push($temp, $id);
                while ($arr[$id]) {

                    $id = $arr[$id];
                    array_push($temp, $id);
                    if ($id == $current_id) {
                        $ids = $temp;
                    }
                }
//                dump('id:'.$id.'---temp:');
//                dump($temp);
            } else {
                array_push($ids, $id);
                while ($arr[$id]) {
                    $id = $arr[$id];
                    array_push($ids, $id);
                }
            }

        }

        $ids = array_unique($ids);
//        dump($arr);

        return $ids;
    }
}
