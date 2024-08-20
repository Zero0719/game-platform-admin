<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\Admin\User;
use App\Model\Payment;
use App\Service\Admin\BaseService;
use Hyperf\Database\Model\Builder;
use Zero0719\HyperfApi\Exception\BusinessException;

class PaymentService extends BaseService
{
    public $types = [
        ['id' => 1, 'name' => '微信支付'],
        ['id' => 2, 'name' => '支付宝']
    ];

    public function list()
    {
        $query = Payment::query();

        $query->when($this->request->input('name'), function (Builder $builder) {
            $builder->where('name', 'like', '%' . $this->request->input('name') . '%');
        });

        $query->when($this->request->input('paymentType'), function (Builder $builder) {
            $builder->where('type', $this->request->input('paymentType'));
        });

        $query->when($this->request->input('paymentProviderId'), function (Builder $builder) {
            $builder->where('provider_id', $this->request->input('paymentProviderId'));
        });

        $query->when($this->request->input('status') != '', function (Builder $builder) {
            $builder->where('type', $this->request->input('type'));
        });

        $count = $query->count();
        $query->with('provider');
        $lists = $this->getForPage($query);

        $types = array_column($this->types, 'name', 'id');

        $lists->transform(function ($item) use ($types) {
            $item->typeMap = $types[$item->type];
            return $item;
        });

        return [
            'count' => $count,
            'lists' => $lists,
        ];
    }

    public function create()
    {
        if (!Payment::create([
            'name' => $this->request->input('name'),
            'provider_id' => $this->request->input('providerId'),
            'type' => $this->request->input('paymentType'),
            'remark' => $this->request->input('remark'),
            'status' => $this->request->input('status'),
            'created_user' => User::getCurrentUserInfoFromContext()['id'],
            'created_at' => time(),
        ])) {
            throw new BusinessException('添加失败');
        }
    }

    public function update()
    {
        $payment = Payment::findOrFail($this->request->route('id'));
        if (!$payment->update([
            'name' => $this->request->input('name'),
            'provider_id' => $this->request->input('providerId'),
            'type' => $this->request->input('paymentType'),
            'remark' => $this->request->input('remark'),
            'status' => $this->request->input('status'),
            'updated_user' => User::getCurrentUserInfoFromContext()['id'],
            'updated_at' => time(),
        ])) {
            throw new BusinessException('更新失败');
        }
    }

    public function destroy()
    {
        $payment = Payment::findOrFail($this->request->route('id'));

        if (!$payment->delete()) {
            throw new BusinessException('删除失败');
        }
    }

    public function show()
    {
        $payment = Payment::findOrFail($this->request->route('id'));

        return $payment->toArray();
    }

    public function all()
    {
        return Payment::select(['id', 'name'])->get()->toArray();
    }

    public function paymentTypes()
    {
        return $this->types;
    }
}