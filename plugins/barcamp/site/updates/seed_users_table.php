<?php namespace VojtaSvoboda\Faq\Updates;

use File;
use RainLab\User\Models\User;
use VojtaSvoboda\Faq\Models\Faq;
use VojtaSvoboda\Faq\Updates\Classes\Seeder;
use Yaml;

class SeedUsersTable extends Seeder
{
    protected $seedFileName = '/users.yaml';

    protected $seedDirPath = '/sources';

    public function run()
    {
        $defaultSeed = __DIR__ . $this->seedDirPath . $this->seedFileName;
        $seedFile = $this->getSeedFile($defaultSeed);
        $items = Yaml::parse(File::get($seedFile));

        foreach ($items as $key => $item) {
            $item['password_confirmation'] = $item['password'];
            $user = new User();
            $user->fill($item);
            $user->save();
            $user->attemptActivation($user->activation_code);
        }
    }
}
