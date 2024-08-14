import request from '@/utils/request'

export function roleList(params) {
  return request({
    url: '/admin/roles',
    params
  })
}

export function createRole(data) {
  return request({
    url: '/admin/roles',
    method: 'post',
    data
  })
}

export function updateRole(id, data) {
  return request({
    url: `/admin/roles/${id}`,
    method: 'put',
    data
  })
}

export function showRole(id) {
  return request({
    url: `/admin/roles/${id}`,
    method: 'get'
  })
}

export function destroyRole(id) {
  return request({
    url: `/admin/roles/${id}`,
    method: 'delete'
  })
}

export function allRole() {
  return request({
    url: '/admin/all/roles'
  })
}

export function getPermissions(id) {
  return request({
    url: `/admin/role/${id}/permissions`
  })
}

export function grantPermissionsToRole(roleId, permissions) {
  return request({
    url: '/admin/syncPermissionToRole',
    method: 'post',
    data: { roleId, permissions }
  })
}
