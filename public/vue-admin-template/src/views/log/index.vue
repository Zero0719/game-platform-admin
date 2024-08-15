<template>
  <div class="app-container">
    <el-card class="search-form">
      <el-form :model="searchForm" :inline="true">
        <el-form-item label="用户">
          <el-input v-model="searchForm.user_id" placeholder="" />
        </el-form-item>

        <el-form-item label="接口">
          <el-input v-model="searchForm.url" placeholder="method:url" />
        </el-form-item>

        <el-form-item label="时间">
          <el-input v-model="searchForm.time" placeholder="" />
        </el-form-item>

        <el-form-item label="">
          <el-button type="" @click="clearSearchForm">清 除</el-button>
          <el-button type="primary" @click="search">搜 索</el-button>
        </el-form-item>
      </el-form>
    </el-card>

    <el-card>
      <el-table :data="pageData.lists">
        <el-table-column prop="id" label="ID" />
        <el-table-column prop="user_id" label="用户" />
        <el-table-column prop="url" label="接口" />
        <el-table-column prop="ip" label="ip" />
        <el-table-column prop="created_at" label="时间" />
        <el-table-column label="操作">
          <template slot-scope="scope">
            <el-button type="" size="mini" @click="showComponent(scope.row.id)">查 看</el-button>
          </template>
        </el-table-column>
      </el-table>

      <el-pagination :total="pageData.count" :current-page="searchForm.page" :page-size="searchForm.pageSize" layout="total,prev,pager,next" @current-change="changePage" />
    </el-card>

    <component :is="pageComponent" :target-id="targetId" @closeDialog="closeDialog" />
  </div>
</template>

<script>
import { logList } from '@/api/log'

import pageMixin from '@/mixins/pageMixin'
export default {
  name: 'Log',
  mixins: [pageMixin],
  data() {
    return {
      pageUrl: logList
    }
  },
  methods: {
    showComponent(id) {
      this.targetId = id
      this.pageComponent = () => import('./detail')
    }
  }
}
</script>
