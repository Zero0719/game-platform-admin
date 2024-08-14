<?php
declare(strict_types=1);

namespace App\Service\Admin;

use App\Model\Admin\Permission;
use App\Model\Admin\Role;
use App\Model\Admin\Role as AdminRoles;
use Hyperf\Database\Model\Builder;
use Zero0719\HyperfApi\Exception\BusinessException;

class RolesService extends BaseService
{
    public function list()
    {
        $query = AdminRoles::query();

        $query->select([
            'id', 'name', 'flag', 'status', 'created_at', 'updated_at'
        ]);

        $query->when('name', function (Builder $query) {
            $query->where('name', 'like', '%' . $this->request->input('name') . '%');
        });

        $query->when('flag', function (Builder $query) {
            $query->where('flag', 'like', '%' . $this->request->input('flag') . '%');
        });

        $count = $query->count();
        $lists = $this->getForPage($query);
        
        return [
            'lists' => $lists,
            'count' => $count
        ];
    }

    public function create()
    {
        if (!AdminRoles::create($this->request->all())) {
            throw new BusinessException('添加失败');
        }
    }
    
    public function update()
    {
        $role = AdminRoles::findOrFail($this->request->route('id'));
        
        if (!$role->update($this->request->all())) {
            throw new BusinessException('修改失败');
        }
    }
    
    public function show()
    {
        $role = AdminRoles::findOrFail($this->request->route('id'));
        
        return $role->toArray();
    }
    
    public function destroy()
    {
        $role = AdminRoles::findOrFail($this->request->route('id'));
        
        if (!$role->delete()) {
            throw new BusinessException('删除失败');
        }
    }

    public function all()
    {
        return AdminRoles::select(['id', 'name', 'status'])->get()->toArray();
    }

    public function permissions()
    {
        $role = Role::with('permissions')->findOrFail($this->request->route('id'));
        return $role->permissions->toArray();
    }
}