<template>
  <div class="app-container">
    <el-card class="search-form">
      <el-form :model="searchForm" :inline="true">
        <el-form-item label="支付方式">
          <el-select v-model="searchForm.payType" placeholder="请选择支付方式" clearable>
            <el-option v-for="item in payTypes" :key="item.id" :value="item.id" :label="item.name" />
          </el-select>
        </el-form-item>
        <el-form-item label="支付商">
          <el-select v-model="searchForm.payPlatform" placeholder="请选择支付商" clearable>
            <el-option v-for="item in payPlatforms" :key="item.id" :value="item.id" :label="item.name" />
          </el-select>
        </el-form-item>

        <el-form-item label="">
          <el-button type="" @click="clearSearchForm">清 除</el-button>
          <el-button type="primary" @click="search">搜 索</el-button>
        </el-form-item>
      </el-form>
    </el-card>

    <el-card>
      <div slot="header">
        <el-button type="success" @click="loadDialog">添 加</el-button>
      </div>

      <el-table :data="pageData.lists">
        <el-table-column prop="id" label="ID" />
      </el-table>
    </el-card>

    <component :is="pageComponent" :pay-types="payTypes" :pay-platforms="payPlatforms" :target-id="targetId" @closeDialog="closeDialog" @submitSuccess="submitSuccess" />
  </div>
</template>

<script>
import pageMixin from '@/mixins/pageMixin'
import { getPayPlatform, getPayType } from '@/api/payment'

export default {
  name: 'Payments',
  mixins: [pageMixin],
  data() {
    return {
      payTypes: [],
      payPlatforms: []
    }
  },
  mounted() {
    getPayPlatform().then(res => {
      this.payPlatforms = res.data
    })

    getPayType().then(res => {
      this.payTypes = res.data
    })
  },
  methods: {
    loadDialog() {
      this.pageComponent = () => import('./form')
    }
  }
}
</script>
