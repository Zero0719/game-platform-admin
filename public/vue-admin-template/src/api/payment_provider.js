import request from '@/utils/request'

export function paymentProviderList(params) {
  return request({
    url: '/admin/paymentProviders',
    params
  })
}

export function createPaymentProvider(data) {
  return request({
    url: '/admin/paymentProviders',
    data,
    method: 'post'
  })
}

export function updatePaymentProvider(id, data) {
  return request({
    url: `/admin/paymentProviders/${id}`,
    data,
    method: 'put'
  })
}

export function destroyPaymentProvider(id) {
  return request({
    url: `/admin/paymentProviders/${id}`,
    method: 'delete'
  })
}

export function showPaymentProvider(id) {
  return request({
    url: `/admin/paymentProviders/${id}`
  })
}

export function allPaymentProvider() {
  return request({
    url: '/admin/all/paymentProviders'
  })
}
