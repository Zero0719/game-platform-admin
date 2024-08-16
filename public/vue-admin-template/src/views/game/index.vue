<template>
  <div class="app-container">
    <el-card class="search-form">
      <el-form :model="searchForm" :inline="true">
        <el-form-item label="游戏ID">
          <el-input v-model="searchForm.id" placeholder="请输入游戏ID" />
        </el-form-item>

        <el-form-item label="游戏名">
          <el-input v-model="searchForm.name" placeholder="请输入游戏名" />
        </el-form-item>

        <el-form-item label="">
          <el-button type="" @click="clearSearchForm">清 除</el-button>
          <el-button type="success" @click="search">搜 索</el-button>
        </el-form-item>
      </el-form>
    </el-card>

    <el-card>
      <div slot="header">
        <el-button type="success" @click="showDialog">添 加</el-button>
      </div>
      <el-table :data="pageData.lists">
        <el-table-column prop="id" label="游戏ID" />
        <el-table-column prop="name" label="游戏名" />
        <el-table-column label="状态">
          <template slot-scope="scope">
            <el-tag v-if="scope.row.status === 1" type="success">正 常</el-tag>
            <el-tag v-else type="danger">禁 用</el-tag>
          </template>
        </el-table-column>
        <el-table-column prop="created_at" label="添加时间" />
        <el-table-column label="操作">
          <template slot-scope="scope">
            <el-button type="" size="mini" @click="edit(scope.row.id)">编 辑</el-button>
            <el-button type="danger" size="mini" @click="destroy(scope.row.id)">删 除</el-button>
          </template>
        </el-table-column>
      </el-table>

      <el-pagination :total="pageData.count" :current-page="searchForm.page" :page-size="searchForm.pageSize" layout="total,prev,pager,next" @current-change="changePage" />
    </el-card>

    <component :is="pageComponent" :target-id="targetId" @submitSuccess="submitSuccess" @closeDialog="closeDialog" />
  </div>
</template>

<script>
import pageMixin from '@/mixins/pageMixin'
import { gameList, destroyGame } from '@/api/game'

export default {
  name: 'Games',
  mixins: [pageMixin],
  data() {
    return {
      pageUrl: gameList
    }
  },
  methods: {
    showDialog() {
      this.pageComponent = () => import('./form')
    },
    submitSuccess() {
      this.fetchData()
    },
    edit(id) {
      this.targetId = id
      this.showDialog()
    },
    destroy(id) {
      this.$confirm('确定要删除吗', '提示').then(() => {
        destroyGame(id).then(() => {
          this.$message.success('删除成功')
          this.fetchData()
        })
      })
    }
  }
}
</script>
