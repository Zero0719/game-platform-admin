<?php
declare(strict_types=1);

namespace App\Service\Admin;

use App\Model\Admin\Log;
use Hyperf\Database\Model\Builder;
use Hyperf\DbConnection\Db;
use Zero0719\HyperfApi\Exception\BusinessException;

class LogsService extends BaseService
{
    public function list()
    {
        $query = Log::query();

        $query->when($this->request->input('user_id'), function (Builder $query) {
            $query->where('user_id', $this->request->input('user_id'));
        });

        $query->when($this->request->input('url'), function (Builder $query) {
            $query->where('url', $this->request->input('url'));
        });

        $query->when($this->request->input('time'), function (Builder $query) {
            $query->where('created_at', '>=', $this->request->input('time')[0])
                ->where('created_at', '<=', $this->request->input('time')[1]);
        });

        $query->select([
            'id',
            'user_id',
            'url',
            'data',
            'ip',
            Db::raw('FROM_UNIXTIME(created_at, "%Y-%m-%d %H:%i:%s") as created_at')
        ]);

        $count = $query->count();

        $query->orderByDesc('id');

        $lists = $this->getForPage($query);

        return [
            'lists' => $lists,
            'count' => $count
        ];
    }

    public function show()
    {
        $log = Log::select([
            'id',
            'user_id',
            'url',
            'data',
            'ip',
            Db::raw('FROM_UNIXTIME(created_at, "%Y-%m-%d %H:%i:%s") as created_at')
        ])->find($this->request->route('id'));

        if (!$log) {
            throw new BusinessException('日志记录不存在');
        }

        return $log->toArray();
    }
}