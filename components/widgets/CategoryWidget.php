<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace giicms\forum\components\widgets;

use Yii;
use yii\base\Component;
use yii\web\Application;
use yii\base\InvalidConfigException;
use giicms\forum\models\Category;

class CategoryWidget extends \yii\base\Widget
{

    public function init()
    {
        
    }

    public function getIndent($int)
    {
        if ($int > 0)
        {
            for ($index = 1; $index <= $int; $index++)
            {
                $data[] = '—';
            }
            return implode('', $data) . ' ';
        }
        else
            return '';
    }

    public function getCategories(&$data = [], $parent = NULL)
    {
        $category = Category::find()->where(['parent_id' => $parent, 'type' => 'forum'])->all();
        foreach ($category as $key => $value)
        {
            $data[] = ['id' => $value->id, 'slug' => $value->slug, 'title' => $this->getIndent($value->indent) . $value->title];
            unset($category[$key]);
            $this->getCategories($data, $value->id);
        }
        return $data;
    }

    public function run()
    {
        $categories = $this->getCategories();
        ?>
        <div class="sidebarblock">
            <h3>Categories</h3>
            <div class="divline"></div>
            <div class="blocktxt">
                <ul class="cats">
                    <?php
                    foreach ($categories as $value)
                    {
                        ?>
                        <li><a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['forum/'.$value['slug']]) ?>"><?= $value['title'] ?><span class="badge pull-right">20</span></a></li>
                            <?php
                        }
                        ?>

                </ul>
            </div>
        </div>
        <?php
    }

}
