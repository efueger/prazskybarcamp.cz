<?php namespace Barcamp\Talks\Facades;

use ApplicationException;
use Barcamp\Talks\Models\Category;
use Barcamp\Talks\Models\Talk;
use Barcamp\Talks\Models\Type;
use RainLab\User\Models\User;
use Str;

/**
 * Talks facade.
 */
class TalksFacade
{
    private $users;

    private $talks;

    private $categories;

    private $types;

    public function __construct(User $users, Talk $talks, Category $categories, Type $types)
    {
        $this->users = $users;
        $this->talks = $talks;
        $this->categories = $categories;
        $this->types = $types;
    }

    /**
     * Create new Talk and new User if doesn't exists.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function register(array $data)
    {
        // get category
        $category = $this->getTalkCategory($data['category']);
        if (!$category) {
            throw new ApplicationException('Vyberte prosím kategorii vaší přednášky.');
        }
        $data['category_id'] = $category->id;

        // get type
        $type = $this->getTalkType($data['type']);
        if (!$type) {
            throw new ApplicationException('Vyberte prosím typ vaší přednášky.');
        }
        $data['type_id'] = $type->id;

        // create talk
        $data['user_id'] = $data['user']->id;
        $data['name'] = $data['talkName'];
        $talk = $this->talks->create($data);

        // send email to admin

        return $talk;
    }

    /**
     * Create new user.
     *
     * @param array $data
     * @param $photo
     *
     * @return mixed
     */
    public function createUser(array $data, $photo = null)
    {
        // init
        if (isset($data['registerName'])) {
            $data['name'] = $data['registerName'];
        }

        // add each social network
        $data = array_merge($data, $this->parseSocialNetworks($data['social']));

        // create User
        $password = Str::random(24);
        $data['username'] = $data['email'];
        $data['password'] = $password;
        $data['password_confirmation'] = $password;
        $data['self_promo'] = $data['selfpromo'];
        $user = $this->users->create($data);

        // add photo to User
        if ($user && $photo) {
            $user->avatar = $photo;
            $user->save();
        }

        return $user;
    }

    /**
     * Get talk category.
     *
     * @param string $slug
     *
     * @return Category
     */
    public function getTalkCategory($slug)
    {
        return $this->categories->where('slug', $slug)->first();
    }

    /**
     * Get talk type.
     *
     * @param string $slug
     *
     * @return Type
     */
    public function getTalkType($slug)
    {
        return $this->types->where('slug', $slug)->first();
    }

    /**
     * Parse multiline string to array of social networks.
     *
     * @param string $data
     *
     * @return array
     */
    public function parseSocialNetworks($data)
    {
        $return = [];
        $lines = explode("\n", $data);

        foreach($lines as $line) {
            if (empty($line)) {
                continue;
            }

            if (mb_strpos($line, 'facebook') !== false) {
                $return['link_facebook'] = $this->makeUrl($line);

            } elseif (mb_strpos($line, 'twitter') !== false) {
                $return['link_twitter'] = $this->makeUrl($line);

            } elseif (mb_strpos($line, 'instagram') !== false) {
                $return['link_instagram'] = $this->makeUrl($line);

            } elseif (mb_strpos($line, 'linkedin') !== false) {
                $return['link_linkedin'] = $this->makeUrl($line);

            } elseif (mb_strpos($line, '.') !== false) {
                $customUrl = true;
                $return['link_web'] = $this->makeUrl($line, $customUrl);
            }
        }

        return $return;
    }

    /**
     * Make URL from string if it isn't.
     *
     * @param string $url
     * @param bool $customUrl
     *
     * @return mixed
     */
    private function makeUrl($url, $customUrl = false)
    {
        // URL ok
        if (mb_substr($url, 0, 8) === "https://" || mb_substr($url, 0, 7) === "http://") {
            return $url;
        }

        // use only HTTP for custom URL
        if ($customUrl) {
            return 'http://' . $url;
        }

        return 'https://' . $url;
    }
}
