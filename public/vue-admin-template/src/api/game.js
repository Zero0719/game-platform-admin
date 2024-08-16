import request from '@/utils/request'

export function gameList(params) {
  return request({
    url: '/admin/games',
    params
  })
}

export function createGame(data) {
  return request({
    url: '/admin/games',
    method: 'post',
    data
  })
}

export function updateGame(id, data) {
  return request({
    url: `/admin/games/${id}`,
    method: 'put',
    data
  })
}

export function destroyGame(id) {
  return request({
    url: `/admin/games/${id}`,
    method: 'delete'
  })
}

export function showGame(id) {
  return request({
    url: `/admin/games/${id}`
  })
}

export function allGame() {
  return request({
    url: '/admin/all/games'
  })
}
