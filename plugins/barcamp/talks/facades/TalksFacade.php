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

        // create User
        $password = Str::random(24);
        $user = $this->users->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $data['email'],
            'password' => $password,
            'password_confirmation' => $password,
            'phone' => $data['phone'],
            'self_promo' => $data['selfpromo'],
        ]);

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
    private function getTalkCategory($slug)
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
    private function getTalkType($slug)
    {
        return $this->types->where('slug', $slug)->first();
    }
}
