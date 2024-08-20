<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\Admin\User;
use App\Model\PaymentProvider;
use App\Service\Admin\BaseService;
use Hyperf\Database\Model\Builder;
use Zero0719\HyperfApi\Exception\BusinessException;

class PaymentProviderService extends BaseService
{
    public function list()
    {
        $query = PaymentProvider::query();

        $query->when($this->request->input('name'), function (Builder $query) {
            $query->where('name', 'like', '%' . $this->request->input('name') . '%');
        });

        $query->when($this->request->input('appId'), function (Builder $query) {
           $query->where('app_id', $this->request->input('appId'));
        });

        $query->when($this->request->input('status') != '', function (Builder $query) {
            $query->where('status', $this->request->input('status'));
        });

        $query->when($this->request->input('isAccess') != '', function (Builder $query) {
            $query->where('is_access', $this->request->input('isAccess'));
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
        if (!PaymentProvider::create([
            'name' => $this->request->input('name'),
            'app_id' => $this->request->input('appId', ''),
            'app_secret' => $this->request->input('appSecret', ''),
            'status' => $this->request->input('status', 1),
            'is_access' => $this->request->input('isAccess', 0),
            'notify_url' => $this->request->input('notifyUrl', ''),
            'remark' => $this->request->input('remark', ''),
            'created_user' => User::getCurrentUserInfoFromContext()['id'],
            'created_at' => time()
        ])) {
            throw new BusinessException('添加失败');
        }
    }

    public function update()
    {
        $paymentProvider = PaymentProvider::findOrFail($this->request->route('id'));

        if (!$paymentProvider->update([
            'name' => $this->request->input('name'),
            'app_id' => $this->request->input('appId', ''),
            'app_secret' => $this->request->input('appSecret', ''),
            'status' => $this->request->input('status', 1),
            'is_access' => $this->request->input('isAccess', 0),
            'notify_url' => $this->request->input('notifyUrl', ''),
            'remark' => $this->request->input('remark', ''),
            'updated_user' => User::getCurrentUserInfoFromContext()['id'],
            'updated_at' => time()
        ])) {
            throw new BusinessException('修改失败');
        }
    }

    public function destroy()
    {
        $paymentProvider = PaymentProvider::findOrFail($this->request->route('id'));

        if (!$paymentProvider->delete()) {
            throw new BusinessException('删除失败');
        }
    }

    public function show()
    {
        $paymentProvider = PaymentProvider::findOrFail($this->request->route('id'));

        return $paymentProvider->toArray();
    }

    public function all()
    {
        return PaymentProvider::select(['id', 'name'])->get()->toArray();
    }
}