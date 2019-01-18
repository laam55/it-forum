<?php

namespace App\Repositories\Eloquents;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\User;
use Carbon\Carbon;

class UserRepository implements UserRepositoryInterface
{
    protected $fillable = [
        'id',
        'username',
        'fullname',
        'email',
        'image_path',
        'address',
        'phone',
    ];

    /**
     * Specify Model class name
     */
    public function model()
    {
        return new User;
    }
    /**
     */
    public function __construct()
    {
    }

    /**
     * Retrieve all data of repository
     */
    public function all($columns = ['*'])
    {
        return $this->model()->all();
    }

    /**
     * Retrieve all data of this month only
     */
    public function getDataMonth()
    {
        return $this->model()->where('created_at', '>=', Carbon::now()->startOfMonth())->get();
    }

    /**
     * Retrieve all data of this week only
     */
    public function getDataWeek()
    {
        return $this->model()->where('created_at', '>=', Carbon::now()->startOfWeek())->get();
    }

    /**
     * Retrieve all data between two days
     */
    public function getDataBetween($start, $end)
    {
        return $this->model()
            ->whereBetween('created_at', [date('Y-m-d', $start) . ' 00:00:00', date('Y-m-d', $end) . ' 23:59:59'])
            ->get();
    }

    /**
     * Retrieve all data of repository, paginated
     */
    public function paginate($limit = null, $columns = ['*'])
    {
        $limit = is_null($limit) ? config('repository.pagination.limit', 10) : $limit;

        return $this->model()->paginate($limit, $columns);
    }
    /**
     * Find data by id
     */
    public function find($id, $columns = ['*'])
    {
        return $this->model()->findOrFail($id, $columns);
    }

    /**
     * Find data by keyword
     */
    public function findByKey($field, $keyword)
    {
        return $this->model()->where($field, 'LIKE', '%' . $keyword . '%');
    }

    /**
     * Save a new entity in repository
     */
    public function create(array $input)
    {
        return $this->model()->create($input);
    }

    /**
     * Update a entity in repository by id
     */
    public function update(array $input, $id)
    {
        $model = $this->model()->findOrFail($id);
        $model->fill($input);
        $model->save();

        return $this;
    }

    /**
     * Delete a entity in repository by id
     *
     * @param $id
     *
     * @return int
     */
    public function delete($id)
    {
        return $this->model()->destroy($id);
    }

    public function filter($input, $limit = null)
    {
        $limit = is_null($limit) ? config('constants.PAGINATION_LIMIT_USER', 4) : $limit;
        $query = $this->model()->select('*');

        if (!empty($input)) {
            if (!empty($input['username'])) {
                $query = $query->where('username', 'like', '%' . $input['username'] . '%');
            }
        }
        $query = $query->orderBy('id', 'desc')->paginate($limit);

        return $query;
    }

    public function getPostsUser($id, $limit = null)
    {
        $limit = is_null($limit) ? config('constants.PAGINATION_LIMIT_NUMBER', 16) : $limit;
        $posts = $this->model()->find($id)->posts()->with('tags')->paginate($limit);

        return $posts;
    }

    public function getAnswerUser($id, $limit = null)
    {
        $limit = is_null($limit) ? config('constants.PAGINATION_LIMIT_NUMBER', 16) : $limit;
        $answers = $this->model()->find($id)->answers()->with('post')->paginate($limit);

        return $answers;
    }

    public function saveFollow($input)
    {
        $data = [
            'user_id' => $input['user_id'],
            'followable_type' => 'App\User',
        ];

        $follow = $this->model()->find($input['target_id'])->follows()->where($data)->first();

        if (!empty($follow)) {
            $follow->delete();

            return 'unfollowed';
        } else {
            return $this->model()->find($input['target_id'])->follows()->create($data);
        }
    }
}
