<?php

namespace App\Http\Controllers\Library;


use App\Http\Controllers\Controller;
use App\Models\Library\Library;
use App\Models\Library\LibraryGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    //
    public function index()
    {
        $library_groups = LibraryGroup::with('child_menu_has_libraries')
//            ->where('parent_id', 0)
            ->whereHas('childMenu', function (Builder $query){
                $query->has('libraries');
            })->get();

        foreach ($library_groups as $library_group){
            $library_group->
        }



//        $library_groups = LibraryGroup::with('all_child_menu_has_libraries')
//            ->where('parent_id', 0)
//            ->whereHas('childMenu', function (Builder $query){
//                $query->has('libraries')
//                    ->orWhereHas('childMenu', function (Builder $query){
//                        $query->has('libraries');
//                });
//            })
//            ->get();

        dd($library_groups->toArray());
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


}
