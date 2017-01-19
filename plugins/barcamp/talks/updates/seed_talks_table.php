<?php namespace Barcamp\Talks\Updates;

use Barcamp\Talks\Models\Category;
use Barcamp\Talks\Models\Talk;
use Barcamp\Talks\Updates\Classes\Seeder;
use File;
use RainLab\User\Models\User;
use Yaml;

class SeedTalksTable extends Seeder
{
    protected $seedFileName = '/talks.yaml';

    protected $seedDirPath = '/sources';

    public function run()
    {
        $defaultSeed = __DIR__ . $this->seedDirPath . $this->seedFileName;
        $seedFile = $this->getSeedFile($defaultSeed);
        $items = Yaml::parse(File::get($seedFile));

        foreach ($items as $key => $item)
        {
            // default fields
            $item['approved'] = !!$item['approved'];

            // find user
            $user = User::where('email', $item['user'])->first();
            if ($user) {
                $item['user_id'] = $user->id;
            }
            unset($item['user']);

            // find category
            $category = Category::where('slug', $item['category'])->first();
            if ($category) {
                $item['category_id'] = $category->id;
            }
            unset($item['category']);

            Talk::create($item);
        }
    }
}
