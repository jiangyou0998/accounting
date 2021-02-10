<?php

namespace App\Http\Controllers\Library;


use App\Http\Controllers\Controller;
use App\Models\Library\LibraryGroup;

class LibraryController extends Controller
{
    //
    public function index()
    {
//        $id = Auth::id();
//        $groupIds = User::with('front_groups')->find($id);
//        $groupIds = User::with('front_groups')->where('id',$id)->first();
//        dump($groupIds->front_groups()->pluck('id'));
//        $temp = LibraryGroup::with('libraries')->has('libraries')->get()->toArray();
//        dump($temp);

        $arr = LibraryGroup::all()->pluck('parent_id','id')->toArray();
//        dd($arr);

        $childIds = LibraryGroup::has('libraries')->get()->pluck('id')->toArray();
//        dd($childIds);

        //獲取所有id(包括父級id)
        $ids = [];
        foreach ($childIds as $id){
            array_push($ids,$id);
            while($arr[$id]) {
                $id = $arr[$id];
                array_push($ids,$id);
            }
        }

        $ids = array_unique($ids);
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
        $library_groups = LibraryGroup::with('child_menu_has_libraries')
            ->where('id', $id)
            ->get();

        dump($library_groups->toArray());
        return view('libraries.child_index',compact('library_groups'));
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
}
