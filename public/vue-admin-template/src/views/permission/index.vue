<template>
  <div class="app-container">
    <el-card class="search-form">
      <el-form :model="searchForm" :inline="true">
        <el-form-item label="权限名">
          <el-input v-model="searchForm.name" placeholder="" />
        </el-form-item>

        <el-form-item label="权限标识">
          <el-input v-model="searchForm.flag" placeholder="" />
        </el-form-item>

        <el-form-item label="">
          <el-button type="primary" @click="search">搜 索</el-button>
          <el-button type="warning" @click="clearSearchForm">清 除</el-button>
        </el-form-item>
      </el-form>
    </el-card>

    <el-card>
      <el-table v-loading="loading" :data="pageData.lists">
        <el-table-column prop="id" label="ID" />
        <el-table-column prop="name" label="权限名" />
        <el-table-column prop="flag" label="权限标识" />
      </el-table>

      <el-pagination :total="pageData.count" :current-page="searchForm.page" :page-size="searchForm.pageSize" layout="total,prev,pager,next" @current-change="changePage" />
    </el-card>
  </div>
</template>

<script>
import { permissionList } from '@/api/permission'
import pageMixin from '@/mixins/pageMixin'

export default {
  name: 'Users',
  mixins: [pageMixin],
  data() {
    return {
      pageUrl: permissionList
    }
  }
}
</script>
