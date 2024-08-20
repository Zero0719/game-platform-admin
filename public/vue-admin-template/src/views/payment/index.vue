<template>
  <div class="app-container">
    <el-card class="search-form">
      <el-form :model="searchForm" :inline="true">
        <el-form-item label="支付方式名称">
          <el-input v-model="searchForm.name" placeholder="请输入支付方式的命名" />
        </el-form-item>

        <el-form-item label="支付商">
          <el-select v-model="searchForm.paymentProviderId" placeholder="请选择支付商" clearable>
            <el-option v-for="item in paymentProviders" :key="item.id" :value="item.id" :label="item.name" />
          </el-select>
        </el-form-item>

        <el-form-item label="支付类型">
          <el-select v-model="searchForm.paymentType" placeholder="请选址支付类型" clearable>
            <el-option v-for="item in paymentTypes" :key="item.id" :value="item.id" :label="item.name" />
          </el-select>
        </el-form-item>

        <el-form-item label="状态">
          <el-select v-model="searchForm.status" placeholder="请选择状态">
            <el-option :value="1" label="正常" />
            <el-option :value="0" label="禁用" />
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
        <el-table-column prop="id" label="ID" />
        <el-table-column prop="name" label="名称" />
        <el-table-column prop="provider.name" label="支付商" />
        <el-table-column prop="typeMap" label="支付类型" />
        <el-table-column label="状态">
          <template slot-scope="scope">
            <el-tag v-if="scope.row.status === 1" type="success">正 常</el-tag>
            <el-tag v-else type="danger">禁 用</el-tag>
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

    <component :is="pageComponent" :target-id="targetId" :payment-providers="paymentProviders" :payment-types="paymentTypes" @closeDialog="closeDialog" @submitSuccess="submitSuccess" />
  </div>
</template>

<script>
import { destroyPayment, getPaymentTypes, paymentList } from '@/api/payment'
import { allPaymentProvider } from '@/api/payment_provider'
import pageMixin from '@/mixins/pageMixin'

export default {
  name: 'Payments',
  mixins: [pageMixin],
  data() {
    return {
      pageUrl: paymentList,
      paymentProviders: [],
      paymentTypes: []
    }
  },
  mounted() {
    allPaymentProvider().then(res => {
      this.paymentProviders = res.data
    })

    getPaymentTypes().then(res => {
      this.paymentTypes = res.data
    })
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
    destroy() {
      this.$confirm('确定要删除吗?', '提示').then(() => {
        destroyPayment(this.targetId).then(() => {
          this.$message.success('删除成功')
          this.fetchData()
        })
      })
    }
  }
}
</script>
