<?php

use Illuminate\Database\Seeder;
use App\ShopSetting;

class LatestCollectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {	
        $lc = new ShopSetting;
        $lc->option_name = 'lcdata';
        $lc->url = '#';
        $lc->option1 = 'Title';
        $lc->option2 = 'Shop Now';
        $lc->text = 'Lorem ipsum dolor sit amet, consectetur adipiscing magna. Mauris sed coqut odio.';
        $lc->save();

        $lc = new ShopSetting;
        $lc->option_name = 'lcdata';
        $lc->url = '#';
        $lc->option1 = 'Title';
        $lc->option2 = 'Shop Now';
        $lc->text = 'Lorem ipsum dolor sit amet, consectetur adipiscing magna. Mauris sed coqut odio.';
        $lc->save();
    }
}
