import request from '@/utils/request'

export function permissionList(params) {
  return request({
    url: '/admin/permissions',
    params
  })
}

export function createPermission(data) {
  return request({
    url: '/admin/permissions',
    method: 'post',
    data
  })
}

export function updatePermission(id, data) {
  return request({
    url: '/admin/permissions/' + id,
    method: 'put',
    data
  })
}

export function showPermission(id) {
  return request({
    url: '/admin/permissions/' + id
  })
}

export function destroyPermission(id) {
  return request({
    url: '/admin/permissions/' + id,
    method: 'delete'
  })
}
