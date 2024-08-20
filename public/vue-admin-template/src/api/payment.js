import request from '@/utils/request'

export function getPaymentTypes() {
  return request({
    url: '/admin/paymentTypes'
  })
}

export function createPayment(data) {
  return request({
    url: '/admin/payments',
    method: 'post',
    data
  })
}

export function updatePayment(id, data) {
  return request({
    url: `/admin/payments/${id}`,
    method: 'put',
    data
  })
}

export function destroyPayment(id) {
  return request({
    url: `/admin/payments/${id}`,
    method: 'delete'
  })
}

export function paymentList(params) {
  return request({
    url: '/admin/payments',
    method: 'get',
    params
  })
}

export function showPayment(id) {
  return request({
    url: `/admin/payments/${id}`
  })
}
