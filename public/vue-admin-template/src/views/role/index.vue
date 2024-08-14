<template>
  <div class="app-container">
    <el-card class="search-form">
      <el-form :model="searchForm" :inline="true">
        <el-form-item label="角色名">
          <el-input v-model="searchForm.name" placeholder="" />
        </el-form-item>

        <el-form-item label="角色标识">
          <el-input v-model="searchForm.flag" placeholder="" />
        </el-form-item>

        <el-form-item label="">
          <el-button type="primary" @click="search">搜 索</el-button>
          <el-button type="warning" @click="clearSearchForm">清 除</el-button>
        </el-form-item>
      </el-form>
    </el-card>

    <el-card>
      <div slot="header">
        <el-button type="success" @click="showFormComponent">添 加</el-button>
      </div>
      <el-table v-loading="loading" :data="pageData.lists">
        <el-table-column prop="id" label="ID" />
        <el-table-column prop="name" label="角色名" />
        <el-table-column prop="flag" label="角色标识" />
        <el-table-column label="操作">
          <template slot-scope="scope">
            <el-button type="" size="mini" @click="edit(scope.row.id)">编 辑</el-button>
            <el-button type="success" size="mini" @click="grantPermission(scope.row.id)">授 权</el-button>
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
import { roleList, destroyRole } from '@/api/role'
import pageMixin from '@/mixins/pageMixin'

export default {
  name: 'Users',
  mixins: [pageMixin],
  data() {
    return {
      pageUrl: roleList
    }
  },
  mounted() {
    this.fetchData()
  },
  methods: {
    showFormComponent() {
      this.pageComponent = () => import('./form')
    },
    grantPermission(id) {
      this.targetId = id
      this.pageComponent = () => import('./grant_permission')
    },
    submitSuccess() {
      this.fetchData()
    },
    edit(id) {
      this.targetId = id
      this.showFormComponent()
    },
    destroy(id) {
      this.$confirm('确定要删除吗?', '提示').then(() => {
        destroyRole(id).then(() => {
          this.$message.success('删除成功')
          this.fetchData
        })
      })
    }
  }
}
</script>
