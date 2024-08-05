<template>
  <div class="app-container">
    <el-card class="search-form">
      <el-form :model="searchForm" :inline="true">
        <el-form-item label="用户名">
          <el-input v-model="searchForm.username" placeholder="" />
        </el-form-item>

        <el-form-item label="">
          <el-button type="primary" @click="search">搜 索</el-button>
          <el-button type="warning" @click="clearSearchForm">清 除</el-button>
        </el-form-item>
      </el-form>
    </el-card>

    <el-card>
      <div slot="header">
        <el-button type="success" @click="showPageComponent">添 加</el-button>
      </div>
      <el-table v-loading="loading" :data="pageData.lists">
        <el-table-column prop="id" label="ID" />
        <el-table-column prop="username" label="用户名" />
        <el-table-column label="状态">
          <template slot-scope="scope">
            <el-switch v-model="scope.row.status" :active-value="1" :inactive-value="0" @change="handleSwitchChange(scope.row, scope.$index)" />
          </template>
        </el-table-column>
        <el-table-column label="操作">
          <template slot-scope="scope">
            <el-button type="" size="mini" @click="edit(scope.row.id)">编 辑</el-button>
            <el-button type="danger" size="mini" @click="destroy(scope.row.id)">删 除</el-button>
          </template>
        </el-table-column>
      </el-table>

      <el-pagination :total="pageData.count" :current-page="searchForm.page" :page-size="searchForm.pageSize" layout="total,prev,pager,next" @current-change="changePage" />
    </el-card>

    <component :is="pageComponent" :target-id="targetId" @closeDialog="closeDialog" @submitSuccess="submitSuccess" />
  </div>
</template>

<script>
import { userList, destroyUser, changeStatus } from '@/api/user'
import pageMixin from '@/mixins/pageMixin'

export default {
  name: 'Users',
  mixins: [pageMixin],
  data() {
    return {
      pageUrl: userList
    }
  },
  methods: {
    showPageComponent() {
      this.pageComponent = () => import('./form')
    },
    submitSuccess() {
      this.fetchData()
    },
    edit(id) {
      this.targetId = id
      this.showPageComponent()
    },
    destroy(id) {
      this.$confirm('确定要删除吗?', '提示').then(() => {
        destroyUser(id).then(() => {
          this.$message.success('删除成功')
          this.fetchData()
        })
      })
    },
    handleSwitchChange(row, index) {
      changeStatus(row.id, row.status).then(() => {
        this.$message.success('切换状态成功')
      }).catch(() => {
        this.pageData.lists[index].status = row.status === 0 ? 1 : 0
      })
    }
  }
}
</script>
