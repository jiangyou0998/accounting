<?php

namespace App\Models\Library;


use Dcat\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;

class LibraryGroup extends Model
{
    use ModelTree;

    protected $table = 'library_group';

    public function childMenu() {
        return $this->hasMany($this, 'parent_id', 'id');
    }

    public function child_menu_has_libraries() {
        return $this->hasMany($this, 'parent_id', 'id')
            ->has('libraries');
    }

    public function allChildrenMenu()
    {
        return $this->childMenu()->with('allChildrenMenu');
    }

    public function all_child_menu_has_libraries() {
        return $this->child_menu_has_libraries()
            ->whereHas('libraries');
    }

    public function libraries()
    {
        return $this->hasMany(Library::class, 'group_id' , 'id');
    }

    public static function generateTree($data = [])
    {
        if(empty($data)){
            $data = self::query()->orderBy('order')->get()->toArray();
        }

//        $parentIds = LibraryGroup::has('libraries')->get()->pluck('id')->toArray();
        $items = [];
        foreach ($data as $value) {
            $items[$value['id']] = $value;
        }

        $tree = [];
        foreach ($items as $k => $v) {
            if(isset($items[$v['parent_id']])){
                $items[$v['parent_id']]['children'][] = &$items[$k];
            } else {
                $tree[] = &$items[$k];
            }
        }

//        dump($items);
        return $tree;
    }

    /**
     * Get options for Select field in form.
     * 不包括主分類的分組(parent_id = 0)
     *
     * @param \Closure|null $closure
     * @param string        $rootText
     *
     * @return array
     */
    public static function selectOptionsWithoutMain(\Closure $closure = null, $rootText = null)
    {
        $options = (new static())->withQuery($closure)->buildSelectOptionsWithoutMain();

        return collect($options)->all();
    }

    /**
     * Build options of select field in form.
     * 不包括主分類的分組(parent_id = 0)
     *
     * @param array  $nodes
     * @param int    $parentId
     * @param string $prefix
     *
     * @return array
     */
    protected function buildSelectOptionsWithoutMain(array $nodes = [], $parentId = 0, $prefix = '')
    {
        $options = [];

        if (empty($nodes)) {
            $nodes = $this->allNodes();
        }

        $titleColumn = $this->getTitleColumn();
        $parentColumn = $this->getParentColumn();

        foreach ($nodes as $node) {
            $node[$titleColumn] = $prefix.'&nbsp;'.$node[$titleColumn];

            if ($node[$parentColumn] == $parentId) {
//                $children = $this->buildSelectOptions($nodes, $node[$this->getKeyName()], $prefix.$prefix);
                $children = $this->buildSelectOptionsWithoutMain($nodes, $node[$this->getKeyName()], $node[$titleColumn].'->');

                if($parentId !== 0){
                    $options[$node[$this->getKeyName()]] = $node[$titleColumn];
                }

                if ($children) {
                    $options += $children;
                }
            }
        }

        return $options;
    }

}
