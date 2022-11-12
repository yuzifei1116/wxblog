<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Img;
use App\Models\Img as ModelsImg;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class ImgController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Img(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('img');
            $grid->column('is_del');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new Img(), function (Show $show) {
            $show->field('id');
            $show->field('img');
            $show->field('is_del');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Img(), function (Form $form) {
            $form->display('id');
            // $form->multipleFile('img')->move('public')->sortable();
            // $form->text('is_del');

            $form->display('created_at');
            $form->display('updated_at');

            $form->multipleFile('img')->saving(function ($value) use ($form) {
                foreach ($value as $k => &$v) {
                    # code...
                    $v = env('APP_URL') . 'uploads/' . $v;
                }
                $data = json_encode($value);
                ModelsImg::create(['img'=>$data]);
            });

            $form->saved(function (Form $form, $result) {
                // 判断是否是新增操作
                if ($form->isCreating()) {
                    // 自增ID
                    $newId = $result;
                    // 也可以这样获取自增ID
                    $newId = $form->getKey();
                    
                    if (! $newId) {
                        return $form->error('数据保存失败');
                    }

                    ModelsImg::where('id',$newId)->delete();
            
                    return;
                }
            });
        });
    }
}
