<?php
declare(strict_types=1);

namespace App\Service\Admin;

use App\Model\Admin\User;
use Hyperf\Database\Model\Builder;
use Zero0719\HyperfApi\Exception\BusinessException;

class UsersService extends BaseService
{
    public function list()
    {
        $query = User::query();
        
        $query->select([
            'id', 'username', 'status', 'created_at', 'updated_at'
        ]);

        $query->when($this->request->input('username'), function (Builder $query) {
            $query->where('username', 'like', '%' . $this->request->input('username') . '%');
        });

        $count = $query->count();
        
        $lists = $this->getForPage($query);
        
        return [
            'count' => $count,
            'lists' => $lists
        ];
    }

    public function create()
    {
        if ($this->checkUserByUserName($this->request->input('username'))) {
            throw new BusinessException('用户已存在');
        }

        if (!User::create($this->request->all())) {
            throw new BusinessException('添加失败');
        }
    }

    public function checkUserByUserName(string $username)
    {
        return boolval(User::where('username', $username)->first());
    }
    
    public function update()
    {
        $user = User::findOrFail($this->request->route('id'));

        if ($user->username != $this->request->input('username') && $this->checkUserByUserName($this->request->input('username'))) {
            throw new BusinessException('用户名已存在');
        }

        if (!$user->update(array_filter($this->request->all(), function ($val) {
            return !empty($val);
        }))) {
            throw new BusinessException('修改失败');
        }
    }
    
    public function destroy()
    {
        $user = User::findOrFail($this->request->route('id'));
        
        if (!$user->delete()) {
            throw new BusinessException('删除失败');
        }
    }

    public function show()
    {
        $user = User::select([
            'id',
            'username',
            'status',
            'created_at',
            'updated_at'
        ])->findOrFail($this->request->route('id'));

        return $user->toArray();
    }

    public function changeStatus()
    {
        $user = User::findOrFail($this->request->route('id'));

        if ($this->request->route('id') == 1) {
            throw new BusinessException('不允许对系统用户进行该操作');
        }

        $user->status = $this->request->input('status');
        if (!$user->save()) {
            throw new BusinessException('更改状态失败');
        }
    }


    public function roles()
    {
        $user = User::with('roles')->findOrFail($this->request->route('id'));
        $roles = $user->roles->toArray();
        return $roles;
    }
}