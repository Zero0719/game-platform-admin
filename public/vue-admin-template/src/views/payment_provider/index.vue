<template>
  <div class="app-container">
    <el-card class="search-form">
      <el-form :model="searchForm" :inline="true">
        <el-form-item label="支付商">
          <el-input v-model="searchForm.name" placeholder="请输入支付商名称" />
        </el-form-item>

        <el-form-item label="app_id">
          <el-input v-model="searchForm.appId" placeholder="请输入app_id" />
        </el-form-item>

        <el-form-item label="状态">
          <el-select v-model="searchForm.status" placeholder="请选择状态" clearable>
            <el-option :value="0" label="停用" />
            <el-option :value="1" label="正常" />
          </el-select>
        </el-form-item>

        <el-form-item label="接入状态">
          <el-select v-model="searchForm.isAccess" placeholder="请选择接入状态" clearable>
            <el-option :value="0" label="未接入" />
            <el-option :value="1" label="已接入" />
          </el-select>
        </el-form-item>

        <el-form-item label="">
          <el-button type="" @click="clearSearchForm">清 除</el-button>
          <el-button type="success" @click="search">搜 索</el-button>
        </el-form-item>
      </el-form>
    </el-card>

    <el-card>
      <div slot="header">
        <el-button type="success" @click="loadDialog">添 加</el-button>
      </div>

      <el-table :data="pageData.lists">
        <el-table-column prop="id" label="id" />
        <el-table-column prop="name" label="支付商" />
        <el-table-column prop="app_id" label="app_id" />
        <el-table-column label="状态">
          <template slot-scope="scope">
            <el-tag v-if="scope.row.status === 1" type="success">正常</el-tag>
            <el-tag v-else type="danger">禁用</el-tag>
          </template>
        </el-table-column>
        <el-table-column label="接入状态">
          <template slot-scope="scope">
            <el-tag v-if="scope.row.is_access === 1" type="success">已接入</el-tag>
            <el-tag v-else type="danger">未接入</el-tag>
          </template>
        </el-table-column>
        <el-table-column label="操作">
          <template slot-scope="scope">
            <el-button type="" size="mini" @click="edit(scope.row.id)">编 辑</el-button>
            <el-button type="danger" size="mini" @click="destroy(scope.row.id)">删 除</el-button>
          </template>
        </el-table-column>
      </el-table>
      <el-pagination :total="pageData.count" :current-page="searchForm.page" :page-size="searchForm.perPage" layout="total,prev,pager,next" @current-change="changePage" />
    </el-card>

    <component :is="pageComponent" :target-id="targetId" @closeDialog="closeDialog" @submitSuccess="submitSuccess" />
  </div>
</template>

<script>
import pageMixin from '@/mixins/pageMixin'
import { destroyPaymentProvider, paymentProviderList } from '@/api/payment_provider'

export default {
  mixins: [pageMixin],
  data() {
    return {
      pageUrl: paymentProviderList
    }
  },
  methods: {
    loadDialog() {
      this.pageComponent = () => import('./form')
    },
    submitSuccess() {
      this.fetchData()
    },
    edit(id) {
      this.targetId = id
      this.loadDialog()
    },
    destroy(id) {
      this.$confirm('确定要删除吗?', '提示').then(() => {
        destroyPaymentProvider(id).then(() => {
          this.$message.success('删除成功')
          this.fetchData()
        })
      })
    }
  }
}
</script>
