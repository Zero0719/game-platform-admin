import request from '@/utils/request'

export function roleList(params) {
  return request({
    url: '/admin/roles',
    params
  })
}
