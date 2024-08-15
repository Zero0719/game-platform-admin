import request from '@/utils/request'

export function logList(params) {
  return request({
    url: '/admin/logs',
    params
  })
}

export function showLog(id) {
  return request({
    url: `/admin/logs/${id}`
  })
}
