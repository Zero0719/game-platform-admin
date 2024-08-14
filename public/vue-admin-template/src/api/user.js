import request from '@/utils/request'

export function login(data) {
  return request({
    url: '/admin/sessions',
    method: 'post',
    data
  })
}

export function getInfo(token) {
  return request({
    url: '/admin/me',
    method: 'get'
  })
}

export function logout() {
  return request({
    url: '/admin/sessions',
    method: 'delete'
  })
}

export function userList(params) {
  return request({
    url: '/admin/users',
    method: 'get',
    params
  })
}

export function createUser(data) {
  return request({
    url: '/admin/users',
    method: 'post',
    data
  })
}

export function showUser(id) {
  return request({
    url: `/admin/users/${id}`
  })
}

export function updateUser(id, data) {
  return request({
    url: `/admin/users/${id}`,
    method: 'put',
    data
  })
}

export function destroyUser(id) {
  return request({
    url: `/admin/users/${id}`,
    method: 'delete'
  })
}

export function changeStatus(id, status) {
  return request({
    url: `/admin/users/status/${id}`,
    method: 'put',
    data: { status }
  })
}

export function getRoles(id) {
  return request({
    url: `/admin/user/${id}/roles`
  })
}

export function grantRolesToUser(userId, roles) {
  return request({
    url: '/admin/syncRoleToUser',
    data: { userId, roles },
    method: 'post'
  })
}

export function testDownload() {
  return request({
    url: '/admin/download'
  })
}
