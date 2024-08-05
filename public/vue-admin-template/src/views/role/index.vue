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
      <el-table v-loading="loading" :data="pageData.lists">
        <el-table-column prop="id" label="ID" />
        <el-table-column prop="name" label="角色名" />
        <el-table-column prop="flag" label="角色标识" />
      </el-table>

      <el-pagination :total="pageData.count" :current-page="searchForm.page" :page-size="searchForm.pageSize" layout="total,prev,pager,next" @current-change="changePage" />
    </el-card>
  </div>
</template>

<script>
import { roleList } from '@/api/role'
import pageMixin from '@/mixins/pageMixin'

export default {
  name: 'Users',
  mixins: [pageMixin],
  data() {
    return {
      searchForm: {
        page: 1,
        pageSize: 15,
        name: '',
        flag: ''
      },
      responseData: {
        lists: [],
        count: 0
      },
      loading: false
    }
  },
  mounted() {
    this.fetchData()
  },
  methods: {
    async fetchData() {
      this.loading = true
      const result = await roleList(this.searchForm)
      this.responseData = result.data
      this.loading = false
    }
  }
}
</script>
