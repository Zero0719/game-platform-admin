<template>
  <el-dialog title="" :visible.sync="show" :close-on-click-modal="false" @close="closeDialog">
    <el-form :model="form" label-position="top">
      <el-form-item label="支付">
        <el-input v-model="form.name" placeholder="后台便于分辨的名称" />
      </el-form-item>

      <el-form-item label="支付方式">
        <el-select v-model="form.payTypes" placeholder="请选择支付方式" clearable>
          <el-option v-for="item in payPlatforms" :key="item.id" :value="item.id" :label="item.name" />
        </el-select>
      </el-form-item>

      <el-form-item label="支付商">
        <el-select v-model="form.payPlatForm" placeholder="请选择支付商" clearable>
          <el-option v-for="item in payTypes" :key="item.id" :value="item.id" :label="item.name" />
        </el-select>
      </el-form-item>

      <el-form-item label="">
        <el-button type="success" @click="submit">提 交</el-button>
      </el-form-item>
    </el-form>
  </el-dialog>
</template>

<script>
import dialogMixin from '@/mixins/dialogMixin'

export default {
  mixins: [dialogMixin],
  props: {
    targetId: {
      type: Number,
      default: 0
    },
    payTypes: {
      type: Array,
      default: () => []
    },
    payPlatforms: {
      type: Array,
      default: () => []
    }
  },
  data() {
    return {
      form: {}
    }
  },
  methods: {
    submit() {}
  }
}
</script>
