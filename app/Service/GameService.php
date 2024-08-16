<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\Admin\User;
use App\Model\Game;
use App\Service\Admin\BaseService;
use Hyperf\Database\Model\Builder;
use Hyperf\DbConnection\Db;
use Zero0719\HyperfApi\Exception\BusinessException;

class GameService extends BaseService
{
    public function list()
    {
        $query = Game::query();

        $query->when($this->request->input('id'), function (Builder $query) {
           $query->where('id', $this->request->input('id'));
        });

        $query->when($this->request->input('name'), function (Builder $query) {
            $query->where('name', 'like', '%' . $this->request->input('name') . '%');
        });

        $count = $query->count();
        $query->select('*');
        $query->addSelect(Db::raw('FROM_UNIXTIME(created_at, "%Y-%m-%d %H:%i:%s") AS created_at'));

        $query->orderByDesc('id');
        $lists = $this->getForPage($query);

        return [
            'lists' => $lists,
            'count' => $count
        ];
    }

    public function create()
    {
        if (!Game::create([
            'name' => $this->request->input('name'),
            'created_at' => time(),
            'created_user' => User::getCurrentUserInfoFromContext()['id']
        ])) {
            throw new BusinessException('添加游戏失败');
        }
    }

    public function update()
    {
        $game = Game::findOrFail($this->request->route('id'));
        if (!$game->update([
            'name' => $this->request->input('name'),
            'updated_at' => time(),
            'updated_user' => User::getCurrentUserInfoFromContext()['id']
        ])) {
            throw new BusinessException('修改游戏失败');
        }
    }

    public function destroy()
    {
       $game = Game::findOrFail($this->request->route('id'));

       if (!$game->delete()) {
           throw new BusinessException('删除游戏失败');
       }
    }

    public function show()
    {
        $game = Game::findOrFail($this->request->route('id'));

        $game->created_at = date('Y-m-d H:i:s', $game->created_at);
        $game->updated_at = $game->updated_at ? date('Y-m-d H:i:s', $game->updated_at) : '-';

        return $game->toArray();
    }

    public function all()
    {
        return Game::select(['id', 'name'])->get()->toArray();
    }
}