import request from '@/utils/request'

export function getPayPlatform() {
  return request({
    url: '/admin/payment/platform'
  })
}

export function getPayType() {
  return request({
    url: '/admin/payment/type'
  })
}
